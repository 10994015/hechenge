<?php

namespace App\Http\Controllers;

use App\Models\CourseTag;
use App\Http\Requests\CourseTagRequest;
use App\Http\Resources\CourseTagResource;
use Illuminate\Http\Request;

class CourseTagController extends Controller
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
        return CourseTagResource::collection(CourseTag::where('name', 'like', "%$search%")->orderBy($sortField, $sortDirection)->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CourseTagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseTagRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        $category = CourseTag::create($data);

        return new CourseTagResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseTag  $courseTag
     * @return \Illuminate\Http\Response
     */
    public function show(CourseTag $courseTag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CourseTagRequest  $request
     * @param  \App\Models\CourseTag  $courseTag
     * @return \Illuminate\Http\Response
     */
    public function update(CourseTagRequest $request, CourseTag $courseTag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseTag  $courseTag
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = CourseTag::find($id)->delete();
        // $category->delete();

        return response()->noContent(); //回應204
    }
    public function deleteItems(CourseTag $category, Request $req){
        $ids = $req->ids;
        $category->whereIn('id', $ids)->delete();

        return response()->noContent();
    }
}
