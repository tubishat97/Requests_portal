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
                <div class="nav-lavel">{{ __('Users management')}}</div>
                <div class="nav-item {{ ($route_name == 'admin.customer.index') ? 'active' : '' }}">
                    <a href="{{route('admin.customer.index')}}"><i class="fas fa-users"></i><span>{{ __('Customers')}}</span></a>
                </div>
            </nav>
        </div>
    </div>
</div>
