{{-- Template Laravel with Bootstrap 5 --}}
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon" href="favicon.ico">

        <!-- SEO Meta Tags -->
        <meta name="description" content="@yield('description', 'My E-commerce website')">
        <meta name="keywords" content="@yield('keywords', 'e-commerce, online store, shopping')">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        @stack('styles')
        @stack('css')
        @stack('js')
    </head>
    <body>
        @include('template.navbar')
        @yield('content')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        @include('template.footer')
        @stack('scripts')
    </body>
</html>
