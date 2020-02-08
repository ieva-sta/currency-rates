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

Route::get('/', 'CurrencyController@index')->name('currency.index');
Route::get('currency/{currency}', 'CurrencyController@show')->name('currency.show');
Route::get('currency/{currency}/rates', 'CurrencyController@getRates')->name('currency.rates');

Route::get('currencies', 'CurrencyController@getCurrencyData')->name('currency.table');
Route::get('currencies/all', 'CurrencyController@getAllCurrencies')->name('currency.all');
Route::get('currency/{currency}/graph/{days}', 'CurrencyController@graph')->name('currency.graph');

