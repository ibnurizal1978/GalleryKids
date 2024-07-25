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

Route::prefix('event')->middleware(['admin'])->group(function() {
    Route::get('/list', 'EventController@index')->name('event.index');
    Route::get('/create', 'EventController@create')->name('event.create');
    Route::post('/store', 'EventController@store')->name('event.store');
    Route::get('/{id}/edit', 'EventController@edit')->name('event.edit');
    Route::post('/{id}/update', 'EventController@update')->name('event.update');
    Route::get('/{id}/change/status', 'EventController@changeStatus')->name('event.change.status');
});

