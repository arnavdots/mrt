<?php

Route::group(['middleware' => 'web', 'prefix' => 'product', 'namespace' => 'Modules\Product\Http\Controllers'], function()
{
	Route::get('/', ['as' => 'product', 'uses' => '\Modules\Product\Http\Controllers\ProductController@index']);
});
