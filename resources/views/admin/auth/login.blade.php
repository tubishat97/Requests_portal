<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{ __('Login')}}</title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon" />
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('plugins/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/icon-kit/dist/css/iconkit.min.css') }}">
        <link rel="stylesheet" href="{{ asset('dist/css/theme.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <style>
            .auth-wrapper {
                background: #e4e4e4;
                height: 100vh;
                }
        </style>
    </head>
    <body>
        <div class="auth-wrapper">
            <div class="container-fluid h-100">
                <div class="row flex-row h-100">
                    <div class="col-xl-4 col-lg-4 col-md-4 m-auto">
                        <div class="authentication-form mx-auto">
                            <div class="text-center mb-3">
                                <img class="img-fluid h-50" src="{{ asset('img/logo.jpg') }}" alt="Smile">
                            </div>
                            <form method="POST" action="{{ route('admin.login') }}">
                            @csrf
                                <div class="form-group">
                                    <input id="username" type="text" placeholder="{{ __('username')}}" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                    <i class="ik ik-user"></i>
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="password" type="password" placeholder="{{ __('password')}}" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                    <i class="ik ik-lock"></i>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="row">
                                    <div class="col text-left">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <span class="custom-control-label">&nbsp;{{ __('Remember me')}}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="sign-btn text-center">
                                    <button class="btn btn-custom">{{ __('Login')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
