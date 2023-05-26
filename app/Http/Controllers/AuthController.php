<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
class AuthController extends Controller
{
    public function login(Request $req){
        $createdentials = $req->validate([
            'email'=>['required', 'email'],
            'password'=>['required'],
            'remember'=>'boolean',
        ]);
        $remember = $createdentials['remember'] ?? false;
        unset($createdentials['remember']);
        if(!Auth::attempt($createdentials, $remember)){
            return response([
                'message'=>'帳號或密碼錯誤！',
            ], 422);
        }

        $user = Auth::user();
        if(!$user->is_admin){
            Auth::logout();

            return response([
                'message'=>'您無權限進入此網站',
            ], 403);
        }

        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user'=>new UserResource($user),
            'token'=>$token,
        ]);
    }

    public function logout(){
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response('', 204);
    }
    public function getUser(Request $req){
        return new UserResource($req->user());
    }

    public function uploadImage(Request $req){
        $image = $req->file('upload');
        if($image){
            $relatevePath = $this->saveImage($image);
            // $data['image'] = URL::to(Storage::url($relatevePath));
            $image = URL::to('/storage/images/'.$relatevePath);
        }

        return response()->json(['fileName'=>$relatevePath, 'uploaded'=>1, 'url'=>$image]);
    }

    public function saveImage(UploadedFile $image){
        $path = Str::random();
        if(!Storage::exists($path)){
            Storage::makeDirectory($path, 0755, true);
        }
        if(!Storage::putFileAs('images/' .  $path, $image, $image->getClientOriginalName())){
            throw new \Exception("Unable to save file \"{$image->getClientOriginalName()}\"");
        }

        return $path . '/' .$image->getClientOriginalName();
    }
}
