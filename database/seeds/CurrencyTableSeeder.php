<?php

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencyData = file_get_contents(resource_path('Common-Currency.json'));
        $currencies = json_decode($currencyData);

        foreach ($currencies as $currency) {
            Currency::create([
                'code'   => $currency->code,
                'title'  => $currency->name,
                'symbol' => $currency->symbol
            ]);
        }
    }
}
