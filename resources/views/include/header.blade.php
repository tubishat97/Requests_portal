<header class="header-top" style="background: #016193">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="top-menu d-flex align-items-center">
                <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
            </div>
            <div class="top-menu d-flex align-items-center">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="avatar" src="{{ asset('img/logo.jpg')}}" alt=""></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="ik ik-user dropdown-icon"></i> {{ __('Profile')}}</a>
                        <a class="dropdown-item" href="{{ route('admin.logout') }}">
                            <i class="ik ik-power dropdown-icon"></i>
                            {{ __('Logout')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
