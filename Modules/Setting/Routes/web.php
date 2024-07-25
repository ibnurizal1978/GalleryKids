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

Route::prefix('setting')->group(function() {
    Route::get('/list', 'SettingController@index')->name('setting.index');
    Route::get('/{id}/edit', 'SettingController@edit')->name('setting.edit');
    Route::post('/{id}/update', 'SettingController@update')->name('setting.update');
});

Route::prefix('tabs')->group(function() {
    Route::get('/list', 'TabController@index')->name('setting.tab.index');
    Route::get('/{id}/edit', 'TabController@edit')->name('setting.tab.edit');
    Route::post('/{id}/update', 'TabController@update')->name('setting.tab.update');
});
