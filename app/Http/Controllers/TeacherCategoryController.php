<?php

namespace App\Http\Controllers;

use App\Models\TeacherCategory;
use App\Http\Requests\TeacherCategoryRequest;
use App\Http\Resources\TeacherCategoryResource;
use Illuminate\Http\Request;
use App\Models\Log as ModelsLog;
use Illuminate\Support\Facades\Auth;

class TeacherCategoryController extends Controller
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
        return TeacherCategoryResource::collection(TeacherCategory::where('name', 'like', "%$search%")->orderBy($sortField, $sortDirection)->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TeacherCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeacherCategoryRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        $category = TeacherCategory::create($data);
        ModelsLog::create([
            'username'=> Auth::user()->username,
            'action'=>'新增師資分類',
            'to'=>'teacher-category',
            'to_id'=>null,
            'content'=> json_encode($data),
            'created_by'=>Auth::id(),
            'updated_by'=>Auth::id(),
        ]);
        return new TeacherCategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TeacherCategory  $teacherCategory
     * @return \Illuminate\Http\Response
     */
    public function show(TeacherCategory $teacherCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TeacherCategoryRequest  $request
     * @param  \App\Models\TeacherCategory  $teacherCategory
     * @return \Illuminate\Http\Response
     */
    public function update(TeacherCategoryRequest $request, TeacherCategory $teacherCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TeacherCategory  $teacherCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = TeacherCategory::find($id)->delete();
        ModelsLog::create([
            'username'=> Auth::user()->username,
            'action'=>'刪除師資分類',
            'to'=>'teacher-category',
            'to_id'=>$id,
            'content'=> "刪除$category->name",
            'created_by'=>Auth::id(),
            'updated_by'=>Auth::id(),
        ]);
        return response()->noContent(); //回應204
    }
    public function deleteItems(TeacherCategory $category, Request $req){
        $ids = $req->ids;
        $category->whereIn('id', $ids)->delete();
        ModelsLog::create([
            'username'=> Auth::user()->username,
            'action'=>'刪除多個師資分類',
            'to'=>'teacher-category',
            'to_id'=>0,
            'content'=> "刪除".json_encode($ids),
            'created_by'=>Auth::id(),
            'updated_by'=>Auth::id(),
        ]);
        return response()->noContent();
    }
}
