<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RentalController;
use App\Http\Middleware\Admin;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::group(['middleware'=>'jwt.auth'],function (){
    Route::post('/rent',[RentalController::class,'rent']);
    Route::post('/comment',[AdminController::class,'addComment']);
    Route::middleware(Admin::class)->group(function (){
        Route::post('/add',[AdminController::class,'add']);
        Route::post('/block/{user}',[AdminController::class,'block']);
        Route::post('/unblock/{user}',[AdminController::class,'unblock']);
    });
});

