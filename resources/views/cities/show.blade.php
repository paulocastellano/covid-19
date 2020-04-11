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

    <div class="row mb-5">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center">
                        Total de casos de covid-19 na cidade de {{ $totalOfCasesOfCity->city }}: <strong>{{ $totalOfCasesOfCity->confirmed }}</strong>
                    </h1>
                    <graphs-evolution :evolution="{{$evolution}}" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
