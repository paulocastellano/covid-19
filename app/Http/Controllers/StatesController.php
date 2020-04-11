<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cache;

use App\Models\City;


class StatesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
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

        return response()->json($states);
    }
}
