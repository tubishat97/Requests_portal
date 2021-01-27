@extends('layouts.main')

@section('content')
<!-- push external head elements to head -->
@push('head')
<title>{{ __('Airlines')}}</title>
@endpush

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="fas fa-broadcast-tower bg-linkedin"></i>
                    <div class="d-inline">
                        <h5>
                        {{ __('Airlines')}}  
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
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Airlines')}}</li>
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
                    <h3>{{ __('Airlines') }}</h3>
                    <div class="right" style="float: right;">
                        <a href="{{ route('admin.airline.create') }}" class="btn btn-primary js-dynamic-enable">{{ __('Add new') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="data_table" class="table">
                        <thead>
                            <tr>
                                <th>{{ __('#') }}</th>
                                <th>{{ __('Name')}}</th>
                                <th>{{ __('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($airlines as $key => $airline)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $airline->name }}</td>
                            <td>
                                <a href="{{ route('admin.airline.show', $airline->id) }}"><i
                                        class="ik ik-edit f-16 mr-15 text-green"></i></a>
                                        <a href=""
                                        onclick="setRoute('{{ $airline->id }}', '{{ route('admin.airline.destroy', $airline) }}')"
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
