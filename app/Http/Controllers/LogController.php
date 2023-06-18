<?php

namespace App\Http\Controllers;

use App\Http\Resources\LogResource;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
   public function index(){
        $search = request('search', '');
        $perPage = request('per_page', 10);
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');
        return LogResource::collection(Log::where([['action', 'like', "%$search%"], ['created_by', Auth::id()]])->orWhere([['content', 'like', "$search"], ['created_by', Auth::id()] ])->orderBy($sortField, $sortDirection)->paginate($perPage));
   }
}
