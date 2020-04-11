<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\City;


class CitiesController extends Controller
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
        $cities = City::where('is_last', true)->orderBy('confirmed', 'desc')->get();
        return response()->json($cities);
    }
}
