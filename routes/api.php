<?php

use App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});







*/

// all routes/api here must be api authenticated
Route::group(['middleware'=>['api'],'namespace'=>'Api'],function(){
    Route::post("/getallcat",[Api\CatController::class,'index'])->name("Api.getcat");
    //Route::post('/FileUpload', [Api\uploadfiletest::class,'uploadfile']);
    Route::group(['prefix' => 'auth'], function ($router) {

        Route::post('login', [Api\AuthController::class,'login']);
        Route::post('register', [Api\AuthController::class,'register']);
        Route::post('logout', [Api\AuthController::class,'logout']);
        Route::post('refresh', [Api\AuthController::class,'refresh']);
        Route::get('me', [Api\AuthController::class,'me']);
        Route::post('changeuser', [Api\AuthController::class,'changeuser']);

    });
    Route::group(['prefix' => 'post'], function ($router) {

        Route::post('CreatePost',[Api\PostController::class,'CreatePost']);
        Route::post('saveimg',[Api\PostController::class,'saveimage']);
        Route::post('RemovePost',[Api\PostController::class,'RemovePost']);
        Route::get('GetAllPosts',[Api\PostController::class,'GetAllPosts']);
        Route::post('GenerateLikes',[Api\PostController::class,'GenerateLikes']);

    });




    Route::group(['prefix'=>'admin'],function(){
        Route::post('login',[Api\AuthController::class,'login']);

    });

});



