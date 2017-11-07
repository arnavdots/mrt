<?php
Route::group(['middleware' => 'web', 'prefix' => 'permission', 'namespace' => 'Modules\Permission\Http\Controllers'], function()
{
    Route::any('/', ['as' => 'permission', 'uses' => '\Modules\Permission\Http\Controllers\PermissionController@index']);
    //Route::post('/', '\Modules\Permission\Http\Controllers\PermissionController@index');    
    Route::post('/store', ['as' => 'permission.store', 'uses' =>'\Modules\Permission\Http\Controllers\PermissionController@store']);
	
});
