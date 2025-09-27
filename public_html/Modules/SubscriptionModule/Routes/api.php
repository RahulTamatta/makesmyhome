<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\CustomerModule\Http\Controllers\Api\V1\Customer\AddressController;
use Modules\CustomerModule\Http\Controllers\Api\V1\Customer\CustomerController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/subscriptionmodule', function (Request $request) {
    return $request->user();
});
Route::prefix('subscriptionmodule')->group(function() {
    Route::get('/subscriptions', 'SubscriptionModuleController@apilist');
    Route::post('/subscriptions', 'SubscriptionModuleController@apistore')->withoutMiddleware(['auth:api']);
    Route::get('/subscriptions/{id}', 'SubscriptionModuleController@apishow');
    Route::put('/subscriptions/{id}', 'SubscriptionModuleController@apiupdate');
    Route::delete('/subscriptions/{id}', 'SubscriptionModuleController@apidestroy');
    Route::get('/MySubcription', 'SubscriptionModuleController@apiGetMySubcription')->withoutMiddleware(['auth:api']);

    
});
 Route::post('/generate-pin/{id}', 'SubscriptionModuleController@generatepin')->withoutMiddleware(['auth:api']);
Route::post('/verify-pin', 'SubscriptionModuleController@verifypin')->withoutMiddleware(['auth:api']);