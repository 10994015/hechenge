<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Http\Requests\LetterRequest;
use App\Http\Resources\LetterResource;
use Illuminate\Http\Request;

class LetterController extends Controller
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
        return LetterResource::collection(Letter::where('name', 'like', "%$search%")->orWhere('content', 'like', "$search")->orderBy($sortField, $sortDirection)->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\LetterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LetterRequest $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Letter  $letter
     * @return \Illuminate\Http\Response
     */
    public function show(Letter $letter)
    {
        return new LetterResource($letter);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\LetterRequest  $request
     * @param  \App\Models\Letter  $letter
     * @return \Illuminate\Http\Response
     */
    public function update(LetterRequest $request, Letter $letter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Letter  $letter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Letter $letter)
    {
        //
    }

    public function isExistLetter(Request $req){
        $letter = Letter::find($req->id);
        return ($letter) ? true :false;
    }
    public function deleteItems(Letter $letter, Request $req){
        $ids = $req->ids;
        $letter->whereIn('id', $ids)->delete();

        return response()->noContent();
    }
}
