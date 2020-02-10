<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CurrencyTableSeeder::class);

        $date = Carbon::now();
        $month = $date->subMonth()->format('m');

        $year = $month < 12 ? $date->year : $date->subYear();

        Artisan::call('rates:archive ' . $month . ' ' . $year);

        for ($day = 1; $day <= $date->day; $day++) {
            $day = $day < 10 ? '0' . $day : $day;

            Artisan::call('rates:get ' . $day . ' ' . now()->format('m') . ' ' . $date->year);
        }

        Artisan::call('rates:update');
    }
}
