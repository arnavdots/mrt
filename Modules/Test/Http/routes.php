<?php

Route::group(['middleware' => 'admin', 'prefix' => 'test', 'namespace' => 'Modules\Test\Http\Controllers'], function()
{
    Route::get('/', '\Modules\Test\Http\Controllers\TestController@index')->name('test');
    Route::get('/generate-pdf', '\Modules\Test\Http\Controllers\TestController@generate_pdf')->name('test.generate_pdf');
    Route::get('/export-csv', '\Modules\Test\Http\Controllers\TestController@export_csv')->name('test.export_csv');
    Route::get('/generate-barcode', '\Modules\Test\Http\Controllers\TestController@generate_barcode')->name('test.generate_barcode');
    Route::match(['get', 'post'], '/image-upload', '\Modules\Test\Http\Controllers\TestController@image_upload')->name('test.image_upload');
});