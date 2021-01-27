@extends('layouts.main')

@section('content')
<!-- push external head elements to head -->
@push('head')
<title>{{ __('Add airplane')}}</title>
<link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/mohithg-switchery/dist/switchery.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/summernote/dist/summernote-bs4.css') }}">
@endpush

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="fas fa-plane bg-linkedin"></i>
                    <div class="d-inline">
                        <h5>{{ __('Add airplane')}}</h5>
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
                            <a href="{{ route('admin.airplane.index') }}">{{ __('Airplanes')}}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Add airplane')}}</li>
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
            <div class="card ">
                <div class="card-header">
                    <h3>{{ __('Add airplane')}}</h3>
                </div>
                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST" action="{{ route('admin.airplane.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="sub-title"><b>{{ __('admin-content.basic-information')}}</b></h4>    
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ __('name') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="text" id="name" name="name"
                                                class="form-control" required />
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ __('type') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="text" id="type" name="type"
                                                class="form-control" required />
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ __('Max seat') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="number" id="max_seat" name="max_seat"
                                                class="form-control" required />
                                            <div class="help-block with-errors"></div>
                                        </div>
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
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script src="{{ asset('plugins/toastr-master/toastr.js') }}"></script>
<script>
    var map;
    var markers = [];
    var marker;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: 31.9446628,
                lng: 35.8902066
            },
            zoom: 13
        });
        google.maps.event.addListener(map, 'click', function (event) {
            placeMarker(event.latLng);
            //marker = new google.maps.Marker({position: event.latLng, map: map});
            //console.log(event.latLng); // Get latlong info as object.
            $('#lon').val(event.latLng.lng());
            $('#lat').val(event.latLng.lat());
        });
        var input = /** @type {HTMLInputElement} */ (
            document.getElementById('pac-input'));
        var searchBox = new google.maps.places.SearchBox(
            /** @type {HTMLInputElement} */
            (input));
        // Listen for the event fired when the user selects an item from the
        // pick list. Retrieve the matching places for that item.
        google.maps.event.addListener(searchBox, 'places_changed', function () {
            var places = searchBox.getPlaces();
            for (var i = 0, marker; marker = markers[i]; i++) {
                marker.setMap(null);
            }
            // For each place, get the icon, place name, and location.
            markers = [];
            var bounds = new google.maps.LatLngBounds();
            var place = null;
            var viewport = null;
            for (var i = 0; place = places[i]; i++) {
                var image = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };
                // Create a marker for each place.
                marker = new google.maps.Marker({
                    map: map,
                    position: place.geometry.location,
                    draggable: true
                });
                $('#lon').val(place.geometry.location.lng());
                $('#lat').val(place.geometry.location.lat());
                viewport = place.geometry.viewport;
                markers.push(marker);
                bounds.extend(place.geometry.location);
            }
            map.setCenter(bounds.getCenter());
        });
        // Bias the SearchBox results towards places that are within the bounds of the
        // current map's viewport.
        google.maps.event.addListener(map, 'bounds_changed', function () {
            var bounds = map.getBounds();
            searchBox.setBounds(bounds);
        });
    }
    function placeMarker(location) {
        for (var i = 0, marker; marker = markers[i]; i++) {
            marker.setMap(null);
        }
        markers = [];
        marker = new google.maps.Marker({
            position: location,
            map: map,
            draggable: true
        });
        markers.push(marker);
    }
</script>
<script
    src="https://maps.googleapis.com/maps/api/js?key={{config('services.google_map.key')}}&callback=initMap&libraries=places&sensor=false"
    async defer></script>
@endpush
@endsection
