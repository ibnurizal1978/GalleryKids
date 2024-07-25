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


Route::prefix('share')->group(function() {
    Route::post('/store', 'ShareController@store')->name('share.store');
//    Route::get('/submission/create','ShareController@submissionCreate')->name('share.submission.create');
 
});


Route::prefix('share')->middleware(['admin'])->group(function() {
    Route::get('/list', 'ShareController@index')->name('share.index');
    Route::get('/create', 'ShareController@create')->name('share.create');
    Route::get('/{id}/edit', 'ShareController@edit')->name('share.edit');
    Route::post('/{id}/update', 'ShareController@update')->name('share.update');
    Route::get('/{id}/change/status', 'ShareController@changeStatus')->name('share.change.status');
     Route::get('/{id}/change/featured', 'ShareController@changeFeature')->name('share.change.featured');
});

