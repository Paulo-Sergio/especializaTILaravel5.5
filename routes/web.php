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
  
  Route::get('withdraw', 'BalanceController@withdraw')->name('balance.withdraw');
  Route::post('withdraw', 'BalanceController@withdrawStore')->name('withdraw.store');

  Route::get('transfer', 'BalanceController@transfer')->name('balance.transfer');
  Route::post('confirm-transfer', 'BalanceController@confirmTransfer')->name('confirm.transfer');
  Route::post('transfer', 'BalanceController@transferStore')->name('transfer.store');

  Route::get('historic', 'BalanceController@historic')->name('admin.historic');
  Route::any('historic-search', 'BalanceController@searchHistoric')->name('historic.search');
  
  Route::get('/', 'AdminController@index')->name('admin.home');
});

Route::get('meu-perfil', 'Admin\UserController@profile')->name('profile')->middleware('auth');
Route::post('atualizar-perfil', 'Admin\UserController@profileUpdate')->name('profile.update')->middleware('auth');

Route::get('/', 'Site\SiteController@index')->name('home');

Auth::routes();
