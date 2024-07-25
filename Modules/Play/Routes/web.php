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


Route::prefix('play')->middleware(['admin'])->group(function() {
    Route::get('/list', 'PlayController@index')->name('play.index');
    Route::get('/create', 'PlayController@create')->name('play.create');
    Route::post('/store', 'PlayController@store')->name('play.store');
    Route::get('/{id}/edit', 'PlayController@edit')->name('play.edit');
    Route::post('/{id}/update', 'PlayController@update')->name('play.update');
    Route::get('/{id}/change/status', 'PlayController@changeStatus')->name('play.change.status');
});


