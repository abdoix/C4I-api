<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class uploadfiletest extends Controller
{

    use GeneralTrait;

    public function uploadfile(Request $request){

        // save photo in folder
        $file_name = $this->saveimage($request->photo,'assets/images/');
        /*$user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $file_name,
        ]);
        if(!$user){
            return "wrong";
        }
        return "ok";*/

    }
}
