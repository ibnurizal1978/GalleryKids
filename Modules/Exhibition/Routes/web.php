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

Route::prefix('exhibition')->middleware(['admin'])->group(function() {
    Route::get('/list', 'ExhibitionController@index')->name('exhibition.index');
    Route::get('/create', 'ExhibitionController@create')->name('exhibition.create');
    Route::post('/store', 'ExhibitionController@store')->name('exhibition.store');
    Route::get('/{id}/edit', 'ExhibitionController@edit')->name('exhibition.edit');
    Route::post('/{id}/update', 'ExhibitionController@update')->name('exhibition.update');
    Route::get('/{id}/change/status', 'ExhibitionController@changeStatus')->name('exhibition.change.status');
});
