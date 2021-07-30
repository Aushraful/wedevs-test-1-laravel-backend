<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'auth', 'namespace' => 'App\Http\Controllers\Auth'], function (){
    Route::post('signup', SignUpController::class);
    Route::post('signin', SignInController::class);
    Route::post('signout', SignOutController::class);
});

Route::get('profile', \App\Http\Controllers\ProfileController::class);

Route::apiResource('products', \App\Http\Controllers\ProductController::class);
