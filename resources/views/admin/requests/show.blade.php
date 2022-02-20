@extends('layouts.main')

@section('content')
<!-- push external head elements to head -->
@push('head')
<title>{{' [' . $requestObj->claim_name_c->value . '] '. __('admin-content.show') }}</title>
<link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/mohithg-switchery/dist/switchery.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/summernote/dist/summernote-bs4.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/toastr-master/build/toastr.css') }}">
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<script>
    .card {
        margin - bottom: 30px;
    }
    .card {
            position: relative;
            display: flex;
            flex - direction: column;
            min - width: 0;
            word - wrap: break-word;
            background - color: #fff;
            background - clip: border - box;
            border: 0 solid transparent;
            border - radius: 0;
        }
    .card.card - subtitle {
            font - weight: 300;
            margin - bottom: 10px;
            color: #8898aa;
        }
    .table - product.table - striped tbody tr: nth - of - type(odd) {
            background - color: #f3f8fa!important
        }
    .table - product td{
            border - top: 0px solid #dee2e6!important;
            color: #728299!important;
    }
</script>
@endpush

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="fas fa-question bg-blue"></i>
                    <div class="d-inline">
                        <h5>{{' [' . $requestObj->claim_name_c->value . '] '. __('admin-content.show') }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{' [' . $requestObj->claim_name_c->value . '] '. __('admin-content.show') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row" id="target">
        <!-- start message area-->
        @include('include.message')
        <!-- end message area-->
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-product">
                    <tbody>
                        <tr>
                            <td>{{ __('admin-content.claim_name') }}</td>
                            <td>{{ $requestObj->claim_name_c->value }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('admin-content.type') }}</td>
                            <td>{{ $requestObj->type->value }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('admin-content.status') }}</td>
                            <td>{{ $requestObj->status->value }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('admin-content.reason') }}</td>
                            <td>{{ $requestObj->reason->value }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('admin-content.full-name') }}</td>
                            <td>{{ $requestObj->name->value }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('admin-content.national-id') }}</td>
                            <td>{{ $requestObj->national_id->value }}</td>
                        </tr>
                    </tbody>
                </table>

                    <table class="table table-striped table-product">
                        <tbody>
                            @foreach ($collection as $item)

                            @endforeach
                    </tbody>
                </table>
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
<script src="{{ asset('plugins/toastr-master/toastr.js') }}"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script src="{{ asset('plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.select2').select2();
    });

    $('.repeater').repeater({
        initEmpty: true,
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            if (confirm('Are you sure you want to delete this element?')) {
                $(this).slideUp(deleteElement);
            }
        },
        isFirstItemUndeletable: true
    });
</script>
@endpush
@endsection
