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

/**
     * admin routes.
     */
Route::prefix('admin')->middleware(['admin'])->group(function() {
    Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
});


