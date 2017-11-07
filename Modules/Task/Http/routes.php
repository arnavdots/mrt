<?php

Route::group(['middleware' => 'admin', 'prefix' => 'tasks'], function()
{
    Route::get('/', '\Modules\Task\Http\Controllers\TaskController@index')->name('task');
    
    Route::get('/create', '\Modules\Task\Http\Controllers\TaskController@create')->name('task.create');
    Route::get('/edit/{task}', '\Modules\Task\Http\Controllers\TaskController@edit')->name('task.edit');
    Route::post('/store', '\Modules\Task\Http\Controllers\TaskController@store')->name('task.store');
    Route::post('/update', '\Modules\Task\Http\Controllers\TaskController@update')->name('task.update');
    Route::post('/addNote', '\Modules\Task\Http\Controllers\TaskController@addNote')->name('taskNote.add');
    Route::post('/taskCompleted', '\Modules\Task\Http\Controllers\TaskController@taskCompleted')->name('taskCompleted');
   
});
