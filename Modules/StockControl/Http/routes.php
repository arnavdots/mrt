<?php

Route::group(['middleware' => 'admin'], function() {
    Route::prefix('stock_control')->group(function() {
        Route::get('/', ['as' => 'stock_control', 'uses' => '\Modules\StockControl\Http\Controllers\StockControlController@index']);
    });
    Route::prefix('new_product')->group(function() {
        Route::get('/', ['as' => 'new_product', 'uses' => '\Modules\StockControl\Http\Controllers\StockControlNewProductController@index']);
        Route::get('/create', ['as' => 'new_product.create', 'uses' => '\Modules\StockControl\Http\Controllers\StockControlNewProductController@create']);
        Route::post('/store', ['as' => 'new_product.store', 'uses' => '\Modules\StockControl\Http\Controllers\StockControlNewProductController@store']);
        Route::post('/productsearch', ['as' => 'new_product.productsearch', 'uses' => '\Modules\StockControl\Http\Controllers\StockControlNewProductController@productSearch']);
    });
});

