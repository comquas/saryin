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



Route::middleware(['auth:web'])->prefix('acc')->group(function () {
    Route::get('/','AdminController@index')->name('admin.home');
    Route::resource('categories','CategoryController');
    Route::resource('customers','CustomerController');
    Route::resource('transactions','TransactionController');
    Route::get('category/search/type/{type}','CategoryController@search')->name('category.search');
    Route::get('category/search/category','CategoryController@categorySearch');
    Route::get('customer/search','CustomerController@search')->name('customer.search');
    Route::resource('users','UserController');

    Route::get('transactions/report/{year}/{type}','DashboardController@groupByMonth')->name('transaction.year');

    Route::get('transactions/report/expend', 'DashboardController@expend')->name('transaction.expend');

});

Auth::routes(['register' => false]);
