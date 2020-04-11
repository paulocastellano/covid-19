<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use Illuminate\Support\Facades\Http;

use App\Models\City;

class UpdateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update data from brasil.io';

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
        // começa com true
        $next_page = "https://brasil.io/api/dataset/covid19/caso/data?format=json";

        // se ainda tiver mais paginas
        while ($next_page) {

            // faz o get
            $response = Http::get($next_page);


            // se tiver proxima pagina ja atribui
            if($response->json()['next']) {
                $next_page = $response->json()['next'];
            }

            // se nao tiver seta null e acaba
            else {
                $next_page = null;
            }

            // varre os dados
            foreach($response->json()['results'] as $result) {

                // se for o ultimo
                if($result['is_last'] == true) {

                    // se for Importados/Indefinidos
                    if($result['city'] == 'Importados/Indefinidos') {

                        // pega a cidade pelo nome e estado
                        $last = City::where('is_last', 1)->where('city', $result['city'])->where('state', $result['state'])->first();
                    }

                    // se tiver ibge codigo
                    else {

                        // pega a cidade pelo codigo do ibge
                        $last = City::where('is_last', 1)->where('city_ibge_code', $result['city_ibge_code'])->first();
                    }


                    // se a data for dirente
                    if($last->date != $result['date']) {

                        // atualiza o antigo
                        $last->is_last = 0;
                        $last->save();

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
            }
        }

        $this->info("Update data done.");
    }
}
