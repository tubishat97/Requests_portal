
@extends('layouts.main')
<!-- push external head elements to head -->


@section('content')

@push('head')
<title>{{ __('admin-content.inability-requests') }}</title>
@endpush

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="fas fa-blind bg-linkedin"></i>
                    <div class="d-inline">
                        <h5>{{ __('admin-content.inability-requests') }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.home')}}"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('admin-content.inability-requests') }}</li>
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
            <div class="card">
                <div class="card-header" style="display: inline-block;">
                    <h3>{{ __('admin-content.inability-requests') }}</h3>
                    <div class="right" style="float: right;">
                        <a href="{{ route('admin.request.inability.add') }}" class="btn btn-primary js-dynamic-enable">{{ __('admin-content.add') }}</a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="data_table" class="table">
                        <thead>
                            <tr>
                                <th>{{ __('#')}}</th>
                                <th>{{ __('Full name')}}</th>
                                <th>{{ __('Phone Number')}}</th>
                                <th>{{ __('Email')}}</th>
                                <th>{{ __('Customer status')}}</th>
                                <th class="nosort" style="text-align: center;">{{ __('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <img src="{{ asset(isset($item->profile->image) ? 'storage/' . $item->profile->image : 'img/user.jpg') }}"
                                        class="table-user-thumb" alt="" style="float: left;width: 45px;height: 45px;">
                                    <div style="padding-left:10px;float: left;">
                                        @if(isset($item->profile->fullname)) {{$item->profile->fullname}} @else  {{ 'This customer need to update his profile'}} @endif
                                        <br>
                                        <small>Registration Date: {{ $item->created_at }}</small>
                                    </div>
                                </td>
                                <td>{{ $item->username }}</td>
                                <td>{{ isset($item->profile->email) ? $item->profile->email : '---'  }}</td>
                                <td>
                                    @if ($item->profile->is_active)
                                    <span class="badge badge-success">{{ __('Activated')}}</span>
                                    @else
                                    <span class="badge badge-danger">{{ __('Blocked')}}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{route('admin.customer.show', $item->id)}}"><i
                                                class="ik ik-eye text-blue"></i></a>
                                        <a href="{{route('admin.customer.show', $item->id)}}"><i
                                                class="ik ik-edit-2 text-green"></i></a>
                                        <a href=""
                                            onclick="setRoute('{{ $item->id }}', '{{ route('admin.customer.destroy', $item) }}')"
                                            data-toggle="modal" data-target="#exampleModalCenter"> <i
                                                class="ik ik-trash-2 f-16 text-red"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterLabel">{{ __('admin-content.delete-customer')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            {{ __('Are you sure you need to delete this')}} {{ __('customer')}}?
                        </div>
                        <div class="modal-footer">
                            <form id="frm_confirm_delete" action="#" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" value="" name="id" id="item_id">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ __('admin-content.close')}}</button>
                                <button type="submit" class="btn btn-primary" href="">{{ __('Delete')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
