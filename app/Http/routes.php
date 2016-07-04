<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

Route::get('/image-compressor/', 'ImageCompressController@index');

Route::post('/image-compressor/compress-images', 'ImageCompressController@compressImages');
Route::get('/image-compressor/compress-images/download/{hash}', 'ImageCompressController@downloadCompressedImages');