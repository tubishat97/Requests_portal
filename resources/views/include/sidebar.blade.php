<div class="app-sidebar">
    <div class="sidebar-header">
        <a class="header-brand" href="#">
            <div class="logo-img text-center">
                <h4><a href="{{ route('admin.home') }}">{{ __('admin-content.admin-panel')}}</a></h4>
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
                    <a href="{{ route('admin.home') }}"><i class="fas fa-desktop"></i><span>{{ __('admin-content.dashboard')}}</span></a>
                </div>
                <div class="nav-lavel">{{ __('admin-content.requests')}}</div>
                <div class="nav-item {{ ($route_name == 'admin.request.*') ? 'active' : '' }}">
                    <a href="{{route('admin.request', 'open')}}"><i class="fas fa-list"></i><span>{{ __('admin-content.open-requests')}}</span></a>
                    <a href="{{route('admin.request', 'provide_feedback')}}"><i class="fas fa-comment"></i><span>{{ __('admin-content.provide_feedback-requests')}}</span></a>
                    <a href="{{route('admin.request', 'proceed')}}"><i class="fas fa-question"></i><span>{{ __('admin-content.proceed-requests')}}</span></a>
                </div>
                <div class="nav-lavel">{{ __('admin-content.add-requests')}}</div>
                <div class="nav-item {{ ($route_name == 'admin.request.*') ? 'active' : '' }}">
                    <a href="{{route('admin.request.death.add')}}"><i class="fas fa-bed"></i><span>{{ __('admin-content.add-death-requests')}}</span></a>
                    <a href="{{route('admin.request.inability.add')}}"><i class="fas fa-blind"></i><span>{{ __('admin-content.add-inability-requests')}}</span></a>
                </div>
            </nav>
        </div>
    </div>
</div>
