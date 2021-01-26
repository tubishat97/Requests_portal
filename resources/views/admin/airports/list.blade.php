@extends('layouts.main')

@section('content')
<!-- push external head elements to head -->
@push('head')
<title>{{ __('Airports')}}</title>
@endpush

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="fas fa-plane-arrival bg-linkedin"></i>
                    <div class="d-inline">
                        <h5>
                        {{ __('Airports')}}  
                            </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Airports')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- start message area-->
        @include('include.message')
        <!-- end message area-->
        <div class="col-md-12">
            <div class="card p-3">
                <div class="card-header" style="display: inline-block;">
                    <h3>{{ __('Airports') }}</h3>
                    <div class="right" style="float: right;">
                        <a href="{{ route('admin.airport.create') }}" class="btn btn-primary js-dynamic-enable">{{ __('Add new') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="data_table" class="table">
                        <thead>
                            <tr>
                                <th>{{ __('#') }}</th>
                                <th>{{ __('Name')}}</th>
                                <th>{{ __('location')}}</th>
                                <th>{{ __('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($airports as $key => $airport)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $airport->name }}</td>
                                <td>{{ 
                                        $airport->city_location.' '
                                }}
                                    <a target="_blank"
                                    href="https://www.google.com/maps?q={{ $airport->lat}}+{{$airport->lon}}&12z">
                                    <i class="fas fa-map-pin"></i>
                                    </a>    
                            </td>
                            <td>
                                <a href="{{ route('admin.airport.show', $airport->id) }}"><i
                                        class="ik ik-edit f-16 mr-15 text-green"></i></a>
                                        <a href=""
                                        onclick="setRoute('{{ $airport->id }}', '{{ route('admin.airport.destroy', $airport) }}')"
                                        data-toggle="modal" data-target="#exampleModalCenter"> <i
                                            class="ik ik-trash-2 f-16 text-red"></i>
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
@endsection
