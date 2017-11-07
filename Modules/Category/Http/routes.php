<?php

Route::group(['middleware' => 'admin', 'prefix' => 'category', 'namespace' => 'Modules\Category\Http\Controllers'], function()
{
    Route::get('/', '\Modules\Category\Http\Controllers\CategoryController@index')->name('category');
    Route::get('/create', '\Modules\Category\Http\Controllers\CategoryController@create')->name('category.create');
    Route::get('/edit/{id}', '\Modules\Category\Http\Controllers\CategoryController@edit')->name('category.edit');
    Route::post('/store', '\Modules\Category\Http\Controllers\CategoryController@store')->name('category.store');
    Route::post('/update', '\Modules\Category\Http\Controllers\CategoryController@update')->name('category.update');
    Route::get('/show/{id}', '\Modules\Category\Http\Controllers\CategoryController@show')->name('category.show');
    Route::get('/changeStatus/{id}', '\Modules\Category\Http\Controllers\CategoryController@changeStatus')->name('category.changeStatus');
    Route::get('/destroy/{id}', '\Modules\Category\Http\Controllers\CategoryController@destroy')->name('category.destroy');
});

