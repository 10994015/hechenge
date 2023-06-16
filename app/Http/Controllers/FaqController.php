<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Http\Requests\FaqRequest;
use App\Http\Resources\FaqListResource;
use App\Http\Resources\FaqResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class FaqController extends Controller
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
        return FaqListResource::collection(Faq::where('question', 'like', "%$search%")->orWhere('content', 'like', "$search")->orderBy($sortField, $sortDirection)->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\FaqRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FaqRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        
        $faq = Faq::create($data);

        return new FaqResource($faq);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        return new FaqResource($faq);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\FaqRequest  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(FaqRequest $request, Faq $faq)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;
      
        $faq->update($data);
        return new FaqResource($faq);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

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

    public function isExistFaq(Request $req){
        $faq = Faq::find($req->id);
        return ($faq) ? true :false;
    }
    public function deleteItems(Faq $faq, Request $req){
        $ids = $req->ids;
        $faq->whereIn('id', $ids)->delete();

        return response()->noContent();
    }
}
