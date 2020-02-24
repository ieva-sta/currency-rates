<?php

Route::view('/', 'currency.index');
Route::get('currency/{currency}', 'CurrencyController@show')->name('currency.show');

Route::get('currency/{currency}/graph/{days}', 'CurrencyController@graph')->name('currency.graph');

Route::get('currencies', 'CurrencyController@getCurrencyData')->name('currency.table');
Route::get('currency/{currency}/rates', 'CurrencyController@getRates')->name('currency.rates');
Route::get('currencies/all', 'CurrencyController@getAllCurrencies')->name('currency.all');

