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


Route::prefix('question')->group(function() {
    Route::post('/store', 'QuestionController@store')->name('question.store');
});

Route::prefix('question')->middleware(['admin'])->group(function() {
    Route::get('/list', 'QuestionController@index')->name('question.index');
    Route::get('/create', 'QuestionController@create')->name('question.create');
    Route::get('/{id}/edit', 'QuestionController@edit')->name('question.edit');
    Route::post('/{id}/update', 'QuestionController@update')->name('question.update');
    Route::get('/{id}/change/status', 'QuestionController@changeStatus')->name('question.change.status');
    Route::get('/{id}/change/featured', 'QuestionController@changeFeature')->name('question.change.featured');
});