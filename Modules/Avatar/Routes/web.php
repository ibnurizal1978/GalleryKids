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

Route::prefix('avatar')->group(function() {
 
    Route::get('/list', 'AvatarController@index')->name('avatar.index');
    Route::get('/create', 'AvatarController@create')->name('avatar.create');
    Route::post('/store', 'AvatarController@store')->name('avatar.store');
    Route::get('/{id}/edit', 'AvatarController@edit')->name('avatar.edit');
    Route::post('/{id}/update', 'AvatarController@update')->name('avatar.update');
    Route::get('/{id}/change/status', 'AvatarController@changeStatus')->name('avatar.change.status');
    
});
