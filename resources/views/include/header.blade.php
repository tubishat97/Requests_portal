<header class="header-top" style="background: #016193">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="top-menu d-flex align-items-center">
                <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
            </div>
            <div class="top-menu d-flex align-items-center">
                <div class="dropdown">
                    @php
                    $en = 'en';
                    $ar = 'ar';
                    $currentRoute = \Request::route()->getName();
                    @endphp

                    @if ( Config::get('app.locale') == 'ar')
                    <a href="{{ route('change-language', [
                        'lang' => $en, 'route' => $currentRoute] )}}"><img src="{{ asset('img/amrica.png')}}" style="width: 30px;height: 30px;border-radius: 50%;" alt="">
                    </a>
                    @elseif ( Config::get('app.locale') == 'en' )
                    <a href="{{ route('change-language', [
                        'lang' => $ar, 'route' => $currentRoute] )}}"><img src="{{ asset('img/jordan.png')}}" style="width: 30px;height: 30px;border-radius: 50%;" alt="">
                    </a>
                    @endif
                </div>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="avatar" src="{{ asset('img/user.jpg')}}" alt=""></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        {{-- <a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="ik ik-user dropdown-icon"></i> {{ __('Profile')}}</a> --}}
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
