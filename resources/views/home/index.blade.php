@extends('layouts.app')

@section('content')
<div class="container">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Home</li>
        </ol>
    </nav>

    <div class="row text-center">
        <div class="col-6">
            <div class="alert alert-primary" role="alert">
                <p class="mb-1">Confirmados</p>
                <h4 class="alert-heading">{{ $totalOfCasesInBrazil }}</h4>
            </div>
        </div>

        <div class="col-6">
            <div class="alert alert-danger" role="alert">
                <p class="mb-1">Óbitos</p>
                <h4 class="alert-heading">{{ $totalOfDeathInBrazil }}</h4>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center">Evolução de casos de covid-19 no Brasil</h2>
                    <graphs-evolution :evolution="{{$evolution}}" />
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center">Casos de covid-19 por estados</h2>

                    <div class="table-responsive">
                        <table class="table table-striped table-sm text-center">
                            <thead>
                                <tr>
                                <th scope="col">Estado</th>
                                <th scope="col">Confirmados</th>
                                <th scope="col">Mortes</th>
                                <th scope="col">Taxa de mortalidade</th>
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($states as $state)
                                    <tr>
                                        <td>
                                            <a href="{{ route('states.show' , strtolower($state->state)) }}">
                                                {{ $state->state }}
                                            </a>
                                        </td>
                                        <td> {{ $state->confirmed }}</td>
                                        <td> {{ $state->deaths }}</td>
                                        <td> {{ $state->death_rate ? ($state->death_rate * 100) : 0 }}%</td>
                                        <td>
                                            <a class="btn btn-sm btn-success"  href="{{ route('states.show' , strtolower($state->state)) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                            </a>
                                        </td>
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
