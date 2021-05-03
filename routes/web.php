<?php

use Illuminate\Support\Facades\Route;

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
	return view('welcome');
});

Route::get('auth/google', 'Auth\LoginController@redirectToGoogle');
Route::get('callback/google', 'Auth\LoginController@handleGoogleCallback');

Route::get('auth/facebook', 'Auth\LoginController@redirectToFacebook');
Route::get('callback/loginfb', 'Auth\LoginController@handleFacebookCallback'); 


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/login', 'AdminController@login');
Route::get('/admin', 'AdminController@login');
Route::post('/admin/login_submit', 'AdminController@login_submit');
Route::get('/admin/logout', 'AdminController@logout');

// Route::get('/admin/dashboard', 'AdminController@dashboard');

Route::group(['middleware'=>['admin_auth']],function(){

    // customer routes
    Route::get('/admin/dashboard', 'AdminController@dashboard');
    Route::get('/admin/users', 'AdminController@list');
    Route::get('/admin/users/list', 'AdminController@list');
	Route::get('/admin/users/create', 'AdminController@create');
	Route::post('/admin/users/create', 'AdminController@create_submit');
	Route::get('/admin/users/edit/{id}', 'AdminController@edit_users');
	Route::post('/admin/users/update/{id}', 'AdminController@update_users');
	Route::get('/admin/users/delete/{id}', 'AdminController@delete_user');
	Route::get('/admin/users/activeDeactive/{id}', 'AdminController@activeDeactive');
	Route::get('/admin/users/restore/{id}', 'AdminController@Restore');

	Route::get('/admin/profile/', 'AdminController@profile');
	Route::post('/admin/profile/update/{id}', 'AdminController@updateProfile');


    
    
});

