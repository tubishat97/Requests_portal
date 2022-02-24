@extends('layouts.main')
@section('content')
<!-- push external head elements to head -->
@push('head')
<title>{{' [' . $requestObj->claim_name_c->value . '] '. __('admin-content.notes') }}</title>
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/jvectormap/jquery-jvectormap.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/weather-icons/css/weather-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/c3/c3.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/owl.carousel/dist/assets/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
@endpush

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="fas fa-question bg-blue"></i>
                    <div class="d-inline">
                        <h5>{{' [' . $requestObj->claim_name_c->value . '] '. __('admin-content.notes') }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{' [' . $requestObj->claim_name_c->value
                            . '] '. __('admin-content.notes') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>
                        {{' [' . $requestObj->claim_name_c->value . '] '. __('admin-content.notes') }}
                    </h3>
                </div>
                <div id="chat-box" class="card-body chat-box scrollable card-300">
                    <ul class="chat-list">
                        @foreach ($notes as $note)
                        @if ($note->created_by->value != $user->crm_user_id)
                        <li class="chat-item">
                            <div class="chat-img">
                                <img src="{{ asset('img/user.jpg')}}" alt="{{ $user->name }}">
                            </div>
                            <div class="chat-content">
                                <h6 class="font-medium">{{ $user->name }}</h6>
                                <div class="box bg-light-info">{{ $note->note->value }}</div>
                            </div>
                            @php
                            $date = new DateTime($note->date_entered->value);
                            @endphp
                            <div class="chat-time">{{ $date->format('H:i') }}</div>
                        </li>
                        @else
                        <li class="odd chat-item">
                            <div class="chat-content">
                                <div class="box bg-light-inverse">{{ $note->note->value}}</div>
                                <br>
                            </div>
                            @php
                            $date = new DateTime($note->date_entered->value);
                            @endphp
                            <div class="chat-time">{{ $date->format('H:i') }}</div>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>
                {{-- @if($requestObj->status->value != 'proceed')
                <div class="card-footer chat-footer">
                    <form id="sendMsg">
                        @csrf
                        <div class="input-wrap">
                            <input type="hidden" name="beanID" value="{{ $requestObj->id->value }}">
                            <input type="text" id="contentMsg" name="content"
                                placeholder="{{__('admin-content.type-and-enter')}}" class="form-control" required />
                        </div>
                        <button type="submit" class="btn btn-icon btn-blue" style="margin-top: 10px;"><i
                                class="fa fa-paper-plane"></i></button>
                    </form>
                </div>
                @endif --}}
            </div>
        </div>
    </div>
    @if ($requestObj->status->value === 'provide_feedback')
    <div class="row" id="target">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="display: inline-block;">
                    <h3>{{ __('admin-content.add-feedback') }}</h3>
                </div>
                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST" action="{{ route('admin.request.provide.feedback') }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="documents">{{ __('admin-content.documents') }}</label>
                                            <input type="file" name="documents[]" id="documents" multiple
                                                class="file-upload-default" accept="*" required>
                                            <div class="input-group col-xs-12">
                                                <input type="text" class="form-control file-upload-info">
                                                <span class="input-group-append">
                                                    <button class="file-upload-browse btn btn-primary" type="button">{{
                                                        __('admin-content.upload') }}</button>
                                                </span>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-name">{{
                                                __('admin-content.note') }}<span class="text-red">*</span></label>
                                            <textarea type="text" name="note" required class="form-control"></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="beanID" value="{{ $requestObj->id->value }}">
                                </div>
                                <hr class="cm-bold">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">{{
                                                __('admin-content.submit')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- push external js -->
@push('script')
<script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/datatables.js') }}"></script>
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap.min.js') }}"></script>
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('plugins/moment/moment.js') }}"></script>
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('plugins/d3/dist/d3.min.js') }}"></script>
<script src="{{ asset('plugins/c3/c3.min.js') }}"></script>
<script src="{{ asset('js/widgets.js') }}"></script>
<script src="{{ asset('js/charts.js') }}"></script>
<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/form-components.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-validator/validator.min.js') }}"></script>
<script src="{{ asset('plugins/summernote/dist/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
<script src="{{ asset('plugins/toastr-master/toastr.js') }}"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script src="{{ asset('plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
<script>
<script>
    $(document).ready(function () {
        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
    });
</script>
@endpush
@endsection
