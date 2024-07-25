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

Route::prefix('challenges')->group(function() {
    Route::Post('/update', 'ChallengesController@userChalanges')->name('userChalanges');
});
Route::prefix('challenges')->middleware(['admin'])->group(function() {
    Route::get('/list', 'ChallengesController@index')->name('challenges.index');
    Route::get('/create', 'ChallengesController@create')->name('challenges.create');
    Route::post('/store', 'ChallengesController@store')->name('challenges.store');
    Route::get('/{id}/edit', 'ChallengesController@edit')->name('challenges.edit');
    Route::get('/{id}/challenges', 'ChallengesController@Challenge')->name('challenges.show');
    Route::post('/{id}/update', 'ChallengesController@update')->name('challenges.update');
     Route::get('/{id}/change/status', 'ChallengesController@changeStatus')->name('challenges.change.status');
//    Route::resource('/', 'ChallengesController');
});