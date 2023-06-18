<?php

namespace App\Http\Controllers;

use App\Models\CourseCategory;
use App\Http\Requests\CourseCategoryRequest;
use App\Http\Resources\CourseCategoryResource;
use App\Models\Log as ModelsLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseCategoryController extends Controller
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
        $grade = request('grade', '');
        return CourseCategoryResource::collection(CourseCategory::where([['name', 'like', "%$search%"], ['grade', 'like', "%$grade%"]])->orderBy($sortField, $sortDirection)->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CourseCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseCategoryRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        $category = CourseCategory::create($data);

        ModelsLog::create([
            'username'=> Auth::user()->username,
            'action'=>'新增課程分類',
            'to'=>'course-category',
            'to_id'=>null,
            'content'=> json_encode($data),
            'created_by'=>Auth::id(),
            'updated_by'=>Auth::id(),
        ]);

        return new CourseCategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseCategory  $courseCategory
     * @return \Illuminate\Http\Response
     */
    public function show(CourseCategory $courseCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CourseCategoryRequest  $request
     * @param  \App\Models\CourseCategory  $courseCategory
     * @return \Illuminate\Http\Response
     */
    public function update(CourseCategoryRequest $request, CourseCategory $courseCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseCategory  $courseCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = CourseCategory::find($id)->delete();
        // $category->delete();
        ModelsLog::create([
            'username'=> Auth::user()->username,
            'action'=>'刪除課程分類',
            'to'=>'course-category',
            'to_id'=>$id,
            'content'=> "刪除$category->name",
            'created_by'=>Auth::id(),
            'updated_by'=>Auth::id(),
        ]);
        return response()->noContent(); //回應204
    }
    public function deleteItems(CourseCategory $category, Request $req){
        $ids = $req->ids;
        $category->whereIn('id', $ids)->delete();
        ModelsLog::create([
            'username'=> Auth::user()->username,
            'action'=>'刪除多個課程分類',
            'to'=>'course-category',
            'to_id'=>0,
            'content'=> "刪除".json_encode($ids),
            'created_by'=>Auth::id(),
            'updated_by'=>Auth::id(),
        ]);
        return response()->noContent();
    }
}
