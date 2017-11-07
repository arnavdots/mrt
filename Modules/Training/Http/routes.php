<?php

Route::group(['middleware' => 'admin'], function(){   
    
    Route::prefix('training')->group(function() {
        Route::get('/', ['as' => 'training', 'uses' => '\Modules\Training\Http\Controllers\TrainingController@index']);
        Route::post('/store', ['as' => 'training.store', 'uses' => '\Modules\Training\Http\Controllers\TrainingController@store']);
        Route::get('/create', ['as' => 'training.create', 'uses' => '\Modules\Training\Http\Controllers\TrainingController@create']);
        Route::get('/store', ['as' => 'training.store', 'uses' => '\Modules\Training\Http\Controllers\TrainingController@store']);
        Route::get('/edit/{topic}', ['as' => 'training.edit', 'uses' => '\Modules\Training\Http\Controllers\TrainingController@edit']);
        Route::post('/update', ['as' => 'training.update', 'uses' => '\Modules\Training\Http\Controllers\TrainingController@update']);
        Route::get('/change-status/{id}', ['as' => 'training.changeStatus', 'uses' => '\Modules\Training\Http\Controllers\TrainingController@changeStatus']);
        Route::get('/delete/{id}', ['as' => 'training.destroy', 'uses' => '\Modules\Training\Http\Controllers\TrainingController@destroy']);
    });
    Route::prefix('section')->group(function() {
        Route::get('/', ['as' => 'section', 'uses' => '\Modules\Training\Http\Controllers\SectionController@index']);
        Route::get('/create', ['as' => 'section.create', 'uses' => '\Modules\Training\Http\Controllers\SectionController@create']);
        Route::post('/store', ['as' => 'section.store', 'uses' => '\Modules\Training\Http\Controllers\SectionController@store']);
        Route::get('/edit/{section}', ['as' => 'section.edit', 'uses' => '\Modules\Training\Http\Controllers\SectionController@edit']);
        Route::post('/update', ['as' => 'section.update', 'uses' => '\Modules\Training\Http\Controllers\SectionController@update']);
        Route::get('/change-status/{id}', ['as' => 'section.changeStatus', 'uses' => '\Modules\Training\Http\Controllers\SectionController@changeStatus']);
        Route::get('/delete/{id}', ['as' => 'section.destroy', 'uses' => '\Modules\Training\Http\Controllers\SectionController@destroy']);
    });
    Route::prefix('topic')->group(function() {
        Route::get('/', ['as' => 'topic', 'uses' => '\Modules\Training\Http\Controllers\TopicController@index']);
        Route::get('/create', ['as' => 'topic.create', 'uses' => '\Modules\Training\Http\Controllers\TopicController@create']);
        Route::post('/store', ['as' => 'topic.store', 'uses' => '\Modules\Training\Http\Controllers\TopicController@store']);
        Route::get('/edit/{topic}', ['as' => 'topic.edit', 'uses' => '\Modules\Training\Http\Controllers\TopicController@edit']);
        Route::post('/update', ['as' => 'topic.update', 'uses' => '\Modules\Training\Http\Controllers\TopicController@update']);
        Route::get('/change-status/{id}', ['as' => 'topic.changeStatus', 'uses' => '\Modules\Training\Http\Controllers\TopicController@changeStatus']);
        Route::get('/delete/{id}', ['as' => 'topic.destroy', 'uses' => '\Modules\Training\Http\Controllers\TopicController@destroy']);
    });
});
