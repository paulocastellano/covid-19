<?php

namespace App\Repositories;

use App\Models\City;

use Cache, DB;

class CityRepository {

    public function getCitiesByState($state) {

        // pega do cash
        // $cities = Cache::get('cities');

        // se nao encontrar
        // if(!$states) {

            // pega na base
            $cities = City::where('is_last', true)
            ->where('place_type', 'city')
            ->where('state', strtoupper($state))
            ->orderBy('confirmed', 'desc')->get();

            // joga no cache
            // Cache::put('states', $states, now()->addHours(12));
        // }

        return $cities;
    }

    public function getEvolutionByCity($city) {
        $evolution =
            City::select(
                'date',
                DB::raw("SUM(confirmed) as totalConfirmed"),
                DB::raw("SUM(deaths) as totalDeaths"),
                DB::raw("SUM(death_rate) as totalDeathRate")
            )
            ->where('place_type', 'city')
            ->where('city', $city)
            ->groupBy('date')
            ->orderBy('totalConfirmed', 'asc')
            ->get()
            ->map(function ($data) {
                return [
                    'totalDeaths' => $data->totalDeaths,
                    'totalConfirmed' => $data->totalConfirmed,
                    'totalDeathRate' => $data->totalDeathRate,
                    'date' => \Carbon\Carbon::createFromFormat('Y-m-d', $data->date)->format('d/m')
                ];
            });

        return $evolution;

    }
}
