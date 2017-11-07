<?php

Route::group(['prefix' => 'enquiries','middleware' => 'admin'], function(){
    Route::get('/', '\Modules\Enquiry\Http\Controllers\EnquiryController@index');
    
    Route::post('/store', function(){ echo 'Test'; });
    
    Route::get('/test', '\Modules\Enquiry\Http\Controllers\EnquiryController@index');
});
