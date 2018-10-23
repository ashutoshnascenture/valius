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
	if (Auth::check()){
      if (Auth::check() && !\Auth::user()->hasRole('admin')) {
		
       return redirect('/dashboard');
	} else {
		
	  return redirect('/admin-dashboard');
	} 
	} else {
      return view('welcome');

	}
	
});
Auth::routes();
Route::get('/plan-list', 'HomeController@index')->name('plan-list');
Route::get('/plan-select/{planID}', 'HomeController@planDetail')->name('plan-select');
Route::post('/plan-payment', 'HomeController@planPayment')->name('plan-payment');
Route::post('/subscribe-plan', 'HomeController@subscribePlan')->name('subscribe-plan');
Route::get('/dashboard', 'DashboardController@index');
Route::get('/admin-dashboard', 'DashboardController@adminDashboard');
Route::get('users/change-password/', 'UserController@changePassword');
Route::post('users/reset-password/', 'UserController@resetPassword');
Route::get('users/account-details/', 'UserController@accountDetails');
Route::put('users/userUpdate/{id}/', 'UserController@userUpdate');
Route::get('users/get-users/', 'UserController@getUsers');
Route::delete('users/destroy/{id}', 'UserController@destroy');
Route::resource('users','UserController');
Route::resource('ticket','TicketController');
Route::get('/plans', 'PlanController@index')->name('plans');
Route::put('plans/planUpdate/{id}/', 'PlanController@planUpdate');
Route::get('plans/get-plans', 'PlanController@getPlans');
Route::put('addons/addonUpdate/{id}/', 'AddonsController@addonUpdate');
Route::resource('addons','AddonsController');
Route::resource('plans','PlanController');
Route::resource('sites','SitesController');
Route::group(['prefix' => 'subscribe'], function(){
	Route::post('/', 'PlanController@subscribe')->name('subscribe');
});
