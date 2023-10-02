<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SortController extends Controller
{
    public function teachers(Request $request){
        $teachers = json_decode($request['teachers'], true);
        foreach($teachers as $teacher){
            $db = Teacher::where('id', $teacher['id'])->first();
            $db->sort = $teacher['sort'];
            $db->save();
        }
    }
    public function banners(Request $request){
        $banners = json_decode($request['banners'], true);
        log::info($banners);
        foreach($banners as $banner){
            $db = Banner::where('id', $banner['id'])->first();
            $db->sort = $banner['sort'];
            $db->save();
        }
    }
}
