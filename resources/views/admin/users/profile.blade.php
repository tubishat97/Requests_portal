@extends('layouts.main')
<!-- push external head elements to head -->
@push('head')
<title>{{ __('Admin profile')}}</title>
@endpush

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-user bg-linkedin"></i>
                    <div class="d-inline">
                        <h5>{{ __('Admin profile')}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.home')}}"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Admin profile')}}</li>
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
                        <h4 class="card-title mt-10">{{$user->profile->first_name .' '. $user->profile->last_name }}</h4>
                        <p class="card-subtitle">{{$user->username}}</p>
                    </div>
                </div>
                <hr class="mb-0">
                <div class="card-body">
                    <small class="text-muted d-block pt-10">{{ __('Created at')}}</small>
                    <h6>{{$user->created_at}}</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-7">
            <div class="card">
                <div class="card-body">
                <form class="form-horizontal" method="post" action="{{ route('admin.profile.update') }}">
                    @csrf
                        <div class="form-group">
                            <label for=name">{{ __('First name')}}</label>
                            <input type="text" placeholder="Enter first name" class="form-control" name="first_name" value="{{$user->profile->first_name}}">
                        </div>
                        <div class="form-group">
                            <label for=name">{{ __('Last name')}}</label>
                            <input type="text" placeholder="Enter last name" class="form-control" name="last_name" value="{{$user->profile->last_name}}">
                        </div>
                        <div class="form-group">
                            <label for="username">{{ __('Username')}}</label>
                            <input type="text" placeholder="Enter username" class="form-control" value="{{$user->username}}" name="username" disabled>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="current-password">{{ __('Current password')}}</label><small style="float: right"><span class="text-red">If you dont want to change it let it empty</span></small>
                            <input type="password" class="form-control" name="current_password">
                        </div>
                        <div class="form-group">
                            <label for="new-password">{{ __('New password')}}</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label for="confirm-password">{{ __('Confirm password')}}</label>
                            <input type="password" class="form-control" name="password_confirmation" >
                        </div>
                        <button class="btn btn-success" type="submit">{{ __('Update profile')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
