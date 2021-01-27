@extends('layouts.main')

@section('content')
<!-- push external head elements to head -->
@push('head')
<title>{{ __('Update flight')}}</title>
<link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/mohithg-switchery/dist/switchery.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/summernote/dist/summernote-bs4.css') }}">
@endpush

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="fas fa-plane-departure bg-linkedin"></i>
                    <div class="d-inline">
                        <h5>{{ __('Update flight')}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.flight.index') }}">{{ __('Flights')}}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Update flight')}}</li>
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
            <div class="card ">
                <div class="card-header">
                    <h3>{{ __('Update flight')}}</h3>
                </div>
                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST" action="{{ route('admin.flight.update', $flight->id) }}">
                        @csrf
                        @method('PUT')
                        <hr class="cm-bold">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Airline')}}<span class="text-red">*</span></label>
                                    {!! Form::select('airline', $airlines,
                                    $flight->airline->id, [ 'class' => 'form-control select2', 'placeholder'=> 'airlines']) !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('airplane')}}<span class="text-red">*</span></label>
                                    {!! Form::select('airplane', $airplanes,
                                    $flight->airplane->id, [ 'class' => 'form-control select2', 'placeholder'=> 'airplanes'])
                                    !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <hr class="cm-bold">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('From airport')}}<span class="text-red">*</span></label>
                                    {!! Form::select('from_airport', $airports,
                                    $flight->fromAirport->id, [ 'class' => 'form-control select2', 'placeholder'=> 'airports']) !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('To airport')}}<span class="text-red">*</span></label>
                                    {!! Form::select('to_airport', $airports,
                                    $flight->toAirport->id, [ 'class' => 'form-control select2', 'placeholder'=> 'airports'])
                                    !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">{{
                                        __('admin-content.submit')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- push external js -->
@push('script')
<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/form-components.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-validator/validator.min.js') }}"></script>
<script src="{{ asset('plugins/summernote/dist/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script src="{{ asset('plugins/toastr-master/toastr.js') }}"></script>
@endpush
@endsection
