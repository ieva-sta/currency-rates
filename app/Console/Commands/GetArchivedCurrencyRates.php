<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\Rate;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Symfony\Component\DomCrawler\Crawler;

class GetArchivedCurrencyRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rates:get {day} {month} {year}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch archived currency rate data from www.bank.lv, save data to database';

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
     * @throws Exception
     */
    public function handle()
    {
        $day = $this->argument('day');
        $month = $this->argument('month');
        $year = $this->argument('year');
        $date = new Carbon($year . '-' . $month . '-' . $day);

        $url = 'https://www.bank.lv/vk/ecb.xml?date=' . $year . $month . $day;

        try {
            $xml = file_get_contents($url);
            $crawler = new Crawler();
            $crawler->addXmlContent($xml);

            $cRates = $crawler->filterXPath('//default:CRates')->children();
            $items = $cRates->eq(1)->children();

            $data = [];
            foreach ($items as $key => $item) {
                $currency = $items->eq($key)->children()->eq(0)->text();
                $rate = $items->eq($key)->children()->eq(1)->text();

                $currency = Currency::whereCode($currency)->first();

                Rate::updateOrCreate([
                    'currency_id' => $currency->id,
                    'date'        => $date
                ], [
                    'price' => $rate,
                ]);
            }

            echo "Currency rates updated";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
