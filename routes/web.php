<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
/
*/

Auth::routes();

Route::get('/', function () {
    return redirect('/login');
});

Route::post('/login', 'Auth\LoginController@login');

Route::get('/logout', 'Auth\LoginController@logout')->middleware('auth');

Route::get('/admin', 'AdminController@admin')->middleware('auth');

Route::get('/admin', 'AdminController@admin')->middleware('auth');
