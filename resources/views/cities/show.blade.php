@extends('layouts.app')
@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                Visão geral do covid-19 na cidade de {{ $totalOfCasesOfCity->city }}
            </h1>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="h5">Confirmados</div>
                        <div class="display-4 font-weight-bold mb-4">{{ number_format($totalOfCasesOfCity->confirmed) }}</div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="h5">Óbitos</div>
                        <div class="display-4 font-weight-bold mb-4">{{ number_format($totalOfCasesOfCity->deaths) }}</div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-red" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cards row-deck">
            <div class="col-12">
                <div class="card">
                    <div class="card-status bg-blue"></div>
                    <div class="card-header">
                        <h2 class="card-title">
                            Evolução de casos de covid-19 na cidade de {{ $totalOfCasesOfCity->city }}
                        </h2>
                    </div>
                    <div class="card-body">
                        <graphs-evolution :evolution="{{$evolution}}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


{{-- <div class="container">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('states.show' , strtolower($totalOfCasesOfCity->state))  }}">{{ $totalOfCasesOfCity->state }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $totalOfCasesOfCity->city }}</li>
        </ol>
    </nav>

 --}}
