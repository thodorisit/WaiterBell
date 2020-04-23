<html>
    <head>
        <title>@yield('meta_title')</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="author" content="Thodoris Itsios">
        <link href="{{ asset('/customer-vendor/css/style.css') }}" rel="stylesheet">
        <script>
            var waiterbell_js_env = {
                app_url : "{{ URL::to('/') }}/customer/",
                csrf_token : "{{ csrf_token() }}",
                web_push_token_dom : "__web_push_device_id",
                label_id : "{{ app('request')->input('label_id') }}"
            };
        </script>
    </head>
    <body>
        <div class="containter">
            <div class="content">
                @yield('content')
            </div>
            @include('customer.layouts.footer')
        </div>
    </body>
</html>