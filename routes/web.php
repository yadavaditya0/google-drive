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

// This is where the user can see a login button for logging into Google
Route::get('/', 'DriveController@index');

// This is where the user gets redirected upon clicking the login button on the home page
Route::get('/login', 'DriveController@login');

// This is where users files get stored in DB
Route::get('/dashboard', 'DashboardController@index');

// This is where users get a list of saved files
Route::get('/filelist', 'DashboardController@fileList');

