@extends('layouts.main')

@section('content')
<!-- push external head elements to head -->
@push('head')
<title>{{ __('Airpleanes')}}</title>
@endpush

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="fas fa-plane bg-linkedin"></i>
                    <div class="d-inline">
                        <h5>
                        {{ __('Airpleanes')}}  
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
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Airpleanes')}}</li>
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
                    <h3>{{ __('Airpleanes') }}</h3>
                    <div class="right" style="float: right;">
                        <a href="{{ route('admin.airplane.create') }}" class="btn btn-primary js-dynamic-enable">{{ __('Add new') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="data_table" class="table">
                        <thead>
                            <tr>
                                <th>{{ __('#') }}</th>
                                <th>{{ __('Name')}}</th>
                                <th>{{ __('Type')}}</th>
                                <th>{{ __('Max seats')}}</th>
                                <th>{{ __('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($airplanes as $key => $airplane)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $airplane->name }}</td>
                                <td>{{ $airplane->type }}</td>
                                <td>{{ $airplane->max_seat }}</td>
                            <td>
                                <a href="{{ route('admin.airplane.show', $airplane->id) }}"><i
                                        class="ik ik-edit f-16 mr-15 text-green"></i></a>
                                        <a href=""
                                        onclick="setRoute('{{ $airplane->id }}', '{{ route('admin.airplane.destroy', $airplane) }}')"
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
