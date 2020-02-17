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



Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    
Route::get('/', 'DashboardController@index');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');


Route::get('/get-typewise-data/{type}', 'DashboardController@getTypeWiseChart');

Route::post('/get-dashboard-report', 'DashboardController@dashboardReport');

Route::get('/get-json-data', 'DashboardController@getSingleTypeChartNew');

Route::view('others/user-profile', 'others.user-profile')->name('user-profile');

Route::resource('user-profile', 'UserController');

Route::get('/get-chart-report', 'DashboardController@chartReport')->name('get-chart-report');

Route::post('/monthly-daily-transaction-data', 'DashboardController@getDataForTransactionChart');


});



