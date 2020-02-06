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
Route::get('valuta/{currency}', 'CurrencyController@show')->name('currency.show');

Route::get('valuta/{currency}/graph', 'CurrencyController@graph')->name('currency.graph');
