<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseListResource;
use App\Http\Resources\CourseResource;
use App\Models\CourseCategory;
use App\Models\Log as ModelsLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search', '');
        $perPage = request('per_page', 10);
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');
        return CourseListResource::collection(Course::where('title', 'like', "%$search%")->orWhere('content', 'like', "$search")->orderBy($sortField, $sortDirection)->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CourseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        $image = $data['image'] ?? NULL;

        if($image){
            $relatevePath = $this->saveImage($image);
            // $data['image'] = URL::to(Storage::url($relatevePath));
            $data['image'] = URL::to('/storage/public/'.$relatevePath);
            $data['image_mime'] = $image->getClientMimeType();
            $data['image_size'] = $image->getSize();
            

            $data['tags'] = json_encode(explode(',', $data['tags']));
        }else{
            $data['tags'] = json_encode($data['tags']);
        }

        $article = Course::create($data);
        ModelsLog::create([
            'username'=> Auth::user()->username,
            'action'=>'新增課程',
            'to'=>'course',
            'to_id'=>null,
            'content'=> json_encode($data),
            'created_by'=>Auth::id(),
            'updated_by'=>Auth::id(),
        ]);
        return new CourseResource($article);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return new CourseResource($course);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CourseRequest  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, Course $course)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;

        $image = $data['image'] ?? null;
        if($image){
            $relativePath = $this->saveImage($image);
            // $data['image'] = URL::to(Storage::url($relativePath));
            $data['image'] = URL::to('/storage/public/'.$relativePath);

            $data['image_mime'] = $image->getClientMimeType();
            $data['image_size'] = $image->getSize();

            if($course->image){
                Storage::deleteDirectory('/public/' . dirname($course->image));
            }
            $data['tags'] = json_encode(explode(',', $data['tags']));
        }else{
            $data['tags'] = json_encode($data['tags']);
        }
        $course->update($data);

        ModelsLog::create([
            'username'=> Auth::user()->username,
            'action'=>'更新課程',
            'to'=>'course',
            'to_id'=>$course->id,
            'content'=> json_encode($data),
            'created_by'=>Auth::id(),
            'updated_by'=>Auth::id(),
        ]);
        return new CourseResource($course);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();

        ModelsLog::create([
            'username'=> Auth::user()->username,
            'action'=>'刪除課程',
            'to'=>'course',
            'to_id'=>$course->id,
            'content'=> "刪除$course->title",
            'created_by'=>Auth::id(),
            'updated_by'=>Auth::id(),
        ]);

        return response()->noContent(); //回應204
    }
    public function saveImage(UploadedFile $image){
        $path = 'images/' . Str::random();
        if(!Storage::exists($path)){
            Storage::makeDirectory($path, 0755, true);
        }
        if(!Storage::putFileAs('public/' . $path, $image, $image->getClientOriginalName())){
            throw new \Exception("Unable to save file \"{$image->getClientOriginalName()}\"");
        }

        return $path . '/' .$image->getClientOriginalName();
    }
    public function isExistCourse(Request $req){
        $course = Course::find($req->id);
        return ($course) ? true :false;
    }
    public function deleteItems(Course $course, Request $req){
        $ids = $req->ids;
        $course->whereIn('id', $ids)->delete();
        ModelsLog::create([
            'username'=> Auth::user()->username,
            'action'=>'刪除多個課程',
            'to'=>'course',
            'to_id'=>0,
            'content'=> "刪除".json_encode($ids),
            'created_by'=>Auth::id(),
            'updated_by'=>Auth::id(),
        ]);

        return response()->noContent();
    }
    public function getCategories(Request $req)
    {
        return CourseCategory::all();
    }
}
