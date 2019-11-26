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
    return view('welcome');
});

Route::post('/groups/store', 'GroupController@store')->name('groups.store');

Route::get('/contacts/autocomplete', 'ContactController@autocomplete')->name('contacts.autocomplete');
Route::resource('contacts', 'ContactController');
