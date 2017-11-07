<?php

Route::group(['middleware' => 'web', 'prefix' => 'marketing', 'namespace' => 'Modules\Marketing\Http\Controllers'], function()
{
	Route::get('/', ['as' => 'marketing', 'uses' => '\Modules\Marketing\Http\Controllers\MarketingController@index']);
});
