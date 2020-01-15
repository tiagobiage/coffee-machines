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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/device', 'DeviceController@login')->name('device.login');
Route::post('/device/register', 'DeviceController@register')->name('device.register');
Route::get('/device/{id}', 'DeviceController@index')->name('device.index');
Route::get('/device/stand-by/{id}', 'DeviceController@standBy')->name('device.standBy');

Auth::routes(['register' => false]);

//Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', 'AdminController@index');

    Route::get('/coffee-machine', 'CoffeeMachineController@index')->name('admin.coffee-machine');
    Route::get('/coffee-machine/add', 'CoffeeMachineController@add')->name('admin.coffee-machine.add');
    Route::post('/coffee-machine/store', 'CoffeeMachineController@store')->name('admin.coffee-machine.store');
    Route::get('/coffee-machine/edit/{id}', 'CoffeeMachineController@edit');
    Route::post('/coffee-machine/update', 'CoffeeMachineController@update')->name('admin.coffee-machine.update');
    Route::get('/coffee-machine/delete/{id}', 'CoffeeMachineController@delete');

    Route::get('/coffee', 'CoffeeController@index')->name('admin.coffee');
    Route::get('/coffee/add', 'CoffeeController@add')->name('admin.coffee.add');
    Route::post('/coffee/store', 'CoffeeController@store')->name('admin.coffee.store');
    Route::get('/coffee/edit/{id}', 'CoffeeController@edit');
    Route::post('/coffee/update', 'CoffeeController@update')->name('admin.coffee.update');
    Route::get('/coffee/delete/{id}', 'CoffeeController@delete');

    Route::get('/employee', 'EmployeeController@index')->name('admin.employee');

    Route::get('/order', 'OrderController@index')->name('admin.order');

    Route::get('/ranking', 'RankingController@index')->name('admin.ranking');
});
