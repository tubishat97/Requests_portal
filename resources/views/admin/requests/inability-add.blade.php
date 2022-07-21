@extends('layouts.main')

@section('content')
<!-- push external head elements to head -->
@push('head')
<title>{{ __('admin-content.add-inability-requests') }}</title>
<link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/mohithg-switchery/dist/switchery.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/summernote/dist/summernote-bs4.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/toastr-master/build/toastr.css') }}">
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endpush

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="fas fa-blind bg-blue"></i>
                    <div class="d-inline">
                        <h5>{{ __('admin-content.add-inability-requests') }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{
                            __('admin-content.add-inability-requests')
                            }}
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
            <div class="card p-3">
                <div class="card-header" style="display: inline-block;">
                    <h3></h3>
                </div>
                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST"
                        action="{{ route('admin.request.inability.store') }}">
                        @csrf
                        <div class="row">
                            <!-- LEFT COLUMN -->
                            <div class="col-sm-12">
                                <h4 class="sub-title"><b>{{ __('admin-content.basic-information') }}</b></h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('admin-content.name') }}<span class="text-red">*</span></label>
                                            <input type="text" name="fullname" class="form-control" required value="" />
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('admin-content.national-id') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="number" name="national" class="form-control" required
                                                value="" />
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date_of_occurrence">{{ __('admin-content.date_of_occurrence')
                                                }}<span class="text-red">*</span></label>
                                            <input type="date" class="form-control datetimepicker-input"
                                                id="date_of_occurrence" name="date_of_occurrence"
                                                data-toggle="datetimepicker" data-target="#to" value="">
                                            <div class="help-block with-errors"></div>
                                            @error('date_of_occurrence')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="birth_date">{{ __('admin-content.birth_date')
                                                }}<span class="text-red">*</span></label>
                                            <input type="date" class="form-control datetimepicker-input"
                                                id="birth_date" name="birth_date"
                                                data-toggle="datetimepicker" data-target="#to" value="">
                                            <div class="help-block with-errors"></div>
                                            @error('birth_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-name">{{
                                                __('admin-content.reason') }}<span class="text-red">*</span></label>
                                            <textarea type="text" name="reason" required
                                                class="form-control"></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-name">{{
                                                __('admin-content.note') }}</label>
                                            <textarea type="text" name="note"
                                                class="form-control"></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="repeater">
                                            <div data-repeater-list="loans">
                                                <div data-repeater-item class="row mb-2">
                                                    <div class="form-group col-md-6">
                                                        <label>{{ __('admin-content.loan-types') }}</label>
                                                        <select class="form-control" name="type" id="loanTypes"
                                                            required>
                                                            <option value="" disabled>{{ __('admin-content.select-type')
                                                                }}</option>
                                                            @foreach ($loanTypes as $key => $type)
                                                            <option value="{{ $key }}">{{ $type }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label>{{ __('admin-content.amount') }}</label>
                                                        <input type="number" name="amount"
                                                            placeholder="{{ __('admin-content.amount') }}"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label>{{ __('admin-content.granting_date') }}</label>
                                                        <input type="date" class="form-control datetimepicker-input"
                                                            id="granting_date" name="granting_date"
                                                            data-toggle="datetimepicker" data-target="#to" value="">
                                                    </div>

                                                    <button data-repeater-delete type="button"
                                                        class="btn btn-danger btn-icon ml-2"><i
                                                            class="ik ik-trash-2"></i></button>
                                                </div>
                                            </div>
                                            <button data-repeater-create type="button"
                                                class="btn btn-success btn-icon ml-2 mb-2"><i
                                                    class="ik ik-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <hr class="cm-bold">
                                <h4 class="sub-title"><b>{{ __('admin-content.required-reports') }}</b></h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label
                                                for="an_official_letter_to_report_the_claim_by_the_bank_indicating_the_profession_of_the_borrower">{{
                                                __('admin-content.an_official_letter_to_report_the_claim_by_the_bank_indicating_the_profession_of_the_borrower')
                                                }}<span class="text-red"></span></label>
                                            <input type="file"
                                                name="an_official_letter_to_report_the_claim_by_the_bank_indicating_the_profession_of_the_borrower"
                                                id="image" class="file-upload-default" accept="*">
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image">{{
                                                __('admin-content.a_certified_copy_of_the_family_book_passport_or_civil_status_id')
                                                }}<span class="text-red"></span></label>
                                            <input type="file"
                                                name="a_certified_copy_of_the_family_book_passport_or_civil_status_id"
                                                id="a_certified_copy_of_the_family_book_passport_or_civil_status_id"
                                                class="file-upload-default" accept="*">
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
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="an_original_detailed_medical_report">{{
                                                __('admin-content.an_original_detailed_medical_report') }}<span
                                                    class="text-red"></span></label>
                                            <input type="file" name="an_original_detailed_medical_report"
                                                id="an_original_detailed_medical_report" class="file-upload-default"
                                                accept="*">
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image">{{ __('admin-content.decision_of_the_social_security')
                                                }}<span class="text-red"></span></label>
                                            <input type="file" name="decision_of_the_social_security"
                                                id="decision_of_the_social_security" class="file-upload-default"
                                                accept="*">
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
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="all_necessary_reports_of_disability">{{
                                                __('admin-content.all_necessary_reports_of_disability') }}<span
                                                    class="text-red"></span></label>
                                            <input type="file" name="all_necessary_reports_of_disability" id="image"
                                                class="file-upload-default" accept="*">
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="statement_of_account">{{
                                                __('admin-content.statement_of_account') }}<span
                                                    class="text-red"></span></label>
                                            <input type="file" name="statement_of_account" id="statement_of_account"
                                                class="file-upload-default" accept="*">
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
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="loan_repayment">{{ __('admin-content.loan_repayment') }}<span
                                                    class="text-red"></span></label>
                                            <input type="file" name="loan_repayment" id="loan_repayment"
                                                class="file-upload-default" accept="*">
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="other">{{ __('admin-content.other') }}</label>
                                            <input type="file" name="other[]" id="other" multiple
                                                class="file-upload-default" accept="*">
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
                                </div>
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
<script src="{{ asset('plugins/toastr-master/toastr.js') }}"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script src="{{ asset('plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $('.select2').select2();
    });

    $('.repeater').repeater({
        initEmpty: false,
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
