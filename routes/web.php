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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile.index');
Route::post('/profile', 'ProfileController@store')->name('profile.store');
Route::post('/profile/image', 'ProfileController@image')->name('profile.image');

Route::get('/advert', 'AdvertController@index')->name('advert.index');
Route::get('/advert/{id}', 'AdvertController@show')->name('advert.show');
Route::post('/advert', 'AdvertController@store')->name('advert.store');
Route::post('/advert/update', 'AdvertController@update')->name('advert.update');
Route::post('/advert/destroy', 'AdvertController@destroy')->name('advert.destroy');
