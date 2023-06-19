<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Http\Requests\LetterRequest;
use App\Http\Resources\LetterResource;
use Illuminate\Http\Request;
use App\Models\Log as ModelsLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        $date = request('date', 1);
        if($date == 1){
            $startTime = Carbon::now()->startOfWeek(); 
            $endTime = Carbon::now()->endOfWeek(); 
        }elseif($date==2){
            $startTime = Carbon::now()->startOfMonth(); 
            $endTime = Carbon::now()->endOfMonth(); 
        }elseif($date==3){
            $startTime = '1900-01-01'; 
            $endTime = now(); 
        }else{
            $startTime = Carbon::now()->startOfWeek(); 
            $endTime = Carbon::now()->endOfWeek(); 
        }
        Log::info($date);
        $perPage = request('per_page', 10);
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');
        return LetterResource::collection(Letter::whereBetween('created_at', [$startTime, $endTime])->where('name', 'like', "%$search%")->orWhere('content', 'like', "$search")->orderBy($sortField, $sortDirection)->paginate($perPage));
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
        $letter->delete();

        ModelsLog::create([
            'username'=> Auth::user()->username,
            'action'=>'刪除信件',
            'to'=>'letter',
            'to_id'=>$letter->id,
            'content'=> "刪除".$letter->name . "($letter->phone)",
            'created_by'=>Auth::id(),
            'updated_by'=>Auth::id(),
        ]);

        return response()->noContent(); //回應204
    }

    public function isExistLetter(Request $req){
        $letter = Letter::find($req->id);
        return ($letter) ? true :false;
    }
    public function deleteItems(Letter $letter, Request $req){
        $ids = $req->ids;
        $letter->whereIn('id', $ids)->delete();
        ModelsLog::create([
            'username'=> Auth::user()->username,
            'action'=>'刪除信件',
            'to'=>'letter',
            'to_id'=>0,
            'content'=> "刪除".json_encode($ids),
            'created_by'=>Auth::id(),
            'updated_by'=>Auth::id(),
        ]);
        return response()->noContent();
    }
}
