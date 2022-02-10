@extends('layouts.main')

@section('content')
<!-- push external head elements to head -->
@push('head')
<title>{{ __('admin-content.add-death-requests') }}</title>
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
                    <i class="fas fa-bed bg-blue"></i>
                    <div class="d-inline">
                        <h5>{{ __('admin-content.add-death-requests') }}</h5>
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
                            <a href="{{ route('admin.request.death') }}">{{ __('admin-content.death-requests') }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('admin-content.add-death-requests')
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
                    <form enctype="multipart/form-data" method="POST" action="{{ route('admin.request.death.store') }}">
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
                                            <label for="birthdate">{{ __('admin-content.birthdate') }}<span
                                                class="text-red">*</span></label>
                                            <input type="date" class="form-control datetimepicker-input" id="birthdate"
                                                name="birthdate" data-toggle="datetimepicker" data-target="#to" value="">
                                            <div class="help-block with-errors"></div>
                                            @error('birthdate')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('admin-content.loan-types') }}<span
                                                    class="text-red">*</span></label>
                                            <select class="form-control" name="type" id="loanTypes">
                                                @foreach ($loanTypes as $key => $type)
                                                <option value="{{ $key }}">{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-name">{{
                                                __('admin-content.description') }}<span
                                                    class="text-red">*</span></label>
                                            <textarea type="text" name="description" required
                                                class="form-control"></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="cm-bold">
                                <h4 class="sub-title"><b>{{ __('admin-content.required-reports') }}</b></h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="official_letter_to_report_the_claim_by_the_bank">{{ __('admin-content.official_letter_to_report_the_claim_by_the_bank') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="file" name="official_letter_to_report_the_claim_by_the_bank" id="image" class="file-upload-default"
                                                accept="image/*">
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
                                            <label for="image">{{ __('admin-content.a_certified_copy_of_the_family_book_and_civil_status_id') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="file" name="a_certified_copy_of_the_family_book_and_civil_status_id" id="image" class="file-upload-default"
                                                accept="image/*">
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
                                            <label for="an_official_death_certificate_or_a_certified_copy_of_it">{{ __('admin-content.an_official_death_certificate_or_a_certified_copy_of_it') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="file" name="an_official_death_certificate_or_a_certified_copy_of_it" id="an_official_death_certificate_or_a_certified_copy_of_it" class="file-upload-default"
                                                accept="image/*">
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
                                            <label for="image">{{ __('admin-content.a_copy_of_a_notification_of_the_event_of_death_in_which_the_main_cause_of_death_and_the_circumstances_surrounding_it_are_mentioned') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="file" name="copy_of_a_notification" id="image" class="file-upload-default"
                                                accept="image/*">
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
                                            <label for="original_medical_report">{{ __('admin-content.an_original_medical_report_showing_the_cause_of_death') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="file" name="original_medical_report" id="image" class="file-upload-default"
                                                accept="image/*">
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
                                            <label for="police_report">{{ __('admin-content.police_report_in_case_of_death_due_to_accident') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="file" name="police_report" id="image" class="file-upload-default"
                                                accept="image/*">
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
                                            <label for="statement_of_account">{{ __('admin-content.a_statement_of_account_for_the_borrower_showing_the_balance_of_the_loan_when_the_claim_occurs') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="file" name="statement_of_account" id="statement_of_account" class="file-upload-default"
                                                accept="image/*">
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
                                            <label for="loan_repayment">{{ __('admin-content.loan_repayment_schedule') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="file" name="loan_repayment" id="loan_repayment" class="file-upload-default"
                                                accept="image/*">
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
                                            <label for="other">{{ __('admin-content.any_other_necessary_documents_required_by_the_company') }}</label>
                                            <input type="file" name="other[]" id="other" multiple
                                                class="file-upload-default" accept="image/*">
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
                                        <button type="submit" class="btn btn-primary">{{ __('admin-content.submit')}}</button>
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
</script>
@endpush
@endsection
