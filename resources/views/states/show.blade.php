@extends('layouts.app')

@section('content')
<div class="container">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $totalOfCasesOfState->state }}</li>
        </ol>
    </nav>

    <div class="row text-center">
        <div class="col-6">
            <div class="alert alert-primary" role="alert">
                <p class="mb-1">Total de casos confirmados</p>
                <h4 class="alert-heading">{{ $totalOfCasesOfState->confirmed }}</h4>
            </div>
        </div>

        <div class="col-6">
            <div class="alert alert-danger" role="alert">
                <p class="mb-1">Total óbitos</p>
                <h4 class="alert-heading">{{ $totalOfCasesOfState->deaths }}</h4>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center">
                        Evolução de casos de covid-19 no estado de {{ $totalOfCasesOfState->state }}
                    </h1>
                    <graphs-evolution :evolution="{{$evolution}}" />
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center">Casos de covid-19 por cidade</h2>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm text-center">
                            <thead>
                                <tr>
                                <th scope="col">Cidade</th>
                                <th scope="col">Confirmados</th>
                                <th scope="col">Mortes</th>
                                <th scope="col">Taxa de mortalidade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cities as $city)
                                    <tr>
                                        <td>
                                            <a href="{{ route('cities.show' , ['state' => strtolower($city->state), 'city' => strtolower($city->city)])  }}">
                                                {{ $city->city }}
                                            </a>
                                        </td>
                                        <td> {{ $city->confirmed }}</td>
                                        <td> {{ $city->deaths }}</td>
                                        <td> {{ $city->death_rate ? $city->death_rate : 0 }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection
