<?php

Route::group(['middleware' => 'web', 'prefix' => 'stock_view', 'namespace' => 'Modules\StockView\Http\Controllers'], function()
{
	Route::get('/', ['as' => 'stock_view', 'uses' => '\Modules\StockView\Http\Controllers\StockViewController@index']);
});
