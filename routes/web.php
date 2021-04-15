<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'fileUploadController@fileUpload')->name('file.upload');
Route::post('/', 'fileUploadController@fileUploadPost')->name('file.upload.post');
Route::get('/visualize', function(){
    return view('visualize');
});