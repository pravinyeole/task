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

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/contact_reg', 'HomeController@contact_reg')->name('contact_reg');
Route::post('/share_deatils', 'HomeController@share_deatils')->name('share_deatils');
Route::get('/edit/{id}', 'HomeController@edit')->name('edit');
Route::any('/testmail', 'Auth\RegisterController@testmail')->name('testmail');
Route::any('/verify_user/{email?}', 'Auth\RegisterController@verify_user')->name('verify_user');
