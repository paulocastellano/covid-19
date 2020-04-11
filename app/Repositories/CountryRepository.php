<?php

namespace App\Repositories;

use App\Models\City;

use Cache, DB, Carbon;

class CountryRepository {

    public function getEvolutionByPeriod() {

        // pega do cash
        $evolution = Cache::get('evolution');

        // // se nao encontrar
        // if(!$evolution) {

            // pega na base
            $evolution =
            City::select(
                'date',
                DB::raw("SUM(confirmed) as totalConfirmed"),
                DB::raw("SUM(deaths) as totalDeaths"),
                DB::raw("SUM(death_rate) as totalDeathRate")
            )
            ->where('place_type', 'state')
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
            // Cache::put('evolution', $evolution, now()->addHours(12));
        // }

        return $evolution;
    }

    public function removeCache() {

        // remove cache
        Cache::forget('states');
    }
}
