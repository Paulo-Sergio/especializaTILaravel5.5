<?php

/**
 * NAMESPACE = Admin (pasta Admin do controller)
 * AdminController@index = Admin\AdminController@index
 * 
 * PREFIX = Admin (adiciona prefix admin na url)
 * localhost:8000/balance = localhost:8000/admin/balance
 */

Route::group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
  Route::post('deposit', 'BalanceController@depositStore')->name('deposit.store');       
  Route::get('deposit', 'BalanceController@deposit')->name('balance.deposit');       
  Route::get('balance', 'BalanceController@index')->name('admin.balance');       
  
  Route::get('/', 'AdminController@index')->name('admin.home');
});

Route::get('/', 'Site\SiteController@index')->name('home');

Auth::routes();
