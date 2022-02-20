
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
                                <th>{{ __('admin-content.full-name')}}</th>
                                <th>{{ __('admin-content.national-id')}}</th>
                                <th>{{ __('admin-content.date_of_occurrence')}}</th>
                                <th>{{ __('admin-content.status')}}</th>
                                <th>{{ __('admin-content.type')}}</th>
                                <th class="nosort" style="text-align: center;">{{ __('admin-content.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $key => $request)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $request->name_value_list->name->value }}</td>
                                <td>{{ $request->name_value_list->national_id->value }}</td>
                                <td>{{ $request->name_value_list->date_of_occurrence->value }}</td>
                                <td>{{ $request->name_value_list->status->value }}</td>
                                <td>{{ $request->name_value_list->type->value }}</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{route('admin.request.show', $request->id)}}" data-toggle="tooltip" data-placement="top" title="{{ __('admin-content.show') }}"><i class="ik ik-eye text-blue"></i></a>
                                        <a href="{{route('admin.request.show.notes', $request->id)}}"><i
                                            class="ik ik-edit-2 text-green"></i></a>
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
