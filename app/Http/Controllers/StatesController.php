<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\StateRepository;
use App\Repositories\CityRepository;

use Cache, SEO;

use App\Models\City;


class StatesController extends Controller
{
    protected $stateRepository;

    protected $cityRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->stateRepository = new stateRepository;
        $this->cityRepository = new cityRepository;
    }

    public function show($state)
    {
        $state = City::where('place_type', 'state')->where('state', $state)->first();
        if(!$state) {
            abort(404);
        }

        /**
         * Seo
         */
        SEO::setTitle("Notícias e evolução do coronavirus no estado de $state->state | COVID-19");
        SEO::setDescription("Estatísticas, notícias, gráficos e evolução coronavirus no estado de $state->state. Veja mais sobre o COVID-19.");

        // total of cases of state
        $totalOfCasesOfState = City::where('is_last', true)
            ->where('place_type', 'state')
            ->where('state', $state->state)
            ->first();

        // evolution of covid in the state...
        $evolution = $this->stateRepository->getEvolutionByState($state->state);

        // get cities from state
        $cities = $this->cityRepository->getCitiesByState($state->state);

        return view('states.show')
            ->with('cities', $cities)
            ->with('evolution', $evolution)
            ->with('totalOfCasesOfState', $totalOfCasesOfState);
    }
}
