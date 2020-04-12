<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\CountryRepository;
use App\Repositories\StateRepository;

use Cache, SEO;

use App\Models\City;

class HomeController extends Controller
{
    protected $stateRepository;

    protected $countryRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->stateRepository = new stateRepository;
        $this->countryRepository = new countryRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        /**
         * Seo
         */
        SEO::setTitle('Estatísticas, notícias e evolução do coronavirus pelo Brasil');
        SEO::setDescription('Estatísticas, notícias, gráficos e evolução do coronavirus por cidade, estado e Brasil. Veja como está o covid-19 na sua cidade.');

        // total of cases in brazil
        $totalOfCasesInBrazil = $this->countryRepository->getTotalOfCasesInBrazil();

        // total of death in brazil
        $totalOfDeathInBrazil = $this->countryRepository->getTotalDeathInBrazil();

        // covid by states...
        $states = $this->stateRepository->get();

        // evolution of covid in the country...
        $evolution = $this->countryRepository->getEvolutionByPeriod();

        return view('home.index')
            ->with('totalOfCasesInBrazil', $totalOfCasesInBrazil)
            ->with('totalOfDeathInBrazil', $totalOfDeathInBrazil)
            ->with('evolution', $evolution)
            ->with('states', $states);
    }
}
