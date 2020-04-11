<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\StateRepository;
use App\Repositories\CityRepository;

use Cache;

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
