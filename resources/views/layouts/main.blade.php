<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- initiate head with meta tags, css and script -->
    @include('include.head')
    <link rel="stylesheet" href="{{ asset('plugins/toastr-master/build/toastr.css') }}">
</head>

<body id="app">
    <div class="wrapper">
        <!-- initiate header-->
        @include('include.header')
        <div class="page-wrap">
            <!-- initiate sidebar-->
            @include('include.sidebar')

            <div class="main-content">
                <!-- yeild contents here -->
                @yield('content')
            </div>

            <!-- initiate chat section-->
            @include('include.chat')

            <!-- initiate footer section-->
            @include('include.footer')

        </div>
    </div>

    <!-- initiate modal menu section-->
    @include('include.modalmenu')

    <!-- initiate scripts-->
    @include('include.script')
    <script src="{{ asset('plugins/toastr-master/toastr.js') }}"></script>
</body>

</html>
