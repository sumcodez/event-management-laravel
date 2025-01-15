<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <!-- Include CSS files here -->
    <link rel="stylesheet" href="{{ asset('users_styles/style.css') }}">
    <link rel="stylesheet" href="{{ asset('users_styles/card.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    @include('users.layouts.header')
    
    <div class="container">
        {{-- @include('users.layouts.top-nav') --}}
        
        <div class="row">
            {{-- @include('users.layouts.side-nav') --}}
            <div class="col-md-9">
                @yield('content')
            </div>
        </div>
    </div>
    
    @include('users.layouts.footer')
    
    <!-- Include your JS files here -->
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
