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



Route::prefix('festival')->middleware(['admin'])->group(function() {
    Route::get('/list', 'FestivalController@index')->name('festival.index');
    Route::get('/create', 'FestivalController@create')->name('festival.create');
    Route::post('/store', 'FestivalController@store')->name('festival.store');
    Route::get('/{id}/edit', 'FestivalController@edit')->name('festival.edit');
    Route::post('/{id}/update', 'FestivalController@update')->name('festival.update');
    Route::get('/{id}/change/status', 'FestivalController@changeStatus')->name('festival.change.status');
});
