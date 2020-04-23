<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="author" content="Thodoris Itsios">
        <link href="{{ asset('/employee-vendor/css/style.css') }}" rel="stylesheet"/>
    </head>
    <body class="bg-purple">
        <div class="login-page">
            <a href="{{ route('business.login') }}">
                <img class="login-page--logo" src="{{ url('/img/logo/logo-horizontal.png') }}" alt="logo"/>
            </a>
            <div class="login-page--title">{{ __('business/login.business') }}</div>
            <div class="login-page--form-container">
                <form action="{{ route('business.login_action') }}" class="login-page--form-container--login-form" method="post" enctype="multipart/form-data">
                    @if(Session::has('other_errors'))
                        <div class="login-page--form-container--login-form--alert">
                            @foreach (Session::get('other_errors') as $message)
                                <div class="login-page--form-container--login-form--alert--message">· {{$message}}</div>
                            @endforeach
                        </div>
                    @endif

                    <div class="login-page--form-container--login-form--label">{{ __('business/login.form_label__username') }}</div>
                    @if ($errors->any())
                        <div class="login-page--form-container--login-form--alert">
                            @foreach ($errors->get('username') as $message)
                                <div class="login-page--form-container--login-form--alert--message">· {{$message}}</div>
                            @endforeach
                        </div>
                    @endif
                    <input name="username" type="text" placeholder="{{ __('business/login.form_label__username') }}"/>

                    <div class="login-page--form-container--login-form--label">{{ __('business/login.form_label__password') }}</div>
                    @if ($errors->any())
                        <div class="login-page--form-container--login-form--alert">
                            @foreach ($errors->get('password') as $message)
                                <div class="login-page--form-container--login-form--alert--message">· {{$message}}</div>
                            @endforeach
                        </div>
                    @endif
                    <input name="password" type="password" placeholder="{{ __('business/login.form_label__password') }}"/>
                    
                    <button type="submit" name="submit_login">{{ __('business/login.login_button') }}</button>
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
        <div class="color-white">@include('employee.layouts.footer')</div>
    </body>
</html>