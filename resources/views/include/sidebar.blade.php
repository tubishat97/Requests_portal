<div class="app-sidebar">
    <div class="sidebar-header">
        <a class="header-brand" href="#">
            <div class="logo-img text-center">
                <h4><a href="{{ route('admin.home') }}">Admin Panel</a></h4>
            </div>
        </a>
        <button type="button" class="nav-toggle"><i data-toggle="expanded" class="ik ik-toggle-right toggle-icon"></i></button>
        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
    </div>

    @php
    $route_name = Route::currentRouteName();
    @endphp

    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main" style="">
                <div class="nav-item">
                    <a href="{{ route('admin.home') }}"><i class="fas fa-desktop"></i><span>{{ __('Dashboard')}}</span></a>
                </div>
                <div class="nav-lavel">{{ __('Requests')}}</div>
                <div class="nav-item {{ ($route_name == 'admin.customer.index') ? 'active' : '' }}">
                    <a href="{{route('admin.customer.index')}}"><i class="fas fa-bed"></i><span>{{ __('Death')}}</span></a>
                    <a href="{{route('admin.customer.index')}}"><i class="fas fa-blind"></i><span>{{ __('Inabilities')}}</span></a>
                </div>
                {{-- <div class="nav-lavel">{{ __('Flight attributes')}}</div>
                <div class="nav-item {{ ($route_name == 'admin.flight.index') ? 'active' : '' }}">
                    <a href="{{route('admin.flight.index')}}"><i class="fas fa-plane-departure"></i></i><span>{{ __('Flights')}}</span></a>
                </div>
                <div class="nav-item {{ ($route_name == 'admin.airplane.index') ? 'active' : '' }}">
                    <a href="{{route('admin.airplane.index')}}"><i class="fas fa-plane"></i><span>{{ __('Airplanes')}}</span></a>
                </div>
                <div class="nav-item {{ ($route_name == 'admin.airline.index') ? 'active' : '' }}">
                    <a href="{{route('admin.airline.index')}}"><i class="fas fa-broadcast-tower"></i><span>{{ __('Airlines')}}</span></a>
                </div>
                <div class="nav-item {{ ($route_name == 'admin.airport.index') ? 'active' : '' }}">
                    <a href="{{route('admin.airport.index')}}"><i class="fas fa-plane-arrival"></i><span>{{ __('Airports')}}</span></a>
                </div> --}}
            </nav>
        </div>
    </div>
</div>
