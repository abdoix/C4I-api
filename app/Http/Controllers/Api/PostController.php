<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\user_like_post;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Psr\Http\Client\ClientExceptionInterface;


class PostController extends Controller
{
    use GeneralTrait;

    public function __construct()
    {

        $this->middleware('auth.guard:api');

    }




    //
    function CreatePost(Request $request){
        // save photo in folder

        $file_name = $this->saveimage($request->photo,'assets/images/');

        $userid = auth()->user()->id;
        $Post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'photo' => $file_name,
            'user_id'=>$userid,
            'location'=>$request->description,
        ]);
        if(!$Post){
            return $this->returnError("","Post Can't Be Loaded Please Verify All Fields");
        }
        return $this->returnSuccessMessage("Post Added Successfully","200");

    }

    function RemovePost(Request $request){
        try {
            $post=Post::where('id',$request->id)->first();
            Post::where('id',$request->id)->delete();
            File::delete('profilepics/'.$post->photo);
            return $this->returnSuccessMessage("Post Deleted Successfully","200");
        }catch (\Throwable $th){
            return $this->returnError("","Post Can't Be Deleted");
        }

    }

    function GetAllPosts(){
        $posts=Post::all();
        return $this->returnData('posts',$posts,"Successfully");
    }

    function GenerateLikes(Request $req){
        $res=DB::select("select * from users_like_posts where user_id='".auth()->user()->id."' and post_id='".$req->id."' ");
        $post=DB::table('post')->where('id',$req->id)->first();
        $likesnumber = $post->likesnumber;
        if(count($res)==0){
            user_like_post::create([
                'user_id'=>auth()->user()->id,
                'post_id'=>$req->id,
            ]);
            $res=DB::table('post')->where('id',$req->id)->update([
                'LikesNumber'=>$likesnumber+1,
            ]);
            return $this->returnSuccessMessage("Likes Add Successfully","200");

        }
        else{
            $res=DB::select("delete  from users_like_posts where user_id='".auth()->user()->id."' and post_id='".$req->id."' ");

            $res=DB::table('post')->where('id',$req->id)->update([
                'LikesNumber'=>$likesnumber-1,
            ]);
            return $this->returnSuccessMessage("Likes removed Successfully","200");

        }


    }




}
