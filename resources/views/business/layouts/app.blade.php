<html lang="en">
    <head>
        <title>Admin - @yield('meta_title')</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="manifest" href="{{ asset('/vendor/web-push/manifest.json') }}">

        <!-- Custom fonts for this template-->
        <link href="{{ asset('/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

        <!-- Custom styles for this template-->
        <link href="{{ asset('/vendor/sb-theme/css/sb-admin-2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/vendor/sb-theme/css/style.css') }}" rel="stylesheet">

        <script src="{{ asset('/vendor/cookies/cookies-helper.js') }}"></script>
        <script src="{{ asset('/vendor/toasts/toasts-helper.js') }}"></script>
        <script>
            var waiterbell_js_env = {
                app_url : "{{ URL::to('/') }}/business/",
                csrf_token : "{{ csrf_token() }}",
                web_push_token_dom : "__web_push_device_id",
                cookie__last_page_action_timestamp : "cookie_business__last_page_action_timestamp",
                firebase_script_type_of_user : "business"
            };
            window.addEventListener("load", function() {
                //Refresh load time + 1 day
                cookiesHelper.create(
                    window.waiterbell_js_env.cookie__last_page_action_timestamp,
                    "1"
                );
            });
        </script>

    </head>
    <body>
       
        @include('business.layouts.toasts')
        
        <div id="wrapper">

            @section('sidebar')
                @include('business.layouts.sidebar')
            @show

            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    @include('business.layouts.topbar')
                    <div class="container-fluid">
                        <h1 class="h3 mb-3 text-gray-800">@yield('page_title')</h1>
                        <div class="container-cstm">
                            @yield('content')
                        </div>
                    </div>
                </div>
                @include('business.layouts.footer')
            </div>

        </div>

        @section('footer_additional')
        @show

        <!-- Bootstrap core JavaScript-->
        <script src="{{ asset('/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- Core plugin JavaScript-->
        <script src="{{ asset('/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
        <!-- Custom scripts for all pages-->
        <script src="{{ asset('/vendor/sb-theme/js/sb-admin-2.js') }}"></script>

        <!-- START: WEB-PUSH !-->
        <script src="https://www.gstatic.com/firebasejs/7.8.0/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/7.8.0/firebase-analytics.js"></script>
        <script src="https://www.gstatic.com/firebasejs/7.8.0/firebase-messaging.js"></script>
        <script src="{{ asset('/vendor/web-push/firebase-script.js') }}"></script>
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/firebase-messaging-sw.js').then(function(registration) {
                        //messaging.useServiceWorker(registration);
                        // Registration was successful
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    }, function(err) {
                        // registration failed :(
                        console.log('ServiceWorker registration failed: ', err);
                    });
                });
            }
        </script>
        <!-- END: WEB-PUSH !-->

    </body>
</html>