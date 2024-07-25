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

Route::prefix( 'adminshare' )->group( function () {
    Route::get( '/', 'AdminShareController@index' );
} );
Route::prefix( 'adminShare' )->middleware( [ 'admin' ] )->group( function () {
    Route::get( '/update', 'AdminShareController@allUpdate' )->name( 'adminShare.update' );
    Route::get( '/list', 'AdminShareController@index' )->name( 'adminShare.index' );
    Route::get( '/{id}/change/status', 'AdminShareController@changeStatus' )->name( 'adminShare.change.status' );
    Route::get( '/show/{id}', 'AdminShareController@show' )->name( 'adminShare.show' );
    Route::post( '/{id}/categorySave', 'AdminShareController@update' )->name( 'adminShare.categorySave' );
    Route::get( '/sync', 'AdminShareController@sync' )->name( 'adminShare.sync' );
    Route::get( '/add', 'AdminShareController@add' )->name( 'adminShare.add' );
    Route::post( '/', 'AdminShareController@store' )->name( 'adminShare.store' );
    Route::get( '/edit/{share}', 'AdminShareController@edit' )->name( 'adminShare.edit' );
    Route::post( '/edit/{share}', 'AdminShareController@updateShare' )->name( 'adminShare.modify' );
    Route::get( '/delete/{share}', 'AdminShareController@destroy' )->name( 'adminShare.delete' );
} );
