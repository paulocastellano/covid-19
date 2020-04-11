<?php

namespace App\Repositories;

use App\Models\City;

use Cache, DB;

class StateRepository {

    public function get() {

        //Retrieve from cache
        $states = Cache::get('states');

        // if not found on cache
        if(!$states) {

            // get in database
            $states = City::where('is_last', true)
            ->where('place_type', 'state')
            ->orderBy('confirmed', 'desc')
            ->get();

            // Create new cache
            Cache::tags(['state'])->put('states', $states, now()->addHours(12));
        }

        return $states;
    }

    public function getEvolutionByState($state) {

        // Retrieve from cache
        $evolution = Cache::get("evolution-by-state-$state");

        // if not found on cache
        if(!$evolution) {

            // get in database
            $evolution = City::select(
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

            // Create new cache
            Cache::tags(['state'])->put("evolution-by-state-$state", $evolution, now()->addHours(12));
        }

        return $evolution;

    }
}
