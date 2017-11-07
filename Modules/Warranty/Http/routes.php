<?php

Route::group(['middleware' => 'web', 'prefix' => 'warranty', 'namespace' => 'Modules\Warranty\Http\Controllers'], function()
{
	Route::get('/', ['as' => 'warranty', 'uses' => '\Modules\Warranty\Http\Controllers\WarrantyController@index']);
});
