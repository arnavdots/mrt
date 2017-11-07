<?php

Route::group(['middleware' => 'web', 'prefix' => 'pickup', 'namespace' => 'Modules\PickUp\Http\Controllers'], function()
{
	Route::get('/', ['as' => 'pickup', 'uses' => '\Modules\PickUp\Http\Controllers\PickUpController@index']);
});
