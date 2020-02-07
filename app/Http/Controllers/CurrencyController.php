<?php

namespace App\Http\Controllers;

use App\Http\Resources\CurrencyResource;
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
     * Display a listing of the resource.
     * Return all currencies that have data for rates
     */
    public function index()
    {
        $currencies = Currency::has('rates')->paginate(7);

        return view('currency.index')->with([
            'currencies' => $currencies
        ]);
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function getCurrencyData(Request $request)
    {
        switch ($request->column) {
            case 'rate':
                $query = Currency::has('rates')
                    ->join('rates', 'rates.currency_id', '=', 'currencies.id')
                    ->select('currencies.*')
                    ->orderBy('rates.price', $request->order)
                    ->get()
                    ->unique();
                break;
            default:
                $query = Currency::has('rates')->orderBy($request->column, $request->order)->get();
        }

        $currencies = new LengthAwarePaginator($query->forPage($request->page, 5), $query->count(), 5);

        return CurrencyResource::collection($currencies);
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
     * @param int $days
     * @return JsonResponse
     */
    public function graph(Currency $currency, int $days): JsonResponse
    {
        $rates = $currency->rates()
            ->where('date', '>=', Carbon::now()->subDays($days))
            ->orderBy('date');

        $data = [
            'labels' => $rates->pluck('date')->toArray(),
            'rates'  => $rates->pluck('price')->toArray()
        ];

        return response()->json($data);
    }
}
