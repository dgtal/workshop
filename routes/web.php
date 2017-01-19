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
});

// Admin Interface Routes
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function()
{
    Route::get('customer/ajax-customer-options/{customer_id?}', 'Admin\CustomerCrudController@selectOptions');
    CRUD::resource('customer', 'Admin\CustomerCrudController');

    Route::get('make/ajax-make-options', 'Admin\MakeCrudController@selectOptions');
    CRUD::resource('make', 'Admin\MakeCrudController');

    Route::get('family/ajax-family-options', 'Admin\FamilyCrudController@selectOptions');
    CRUD::resource('family', 'Admin\FamilyCrudController');

    Route::get('model/ajax-model-options', 'Admin\ModelCrudController@selectOptions');
    CRUD::resource('model', 'Admin\ModelCrudController');

    CRUD::resource('vehicle', 'Admin\VehicleCrudController');
    CRUD::resource('order', 'Admin\OrderCrudController');
    CRUD::resource('task', 'Admin\TaskCrudController');
});