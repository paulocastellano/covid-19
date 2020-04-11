<?php

namespace App\Repositories;

use App\Models\City;

use Cache, DB;

class CityRepository {

    public function getCitiesByState($state) {

        // pega do cash
        $cities = Cache::get("cities-by-state-$state");

        // se nao encontrar
        if(!$cities) {

            // pega na base
            $cities = City::where('is_last', true)
            ->where('place_type', 'city')
            ->where('state', strtoupper($state))
            ->orderBy('confirmed', 'desc')->get();

            // joga no cache
            Cache::tags(['city'])->put("cities-by-state-$state", $cities, now()->addHours(12));
        }

        return $cities;
    }

    public function getEvolutionByCity($city) {

        // pega do cash
        $evolution = Cache::get("evolution-city-$city");

        // se nao encontrar
        if(!$evolution) {

            // pega no banco
            $evolution = City::select(
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

            // joga no cache
            Cache::tags(['city'])->put("evolution-city-$city", $evolution, now()->addHours(12));
        }

        return $evolution;
    }
}
