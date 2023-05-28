<?php

namespace App\Http\Controllers;

use App\Models\TeacherCategory;
use App\Http\Requests\TeacherCategoryRequest;
use App\Http\Resources\TeacherCategoryResource;
use Illuminate\Http\Request;

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

        return response()->noContent(); //回應204
    }
    public function deleteItems(TeacherCategory $category, Request $req){
        $ids = $req->ids;
        $category->whereIn('id', $ids)->delete();

        return response()->noContent();
    }
}
