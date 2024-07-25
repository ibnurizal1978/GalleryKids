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

Route::prefix('reaction')->group(function() {
    Route::post('/add', 'ReactionController@addReaction')->name('reaction.add');
     Route::post('/delete', 'ReactionController@deleteReaction')->name('reaction.delete');
});
