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
            <a href="{{ route('employee.login') }}">
                <img class="login-page--logo" src="{{ url('/img/logo/logo-horizontal.png') }}" alt="logo"/>
            </a>
            <div class="login-page--title">{{ __('employee/login.employee') }}</div>
            <div class="login-page--form-container">
                <form action="{{ route('employee.login_action') }}" class="login-page--form-container--login-form" method="post" enctype="multipart/form-data">
                    @if(Session::has('other_errors'))
                        <div class="login-page--form-container--login-form--alert">
                            <ul>
                                @foreach (Session::get('other_errors') as $message)
                                    <li>{{$message}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="login-page--form-container--login-form--label">{{ __('employee/login.form_label__business_id') }}</div>
                    @if ($errors->any())
                        <div class="login-page--form-container--login-form--alert">
                            @foreach ($errors->get('business_id') as $message)
                                <div class="login-page--form-container--login-form--alert--message">· {{$message}}</div>
                            @endforeach
                        </div>
                    @endif
                    <input name="business_id" type="text" placeholder="{{ __('employee/login.form_label__business_id') }}"/>

                    <div class="login-page--form-container--login-form--label">{{ __('employee/login.form_label__employee_id') }}</div>
                    @if ($errors->any())
                        <div class="login-page--form-container--login-form--alert">
                            @foreach ($errors->get('employee_id') as $message)
                                <div class="login-page--form-container--login-form--alert--message">· {{$message}}</div>
                            @endforeach
                        </div>
                    @endif
                    <input name="employee_id" type="text" placeholder="{{ __('employee/login.form_label__employee_id') }}"/>

                    <div class="login-page--form-container--login-form--label">{{ __('employee/login.form_label__password') }}</div>
                    @if ($errors->any())
                        <div class="login-page--form-container--login-form--alert">
                            @foreach ($errors->get('password') as $message)
                                <div class="login-page--form-container--login-form--alert--message">· {{$message}}</div>
                            @endforeach
                        </div>
                    @endif
                    <input name="password" type="password" placeholder="{{ __('employee/login.form_label__password') }}"/>
                    
                    <button type="submit" name="submit_login">{{ __('employee/login.login_button') }}</button>
                    <p class="message"></p>
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
        <div class="color-white">@include('employee.layouts.footer')</div>
    </body>
</html>