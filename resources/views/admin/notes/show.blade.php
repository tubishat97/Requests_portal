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
                        <li class="breadcrumb-item active" aria-current="page">{{' [' . $requestObj->claim_name_c->value . '] '. __('admin-content.notes') }}
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
                                <img src="{{ asset('img/user.jpg')}}"
                                    alt="{{ $user->name }}">
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
                @if($requestObj->status->value != 'proceed')
                <div class="card-footer chat-footer">
                    <form id="sendMsg">
                        @csrf
                        <div class="input-wrap">
                            <input type="hidden" name="beanID" value="{{ $requestObj->id->value }}">
                            <input type="text" id="contentMsg" name="content" placeholder="{{__('admin-content.type-and-enter')}}" class="form-control" required/>
                        </div>
                        <button type="submit" class="btn btn-icon btn-blue" style="margin-top: 10px;"><i class="fa fa-paper-plane"></i></button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
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
<script>

    $(document).ready(function () {
        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
    });

    $('#sendMsg').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this)
            $.ajax({
                type: 'POST',
                data: formData,
                url: "{{ route('admin.request.show.notes.add') }}",
                dataType: "json",
                processData: false,
                contentType: false,
                cache: false,
            }).then(function (response) {
                if (response.success) {
                        html=`<li class="odd chat-item">
                            <div class="chat-content">
                                <div class="box bg-light-inverse">${response.data}</div>
                                <br>
                            </div>
                            <div class="chat-time">a minute ago</div>
                        </li>`;
                        $("#contentMsg").val('');
                        $(".chat-list").append(html);
                        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                        toastr.success(`${response.message}`);
                } else {
                    toastr.error(response.error);
                }
            }).catch(function (error) {
                Object.keys(error.responseJSON.errors).forEach(key => {
                    toastr.error(error.responseJSON.errors[key])
                });
            });
        });
</script>
@endpush
@endsection
