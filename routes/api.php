<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('device')->group(function () {
    Route::post('/coffeeMachine/{id}', 'DeviceController@apiCoffeeMachine');
    Route::get('/employee/{employeeCode}/{machineId}', 'DeviceController@apiEmployee');
    Route::post('/order/{employeeCode}/{machineId}/{coffeeId}', 'DeviceController@apiOrder');
    Route::post('/rate/{employeeCode}/{orderId}/{coffeeId}/{rate}', 'DeviceController@apiRate');
    Route::post('/finish-order/{orderId}', 'DeviceController@apifinishOrder');
});
