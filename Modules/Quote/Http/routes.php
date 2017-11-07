<?php

Route::group(['middleware' => 'admin', 'prefix' => 'quotes', 'namespace' => 'Modules\Quote\Http\Controllers'], function()
{
	Route::get('/', ['as' => 'quotes', 'uses' => '\Modules\Quote\Http\Controllers\QuoteController@index']);
});
