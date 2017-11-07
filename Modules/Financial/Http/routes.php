<?php

Route::group(['middleware' => 'admin', 'prefix' => 'financial', 'namespace' => 'Modules\Financial\Http\Controllers'], function()
{
	Route::get('/', ['as' => 'financial', 'uses' => '\Modules\Financial\Http\Controllers\FinancialController@index']);
});
