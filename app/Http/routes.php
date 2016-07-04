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

Route::get('/', 'HomeController@getIndex');

Route::get('/image-compressor/', 'ImageCompressController@getIndex');

Route::post('/image-compressor/compress-images', 'ImageCompressController@compressImages');
Route::get('/image-compressor/compress-images/download/{hash}', 'ImageCompressController@downloadCompressedImages');

Route::get('/nameserver/search', 'NameserverController@getSearch');
Route::post('/nameserver/search', 'NameserverController@postSearch');
Route::post('/nameserver/submit', 'NameserverController@postSubmit');
Route::get('/nameserver/submit', 'NameserverController@getSubmit');

Route::get('/nameserver/confirm/{code}', 'NameserverController@confirmNameserver');
Route::get('/nameserver/delete/{code}', 'NameserverController@deleteNameserver');