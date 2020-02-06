<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
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
            'currency' => $currency
        ]);
    }


    /**
     * Fetch currency rates from the last 30 days
     *
     * @param Currency $currency
     * @return JsonResponse
     */
    public function graph(Currency $currency): JsonResponse
    {
        $rates = $currency->rates()
            ->where('date', '>=', Carbon::now()->subDays(30))
            ->orderBy('date');

        $data = [
            'labels' => $rates->pluck('date')->toArray(),
            'rates'  => $rates->pluck('price')->toArray()
        ];

        return response()->json($data);
    }
}
