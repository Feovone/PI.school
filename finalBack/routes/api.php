<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\PrivateFilesController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
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
*/
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::resource('/user', UserController::class)->only([
        'index','update'
    ]);
    Route::resource('/actions', ActionController::class)->only([
        'index','show','store','destroy'
    ]);
    Route::get("/logout",[UserController::class,'logout']);
    Route::get("/userPhotoIndex",[UserController::class,'userPhotoIndex']);
    Route::post("/userPhotoStore",[UserController::class,'userPhotoStore']);
    Route::post("/report",[ActionController::class,'report']);
    Route::post("/checksum",[ActionController::class,'checkCount']);
});

Route::post("/login",[UserController::class,'login']);
Route::post("/register",[UserController::class,'register']);
