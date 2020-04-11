<?php

namespace App\Repositories;

use App\Models\City;

use Cache, DB;

class StateRepository {

    public function get() {

        // pega do cash
        $states = Cache::get('states');

        // se nao encontrar
        if(!$states) {

            // pega na base
            $states = City::where('is_last', true)
            ->where('place_type', 'state')
            ->orderBy('confirmed', 'desc')->get();

            // joga no cache
            Cache::put('states', $states, now()->addHours(12));
        }

        return $states;
    }

    public function getEvolutionByState($state) {
        $evolution =
            City::select(
                'date',
                DB::raw("SUM(confirmed) as totalConfirmed"),
                DB::raw("SUM(deaths) as totalDeaths"),
                DB::raw("SUM(death_rate) as totalDeathRate")
            )
            ->where('place_type', 'state')
            ->where('state', strtoupper($state))
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
