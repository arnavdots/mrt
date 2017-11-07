<?php
Route::group(['middleware' => 'admin', 'prefix' => 'users', 'namespace' => 'Modules\User\Http\Controllers'], function()
{
    Route::get('/', '\Modules\User\Http\Controllers\UserController@index')->name('users');
    Route::get('/create', '\Modules\User\Http\Controllers\UserController@create')->name('users.create');
    Route::get('/edit/{id}', '\Modules\User\Http\Controllers\UserController@edit')->name('users.edit');
    Route::post('/store', '\Modules\User\Http\Controllers\UserController@store')->name('users.store');
    Route::post('/update', '\Modules\User\Http\Controllers\UserController@update')->name('users.update');
    Route::get('/show/{id}', '\Modules\User\Http\Controllers\UserController@show')->name('users.show');
    Route::get('/export/{type}', '\Modules\User\Http\Controllers\UserController@export')->name('users.export');
    Route::get('/changeStatus/{id}', '\Modules\User\Http\Controllers\UserController@changeStatus')->name('users.changeStatus');
    Route::get('/destroy/{id}', '\Modules\User\Http\Controllers\UserController@destroy')->name('users.destroy');
});

