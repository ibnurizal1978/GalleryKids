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



//Route::group([
//    'module' => 'Points',
//    'prefix' => 'point',
//        ], function () {
//    Route::group(['middleware' => 'admin'], function() {
//        Route::resource('/', 'PointsController');
//    });
//});
Route::prefix('point')->middleware(['admin'])->group(function() {
    Route::get('/list', 'PointsController@index')->name('point.index');
    Route::get('/{id}/edit', 'PointsController@edit')->name('point.edit');
    Route::post('/{id}/update', 'PointsController@update')->name('point.update');
});