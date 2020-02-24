<?php

namespace App\Http\Controllers;

use App\Http\Resources\CurrencyResource;
use App\Http\Resources\RateResource;
use App\Models\Currency;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class CurrencyController extends Controller
{

    /**
     * @param Currency $currency
     * @return Factory|View
     */
    public function show(Currency $currency)
    {
        $currencies = Currency::has('rates')->get()->except($currency->id);

        return view('currency.show')->with([
            'currency'   => $currency,
            'currencies' => $currencies
        ]);
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function getCurrencyData(Request $request)
    {
        if ($request->column === 'rate') {
            $query = Currency::has('rates')
                ->join('rates', 'rates.currency_id', '=', 'currencies.id')
                ->select('currencies.*')
                ->orderBy('rates.price', $request->order)
                ->get()
                ->unique();
        }

        if ($request->column !== 'rate') {
            $query = Currency::has('rates')->orderBy($request->column, $request->order)->get();
        }

        $currencies = new LengthAwarePaginator($query->forPage($request->page, 5), $query->count(), 5);

        return CurrencyResource::collection($currencies);
    }

    /**
     * Fetch currency rates from the last 30 days
     *
     * @param Currency $currency
     * @param int $days
     * @return JsonResponse
     */
    public function graph(Currency $currency, int $days): JsonResponse
    {
        $rates = $currency->rates()
            ->where('date', '>=', Carbon::now()->subDays($days));

        $labels = $rates->pluck('date')->map(function ($date) {
            return $date->format('d.m');
        })->toArray();

        $data = [
            'labels' => $labels,
            'rates'  => $rates->pluck('price')->toArray()
        ];

        return response()->json($data);
    }

    /**
     * @param Currency $currency
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function getRates(Currency $currency, Request $request): AnonymousResourceCollection
    {
        $rates = $currency->rates->sortByDesc('date');
        $rates = new LengthAwarePaginator($rates->forPage($request->page, 7), $rates->count(), 7);

        return RateResource::collection($rates);
    }

    /**
     * @return JsonResponse
     */
    public function getAllCurrencies(): JsonResponse
    {
        $currencies = Currency::has('rates')->get();
        $eur = Currency::where('code', 'EUR')->first();

        $currencies->prepend($eur);

        return response()->json([
            'data' => $currencies
        ]);
    }
}
