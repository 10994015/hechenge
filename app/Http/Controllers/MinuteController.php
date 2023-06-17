<?php

namespace App\Http\Controllers;

use App\Models\Minute;
use App\Http\Requests\MinuteRequest;
use App\Http\Resources\MinuteResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MinuteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $startTime = Carbon::now()->startOfDay();
        $endTime = Carbon::now()->endOfDay();  
        $search = request('search', '');
        Log::info($search);
        if($search == null || $search == 1 || $search == ""){
            $startTime = Carbon::now()->startOfDay();
            $endTime = Carbon::now()->endOfDay();  
        }elseif($search == 2){
            $startTime = Carbon::now()->startOfWeek(); 
            $endTime = Carbon::now()->endOfWeek(); 
        }elseif($search == 3){
            $startTime = Carbon::now()->startOfMonth(); 
            $endTime = Carbon::now()->endOfMonth(); 
        }elseif($search == 4){
            $startTime = Carbon::now()->startOfYear(); 
            $endTime = Carbon::now()->endOfYear(); 
        }elseif($search == 5){
            $startTime = '1900-01-01'; 
            $endTime = now(); 
        }
        log::info($startTime);
        $perPage = request('per_page', 10);
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');
        return MinuteResource::collection(Minute::whereBetween('date_at', [$startTime, $endTime])->orderBy($sortField, $sortDirection)->paginate(100));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\MinuteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MinuteRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Minute  $minute
     * @return \Illuminate\Http\Response
     */
    public function show(Minute $minute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\MinuteRequest  $request
     * @param  \App\Models\Minute  $minute
     * @return \Illuminate\Http\Response
     */
    public function update(MinuteRequest $request, Minute $minute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Minute  $minute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Minute $minute)
    {
        //
    }
}
