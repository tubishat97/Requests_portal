@extends('layouts.main')

@section('content')
<!-- push external head elements to head -->
@push('head')
<title>{{ __('Dashboard | Admin Panel')}}</title>

<link rel="stylesheet" href="{{ asset('plugins/weather-icons/css/weather-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/owl.carousel/dist/assets/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/chartist/dist/chartist.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/jvectormap/jquery-jvectormap.css') }}">
@endpush

<div class="container-fluid">
</div>
<!-- push external js -->
@push('script')
<script src="{{ asset('plugins/owl.carousel/dist/owl.carousel.min.js') }}"></script>
<script src="{{ asset('plugins/chartist/dist/chartist.min.js') }}"></script>
<script src="{{ asset('plugins/flot-charts/jquery.flot.js') }}"></script>
<script src="{{ asset('plugins/flot-charts/curvedLines.js') }}"></script>
<script src="{{ asset('plugins/flot-charts/jquery.flot.tooltip.min.js') }}"></script>
<script src="{{ asset('plugins/amcharts/amcharts.js') }}"></script>
<script src="{{ asset('plugins/amcharts/serial.js') }}"></script>
<script src="{{ asset('plugins/amcharts/themes/light.js') }}"></script>
<script src="{{ asset('plugins/moment/moment.js') }}"></script>
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap.min.js') }}"></script>
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('js/widget-statistic.js') }}"></script>
<script src="{{ asset('js/widget-data.js') }}"></script>
<script src="{{ asset('js/dashboard-charts.js') }}"></script>
<script src="{{ asset('js/widgets.js') }}"></script>
@endpush
@endsection
