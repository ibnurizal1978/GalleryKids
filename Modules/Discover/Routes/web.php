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

Route::prefix('discover')->group(function() {
    Route::get('/question/create', 'DiscoverController@createQuestion')->name('discover.question.create');
    Route::post('/store', 'DiscoverController@store')->name('discover.store');
});

Route::prefix('discover')->middleware(['admin'])->group(function() {
    Route::get('/list', 'DiscoverController@index')->name('discover.index');
    Route::get('/create', 'DiscoverController@create')->name('discover.create');
    
    Route::get('/{id}/edit', 'DiscoverController@edit')->name('discover.edit');
    Route::post('/{id}/update', 'DiscoverController@update')->name('discover.update');
    Route::get('/{id}/change/status', 'DiscoverController@changeStatus')->name('discover.change.status');
});



