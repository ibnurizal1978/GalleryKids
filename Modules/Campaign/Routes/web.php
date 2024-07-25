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

Route::prefix('campaign')->middleware(['admin'])->group(function() {
    Route::get('/list', 'CampaignController@index')->name('campaign.index');
    Route::get('/create', 'CampaignController@create')->name('campaign.create');
    Route::post('/store', 'CampaignController@store')->name('campaign.store');
    Route::get('/{id}/edit', 'CampaignController@edit')->name('campaign.edit');
    Route::post('/{id}/update', 'CampaignController@update')->name('campaign.update');
});

