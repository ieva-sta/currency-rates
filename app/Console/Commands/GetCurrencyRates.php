<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\Rate;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Symfony\Component\DomCrawler\Crawler;

class GetCurrencyRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rates:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch latest currency rate data from www.bank.lv, save data to database';

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
     */
    public function handle()
    {
        $url = 'https://www.bank.lv/vk/ecb_rss.xml';

        try {
            $xml = file_get_contents($url);
            $crawler = new Crawler($xml);

            $items = $crawler->filter('channel item');
            $dates = $items->filter('pubDate')->extract(['_text']);
            $descriptions = $items->filter('description')->extract(['_text']);

            $itemData = array_map(function () {
                return func_get_args();
            }, $dates, $descriptions);

            foreach ($itemData as $data) {
                $date = Carbon::parse($data[0]);

                $currencies = explode(' ', $data[1]);
                $currencies = array_chunk($currencies, 2);
                $currencies = array_filter($currencies, 'array_filter');

                foreach ($currencies as $currencyData) {
                    $currency = Currency::whereCode($currencyData[0])->first();

                    Rate::updateOrCreate([
                        'currency_id' => $currency->id,
                        'date'        => $date->format('Y-m-d')
                    ], [
                        'price' => $currencyData[1],
                    ]);
                }
            }

            echo "Currency rates updated";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
