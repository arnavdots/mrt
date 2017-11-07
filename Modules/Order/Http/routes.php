<?php

Route::group(['middleware' => 'admin', 'prefix' => 'orders', 'namespace' => 'Modules\Order\Http\Controllers'], function()
{
	Route::get('/', ['as' => 'orders', 'uses' => '\Modules\Order\Http\Controllers\OrderController@index']);
  
});
