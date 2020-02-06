<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     * Return all currencies that have data for rates
     */
    public function index()
    {
        $currencies = Currency::has('rates')->paginate(10);

        return view('currency.index')->with([
            'currencies' => $currencies
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Currency $currency
     * @return Factory|View
     */
    public function show(Currency $currency)
    {
        return view('currency.show')->with([
            'currency' => $currency->with('rates')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Currency $currency
     * @return void
     */
    public function graph(Currency $currency)
    {
        //
    }
}
