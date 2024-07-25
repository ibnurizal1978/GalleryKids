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

Route::prefix('user')->middleware(['admin'])->group(function() {
    Route::get('/list', 'UserController@index')->name('user.index');
    Route::get('/{id}/children','UserController@children')->name('user.children');
    Route::get('/{id}/parents','UserController@parents')->name('user.parents');
    Route::get('/{id}/show', 'UserController@show')->name('user.show');
    Route::get('/{id}/status', 'UserController@changeStatus')->name('user.change.status');
});


Route::prefix('user')->middleware(['auth'])->group(function() {
    Route::get('/profile', 'UserController@profile')->middleware(['auth'])->name('user.profile');
    Route::post('/profile/update', 'UserController@profileUpdate')->middleware(['auth'])->name('user.profile.upload');
    Route::Post('/studentLogin', 'UserController@StudentLogin')->name('studentLogin');
    Route::Post('/parentLogin', 'UserController@parentLogin')->name('parentLogin');
     Route::Post('/childrenAdd', 'UserController@childrenAdd')->name('childrenAdd');

});