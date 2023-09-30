<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Http\Requests\BannerRequest;
use App\Http\Resources\BannerListResource;
use App\Http\Resources\BannerResource;
use App\Models\Log as ModelsLog;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class BannerController extends Controller
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
        return BannerListResource::collection(Banner::where('image', 'like', "%$search%")->orderBy($sortField, $sortDirection)->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\BannerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannerRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;
        $data['sort'] = Banner::select('sort')->max('sort') + 1;
        
        $image = $data['image'] ?? NULL;

        if($image){
            $relatevePath = $this->saveImage($image);
            // $data['image'] = URL::to(Storage::url($relatevePath));
            $data['image'] = URL::to('/storage/public/'.$relatevePath);
            $data['image_mime'] = $image->getClientMimeType();
            $data['image_size'] = $image->getSize();
        }

        $banner = Banner::create($data);

        ModelsLog::create([
            'username'=> Auth::user()->username,
            'action'=>'新增輪播圖',
            'to'=>'banner',
            'to_id'=>null,
            'content'=> json_encode($data),
            'created_by'=>Auth::id(),
            'updated_by'=>Auth::id(),
        ]);

        return new BannerResource($banner);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        return new BannerResource($banner);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BannerRequest  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(BannerRequest $request, Banner $banner)
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

            if($banner->image){
                Storage::deleteDirectory('/public/' . dirname($banner->image));
            }
        }
        $banner->update($data);

        ModelsLog::create([
            'username'=> Auth::user()->username,
            'action'=>'更新輪播圖',
            'to'=>'banner',
            'to_id'=>$banner->id,
            'content'=> json_encode($data),
            'created_by'=>Auth::id(),
            'updated_by'=>Auth::id(),
        ]);
        return new BannerResource($banner);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();

        ModelsLog::create([
            'username'=> Auth::user()->username,
            'action'=>'刪除輪播圖',
            'to'=>'banner',
            'to_id'=>$banner->id,
            'content'=> "刪除$banner->image",
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
    public function isExistBanner(Request $req){
        $banner = Banner::find($req->id);
        return ($banner) ? true :false;
    }
    public function deleteItems(Banner $banner, Request $req){
        $ids = $req->ids;
        $banner->whereIn('id', $ids)->delete();
        ModelsLog::create([
            'username'=> Auth::user()->username,
            'action'=>'刪除多張輪播圖',
            'to'=>'banner',
            'to_id'=>0,
            'content'=> "刪除".json_encode($ids),
            'created_by'=>Auth::id(),
            'updated_by'=>Auth::id(),
        ]);
        return response()->noContent();
    }
}
