@extends('layouts.app')
@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                Visão geral do covid-19 no Brasil
            </h1>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="h5">Confirmados</div>
                        <div class="display-4 font-weight-bold mb-4">{{ number_format($totalOfCasesOfState->confirmed) }}</div>
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
                        <div class="display-4 font-weight-bold mb-4">{{ number_format($totalOfCasesOfState->deaths) }}</div>
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
                        <h2 class="card-title">Evolução de casos de covid-19 no estado de {{ $totalOfCasesOfState->state }}</h2>
                    </div>
                    <div class="card-body">
                        <graphs-evolution :evolution="{{$evolution}}" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cards row-deck">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Casos de covid-19 por cidade</h2>
                    </div>
                    <div class="table-responsive">
                    <div class="card-status bg-blue"></div>
                        <table class="table card-table table-vcenter text-nowrap table-sm text-center">
                            <thead>
                                <tr>
                                    <th class="w-1">Estado</th>
                                    <th>Confirmados</th>
                                    <th>Mortes</th>
                                    <th>Tax. mortalidade</th>
                                    <th>Última atualização</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cities as $city)
                                    <tr>
                                        <td>
                                            <a href="{{ route('cities.show' , ['state' => strtolower($city->state), 'city' => strtolower($city->city)])  }}" >
                                                {{ $city->city }}
                                            </a>
                                        </td>
                                        <td> {{ $city->confirmed }}</td>
                                        <td> {{ $city->deaths }}</td>
                                        <td> {{ $city->death_rate ? ($city->death_rate * 100) : 0 }}%</td>
                                        <td>
                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $city->updated_at)->locale('pt-br')->diffForHumans() }}
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('cities.show' , ['state' => strtolower($city->state), 'city' => strtolower($city->city)])  }}" class="btn btn-primary btn-sm">Detalhes</a>
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