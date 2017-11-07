<?php

Route::group(['middleware' => 'admin', 'prefix' => 'branch', 'namespace' => 'Modules\Branch\Http\Controllers'], function()
{
	Route::get('/', ['as' => 'branch', 'uses' => '\Modules\Branch\Http\Controllers\BranchController@index']);
	Route::get('create/', ['as' => 'branch.create', 'uses' => '\Modules\Branch\Http\Controllers\BranchController@create']);
	Route::get('/edit/{id}', ['as' => 'branch.edit', 'uses' => '\Modules\Branch\Http\Controllers\BranchController@edit']);
	Route::post('/store', ['as' => 'branch.store', 'uses' => '\Modules\Branch\Http\Controllers\BranchController@store']);
	Route::post('/update', ['as' => 'branch.update', 'uses' => '\Modules\Branch\Http\Controllers\BranchController@update']);
        Route::get('/changeStatus/{id}', ['as' => 'branch.changeStatus', 'uses' => '\Modules\Branch\Http\Controllers\BranchController@changeStatus']);
        Route::get('/destroy/{id}', ['as' => 'branch.destroy', 'uses' => '\Modules\Branch\Http\Controllers\BranchController@destroy']);
  
});
