<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/', function () {
    return redirect()->route('admin.login');
});


/**
  custom authentication route
 */
Route::group(['middleware' => ['web']], function () {

    Route::prefix('admin')->group(function() {
        Route::get('/', ['as' => 'admin.login', 'uses' => 'Admin\Auth\LoginController@showLoginForm']);
        Route::get('/login', ['as' => 'admin.login', 'uses' => 'Admin\Auth\LoginController@showLoginForm']);
        Route::post('/', ['as' => 'admin.auth', 'uses' => 'Admin\Auth\LoginController@login']);
        Route::post('/login', ['as' => 'admin.auth', 'uses' => 'Admin\Auth\LoginController@login']);
        Route::get('password/forgot-password', ['as' => 'password.forgot-password', 'uses' => 'Admin\Auth\ForgotPasswordController@showForgotForm']);
        Route::post('password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Admin\Auth\ResetPasswordController@reset')->name('password.reset');
        Route::get('/get-states/{param}', ['as' => 'get-states', 'uses' => 'AjaxController@getStates']);
        Route::get('/get-states/{param}/{param2}', ['as' => 'get-states', 'uses' => 'AjaxController@getStates']);
        Route::get('/get-cities/{param}', ['as' => 'get-cities', 'uses' => 'AjaxController@getCities']);
        Route::get('/get-cities/{param}/{param2}', ['as' => 'get-cities', 'uses' => 'AjaxController@getCities']);
       
        Route::group(['namespace' => 'Admin', 'middleware' => ['admin']], function () {
            Route::get('/', function () {
                return redirect()->route('admin.dashboard');
            });
            Route::get('/dashboard', ['as' => 'admin.dashboard', 'uses' => 'DashboardController@index']);
            Route::get('/home', ['as' => 'admin.home', 'uses' => 'HomeController@index']);
            Route::post('/logout', ['as' => 'admin.logout', 'uses' => 'Auth\LoginController@logout']);

            // Ajax method's route
            Route::match(['get', 'post'], '/status-change/{model}/{id}', ['uses' => 'AjaxController@status_change']);
            Route::match(['get', 'post'], '/delete-record/{model}/{id}', ['uses' => 'AjaxController@delete_record']);

            Route::group(['after' => 'admin'], function () {
                require 'Modules/Enquiry/Http/routes.php';
                require 'Modules/Permission/Http/routes.php';
                require 'Modules/User/Http/routes.php';
                require 'Modules/Task/Http/routes.php';
                require 'Modules/Equipment/Http/routes.php';
                require 'Modules/Financial/Http/routes.php';
                require 'Modules/Gallery/Http/routes.php';
                require 'Modules/Marketing/Http/routes.php';
                require 'Modules/PickUp/Http/routes.php';
                require 'Modules/Product/Http/routes.php';
                require 'Modules/OrderQuote/Http/routes.php';
                require 'Modules/Quote/Http/routes.php';
                require 'Modules/Quote/Http/routes.php';
                require 'Modules/Order/Http/routes.php';
                require 'Modules/StockControl/Http/routes.php';
                require 'Modules/StockView/Http/routes.php';
                require 'Modules/Training/Http/routes.php';
                require 'Modules/Warranty/Http/routes.php';
                require 'Modules/Category/Http/routes.php';
                require 'Modules/Branch/Http/routes.php';
                require 'Modules/Test/Http/routes.php';
            });
        });

    });
});

