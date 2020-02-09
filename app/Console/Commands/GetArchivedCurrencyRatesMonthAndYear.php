<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;

class GetArchivedCurrencyRatesMonthAndYear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rates:archive {month} {year}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws Exception
     */
    public function handle()
    {
        $month = $this->argument('month');
        $year = $this->argument('year');

        $date = new Carbon($year . '-' . $month . '-' . '01');

        for ($i = 1; $i <= $date->daysInMonth; $i++) {
            Artisan::call('rates:get', [
                'day'   => $i,
                'month' => $month,
                'year'  => $year
            ]);
        }
    }
}
