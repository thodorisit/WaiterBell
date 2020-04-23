<html lang="en">
    <head>
        <title></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
       
        <link rel="manifest" href="{{ asset('/vendor/web-push/manifest.json') }}"/>

        <link href="{{ asset('/employee-vendor/css/style.css') }}" rel="stylesheet"/>

        <script src="{{ asset('/vendor/cookies/cookies-helper.js') }}"></script>

        <script>
            var waiterbell_js_env = {
                app_url : "{{ URL::to('/') }}/employee/",
                csrf_token : "{{ csrf_token() }}",
                web_push_token_dom : "__web_push_device_id",
                cookie__last_page_action_timestamp : "cookie_employee__last_page_action_timestamp",
                firebase_script_type_of_user : "employee"
            };
            window.addEventListener("load", function() {
                cookiesHelper.create(
                    window.waiterbell_js_env.cookie__last_page_action_timestamp,
                    "1"
                );
            });
        </script>
    </head>
    <body>
    
        
        @include('employee.layouts.menu')
        <div class="app-container">
            @include('employee.layouts.topbar')
            <div class="app-container--content">
                @yield('content')
                @include('employee.layouts.footer')
            </div>
        </div>
        @include('employee.layouts.filters')

        @section('footer_additional')
        @show

        <!-- START: WEB-PUSH !-->
        <script src="https://www.gstatic.com/firebasejs/7.8.0/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/7.8.0/firebase-analytics.js"></script>
        <script src="https://www.gstatic.com/firebasejs/7.8.0/firebase-messaging.js"></script>
        <script src="{{ asset('/vendor/web-push/firebase-script.js') }}"></script>
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/firebase-messaging-sw.js').then(function(registration) {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    }, function(err) {
                        console.log('ServiceWorker registration failed: ', err);
                    });
                });
            } else {
                //alert("Browser doesn't support push notifications!");
            }
        </script>
        <!-- END: WEB-PUSH !-->

    </body>
</html>