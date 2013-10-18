<?php
/**
 * Application routes
 */
Route::get('/', array('before' => 'guest', 'uses' => 'HomeController@index'));

Route::get('account', array('before' => 'guest', 'uses' => 'AccountController@index'));
Route::get('account/login', array('before' => 'guest', 'uses' => 'AccountController@login'));
Route::post('account/loginPost', array('before' => 'guest', 'uses' => 'AccountController@loginPost'));
Route::get('account/create', array('before' => 'guest', 'uses' => 'AccountController@create'));
Route::post('account/createPost', array('before' => 'guest', 'uses' => 'AccountController@createPost'));
Route::get('account/success', array('before' => 'guest', 'uses' => 'AccountController@success'));
Route::get('account/logOut', 'AccountController@logOut');

Route::get('dashboard', array('before' => 'auth', 'uses' => 'DashboardController@index'));

Route::get('tablet/create', array('before' => 'auth', 'uses' => 'TabletController@create'));
Route::post('tablet/createPost', array('before' => 'auth', 'uses' => 'TabletController@createPost'));
Route::post('tablet/close', array('before' => 'auth', 'uses' => 'TabletController@close'));
Route::get('tablet/closeSuccess', array('before' => 'auth', 'uses' => 'TabletController@closeSuccess'));

Route::post('prediction/create', array('before' => 'auth', 'uses' => 'PredictionController@create'));

Route::post('expense/create', array('before' => 'auth', 'uses' => 'ExpenseController@create'));

Route::post('income/create', array('before' => 'auth', 'uses' => 'IncomeController@create'));

Route::post('economy/create', array('before' => 'auth', 'uses' => 'EconomyController@create'));

Route::get('test', 'TestController@test');