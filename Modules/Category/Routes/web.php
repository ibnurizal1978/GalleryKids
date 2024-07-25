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


Route::prefix('category')->middleware(['admin'])->group(function() {
    Route::get('/list', 'CategoryController@index')->name('category.index');
    Route::get('/create', 'CategoryController@create')->name('category.create');
    Route::post('/store', 'CategoryController@store')->name('category.store');
    Route::get('/{id}/edit', 'CategoryController@edit')->name('category.edit');
    Route::post('/{id}/update', 'CategoryController@update')->name('category.update');

    //added 11-12-20
    Route::get('/{id}/status', 'CategoryController@changeStatus')->name('category.change.status');

});
