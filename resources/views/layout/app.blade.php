
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <base href="{{url('/')}}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <!-- including css files from partials folder -->
        @include('partials.header')
        <script>
            (function(){
                window.Laravel ={
                    csrfToken:'{{csrf_token() }}'
                };
            })();
        </script>
    </head>
    <!--  -->
    <body >
        <div id="app">
            <!-- yielding main content -->
            @yield('main-content')
        </div>
        
        <!-- including javascript files from partials folder -->
        @include('partials.footer')
    </body>
</html>
