<?php

Route::group(['middleware' => 'admin', 'prefix' => 'order_quote', 'namespace' => 'Modules\OrderQuote\Http\Controllers'], function()
{
  
		Route::get('/', ['as' => 'order_quote', 'uses' => '\Modules\OrderQuote\Http\Controllers\OrderQuoteController@index']);
});
