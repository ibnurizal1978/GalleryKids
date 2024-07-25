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

Route::prefix('create')->middleware(['admin'])->group(function() {
    Route::get('/list', 'CreateController@index')->name('create.index');
    Route::get('/create', 'CreateController@create')->name('create.create');
    Route::post('/store', 'CreateController@store')->name('create.store');
    Route::get('/{id}/edit', 'CreateController@edit')->name('create.edit');
    Route::post('/{id}/update', 'CreateController@update')->name('create.update');
    Route::get('/{id}/change/status', 'CreateController@changeStatus')->name('create.change.status');
});


