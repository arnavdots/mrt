<?php

Route::group(['middleware' => 'admin', 'prefix' => 'equipment', 'namespace' => 'Modules\Equipment\Http\Controllers'], function()
{
	Route::get('/', ['as' => 'equipment', 'uses' => '\Modules\Equipment\Http\Controllers\EquipmentController@index']);
});
