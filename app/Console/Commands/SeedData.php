<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB, Log, Cache;

use Illuminate\Support\Facades\Http;

use App\Models\City;

class SeedData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed data from brasil.io';

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
        // zera o banco
        $this->call('migrate:fresh');

        try {
            // começa com true
            $nextPage = "https://brasil.io/api/dataset/covid19/caso/data?format=json";

            // se ainda tiver mais paginas
            while ($nextPage) {

                // faz o get
                $response = Http::get($nextPage);


                // se tiver proxima pagina ja atribui
                if($response->json()['next']) {
                    $nextPage = $response->json()['next'];
                }

                // se nao tiver seta null e acaba
                else {
                    $nextPage = null;
                }

                // varre as respostas
                foreach($response->json()['results'] as $result) {

                    // cria o novo registro
                    $city = new City;
                    $city->city = $result['city'];
                    $city->city_ibge_code = $result['city_ibge_code'];
                    $city->confirmed = $result['confirmed'];
                    $city->confirmed_per_100k_inhabitants = $result['confirmed_per_100k_inhabitants'];

                    $city->date = $result['date'];
                    $city->death_rate = $result['death_rate'];
                    $city->deaths = $result['deaths'];

                    $city->estimated_population_2019 = $result['estimated_population_2019'];
                    $city->is_last = $result['is_last'];
                    $city->order_for_place = $result['order_for_place'];
                    $city->place_type = $result['place_type'];
                    $city->state = $result['state'];

                    $city->save();

                }
            }

            // console alert
            $this->info("Seed data done.");

            // flush all cache
            Cache::flush();

        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}
