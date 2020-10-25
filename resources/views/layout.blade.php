<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Laravel App</title>
</head>
<body>
<nav class="mt-2">
    <div class="container">
        <p class="text-right">
            @if ('product_index' === Route::currentRouteName())
                <a href="{{route('cart_index')}}" class="btn btn-primary">Cart</a>
            @else
                <a href="{{route('product_index')}}" class="btn btn-secondary">Catalog</a>
            @endif
            @guest
                <a href="{{route('security_show_login')}}" class="btn btn-success">Sign in</a>
            @endguest
            @auth
                <a href="{{route('security_do_logout')}}" class="btn btn-danger">Logout</a>
            @endauth
        </p>
    </div>
</nav>
@yield('content')
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@yield('scripts')
</body>
</html>
