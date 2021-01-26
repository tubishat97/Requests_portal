@extends('layouts.main')
<!-- push external head elements to head -->
@push('head')
<title>{{ __('admin-content.customer-profile') }}</title>
<link rel="stylesheet"
    href="{{ asset('plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/jquery-minicolors/jquery.minicolors.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datedropper/datedropper.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/mohithg-switchery/dist/switchery.min.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-user bg-linkedin"></i>
                    <div class="d-inline">
                        <h5>{{ __('Customer-profile') }}</h5>
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
                            <a href="{{ route('admin.customer.index') }}">{{ __('admin-content.customers') }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('admin-content.customer-profile')
                            }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- start message area-->
        @include('include.message')
        <!-- end message area-->
        <div class="col-lg-4 col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset($customer->image ? 'storage/' . $customer->image : 'img/user.jpg') }}"
                            class="rounded-circle" style="height: 150px;width: 150px;object-fit: cover;" />
                        <h4 class="card-title mt-10">{{ $customer->profile->fullname }}</h4>
                        <p class="card-subtitle">{{ __('admin-content.customer') }}</p>
                        <div class="xp-social-profile-media pt-3">
                            <span class="badge badge-{{ $customer->profile->is_active ? 'success' : 'danger' }}">
                                {{ $customer->profile->is_active ? __('admin-content.activated') : __('admin-content.blocked')}}
                            </span>
                        </div>
                    </div>
                </div>
                <hr class="mb-0">
                <div class="card-body">
                    <small class="text-muted d-block pt-10">{{ __('admin-content.joined-at') }}</small>
                    <h6 data-toggle="tooltip" data-placement="left" title="{{$customer->created_at}}">{{
                        $customer->created_at->diffForhumans() }}</h6>
                    <small class="text-muted d-block pt-10">{{ __('admin-content.phone-number') }}</small>
                    <h6>+{{ $customer->username }}</h6>
                    <small class="text-muted d-block pt-10">{{ __('admin-content.email') }}</small>
                    <h6>{{ $customer->profile->email ? $customer->profile->email : '---' }}</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-7">
            <div class="card">
                <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                    <li class="nav-item">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-setting-tab" data-toggle="pill" href="#setting" role="tab"
                            aria-controls="pills-setting" aria-selected="false">{{ __('admin-content.setting') }}</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="setting" role="tabpanel" aria-labelledby="pills-setting-tab">
                        <div class="card-body">
                            <form id="addform" class="forms-sample" method="POST"
                                action="{{ route('admin.customer.update', $customer) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="user_name">{{ __('admin-content.username') }}</label>
                                    <input type="text" value="{{ $customer->username }}" class="form-control"
                                        disabled>
                                </div>

                                <div class="form-group">
                                    <label for="fullname">{{ __('Full name') }}</label>
                                    <input type="text" value="{{ $customer->profile->fullname }}" class="form-control"
                                        name="fullname">
                                </div>

                                <div class="form-group">
                                    <label for="example-phone">{{ __('admin-content.phone-number') }}</label>
                                    <input type="text" value="{{ $customer->profile->mobile }}" class="form-control"
                                        name="mobile">
                                </div>

                                <div class="form-group">
                                    <label for="email">{{ __('admin-content.email')}}</label>
                                    <input id="email" name="email" placeholder="Email"
                                        @if($customer->profile->email) value="{{$customer->profile->email}} @endif"
                                    class="form-control @error('email') is-invalid @enderror">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('admin-content.is-active')}}</label>
                                    <br>
                                    <input  name="is_active" value="1" type="checkbox" @if($customer->profile->is_active) checked @endif
                                    class="js-small" />
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="password">{{ __('admin-content.password') }}</label> <small style="float: right"><span class="text-red">If you dont want to change it let it empty</span></small>
                                    <input type="password" class="form-control" name="password">
                                </div>
                                <div class="form-group">
                                    <label for="Confirm-password">{{ __('admin-content.confirm-password') }}</label>
                                    <input type="password" value="" class="form-control" name="password_confirmation">
                                </div>
                                <button class="btn btn-success" type="submit">{{ __('admin-content.update-profile')
                                    }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- push external js -->
@push('script')
<script src="{{ asset('js/form-components.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-validator/validator.min.js') }}"></script>
<script src="{{ asset('plugins/moment/moment.js') }}"></script>
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('plugins/datedropper/datedropper.min.js') }}"></script>
<script src="{{ asset('plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
<script>
    var elemsmall = document.querySelector('.js-small');
    var switchery = new Switchery(elemsmall, {
        color: '#4099ff',
        jackColor: '#fff',
        size: 'small'
    });

    var elemsmall = document.querySelector('.js-small2');
    var switchery = new Switchery(elemsmall, {
        color: '#4099ff',
        jackColor: '#fff',
        size: 'small'
    });

</script>
@endpush
@endsection
