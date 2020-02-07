<?php

namespace App\Http\Resources;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id'     => $this->id,
            'symbol' => $this->symbol,
            'code'   => $this->code,
            'title'  => $this->title,
            'trend'  => $this->getTrend()
        ];

        if ($request->currency === 'EUR') {
            $data['rate'] = number_format($this->rates->last()->price, 8);

            return $data;
        }

        $selectedCurrency = optional(Currency::where('code', $request->currency)->first())->rates->last()->price;
        $selectedCurrencyRate = $selectedCurrency ? 1 / $selectedCurrency : 1;
        $rate = $selectedCurrencyRate * $this->rates->last()->price;

        $data['rate'] = number_format($rate, 8);

        return $data;
    }
}
