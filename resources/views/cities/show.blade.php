@extends('layouts.app')
@section('content')
<div class="container">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('states.show' , strtolower($totalOfCasesOfCity->state))  }}">{{ $totalOfCasesOfCity->state }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $totalOfCasesOfCity->city }}</li>
        </ol>
    </nav>

    <div class="row text-center">
        <div class="col-6">
            <div class="alert alert-primary" role="alert">
                <p class="mb-1">Total de casos confirmados</p>
                <h4 class="alert-heading">{{ $totalOfCasesOfCity->confirmed }}</h4>
            </div>
        </div>

        <div class="col-6">
            <div class="alert alert-danger" role="alert">
                <p class="mb-1">Total óbitos</p>
                <h4 class="alert-heading">{{ $totalOfCasesOfCity->deaths }}</h4>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center">
                        Evolução de casos de covid-19 na cidade de {{ $totalOfCasesOfCity->city }}
                    </h1>
                    <graphs-evolution :evolution="{{$evolution}}" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
