<?php

namespace App\Repositories;

use App\Models\City;

use Cache, DB, Carbon;

class CountryRepository {

    public function getTotalDeathInBrazil() {
        // retrieve from cache
        $totalOfDeathInBrazil = Cache::get('total-of-death-in-brazil');

        // if not found on cache
        if(!$totalOfDeathInBrazil) {

            // get in database
            $totalOfDeathInBrazil = City::where('is_last', true)
            ->where('place_type', 'state')
            ->sum('deaths');

            // Create new cache
            Cache::tags(['country'])->put('total-of-death-in-brazil', $totalOfDeathInBrazil, now()->addHours(12));
        }

        return $totalOfDeathInBrazil;
    }

    public function getTotalOfCasesInBrazil() {

        // retrieve from cache
        $totalOfCasesInBrazil = Cache::get('total-of-cases-in-brazil');

        // if not found on cache
        if(!$totalOfCasesInBrazil) {

            // get in database
            $totalOfCasesInBrazil = City::where('is_last', true)
            ->where('place_type', 'state')
            ->sum('confirmed');

            // Create new cache
            Cache::tags(['country'])->put('total-of-cases-in-brazil', $totalOfCasesInBrazil, now()->addHours(12));
        }

        return $totalOfCasesInBrazil;
    }

    public function getEvolutionByPeriod() {

        // retrieve from cache
        $evolution = Cache::get('evolution-country');

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
            ->groupBy('date')
            ->orderBy('date', 'asc')
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
            Cache::tags(['country'])->put('evolution-country', $evolution, now()->addHours(12));
        }

        return $evolution;
    }
}
