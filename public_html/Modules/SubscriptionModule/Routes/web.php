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
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

Route::prefix('subscriptionmodule')->group(function() {
    Route::get('/', 'SubscriptionModuleController@index');
    Route::get('/create', 'SubscriptionModuleController@create')->name('subscriptionmodule.create');
    Route::post('/store', 'SubscriptionModuleController@store')->name('subscriptionmodule.store');
    Route::get('/edit/{id}', 'SubscriptionModuleController@edit')->name('subscriptionmodule.edit');
    Route::put('/update/{id}', 'SubscriptionModuleController@update')->name('subscriptionmodule.update');
    Route::get('/delete/{id}', 'SubscriptionModuleController@delete')->name('subscriptionmodule.delete');
    Route::get('/view/{id}', 'SubscriptionModuleController@view')->name('subscriptionmodule.view');
    Route::get('/list', 'SubscriptionModuleController@list')->name('subscriptionmodule.list');
});
});
