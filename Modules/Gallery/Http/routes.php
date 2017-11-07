<?php

Route::group(['middleware' => 'admin', 'prefix' => 'gallery'], function() {
    Route::get('/', ['as' => 'gallery', 'uses' => '\Modules\Gallery\Http\Controllers\GalleryController@index']);
    Route::get('/create', ['as' => 'gallery.create', 'uses' => '\Modules\Gallery\Http\Controllers\GalleryController@create']);
    Route::post('/store', ['as' => 'gallery.store', 'uses' => '\Modules\Gallery\Http\Controllers\GalleryController@store']);
    Route::get('/change-status/{id}', ['as' => 'gallery.changeStatus', 'uses' => '\Modules\Gallery\Http\Controllers\GalleryController@changeStatus']);
    Route::get('/delete/{id}', ['as' => 'gallery.destroy', 'uses' => '\Modules\Gallery\Http\Controllers\GalleryController@destroy']);
});
