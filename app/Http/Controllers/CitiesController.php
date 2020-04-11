<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\City;

use App\Repositories\CityRepository;


class CitiesController extends Controller
{
    protected $cityRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->cityRepository = new cityRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($state, $city)
    {

        // check state
        $state = City::where('place_type', 'state')->where('state', $state)->first();
        if(!$state) {
            abort(404);
        }

        // check city
        $city = City::where('place_type', 'city')->where('city', $city)->first();
        if(!$city) {
            abort(404);
        }

        // total of cases of city
        $totalOfCasesOfCity = City::where('is_last', true)
            ->where('place_type', 'city')
            ->where('city', $city->city)
            ->where('state', $state->state)
            ->first();

        // evolution of covid in the state...
        $evolution = $this->cityRepository->getEvolutionByCity($city->city);

        return view('cities.show')
            ->with('evolution', $evolution)
            ->with('totalOfCasesOfCity', $totalOfCasesOfCity);
    }
}
