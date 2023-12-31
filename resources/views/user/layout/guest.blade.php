<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title')</title>

    <meta content="" name="description">
    <meta content="" name="keywords">

    @include('user.common.head')
</head>

<body>

    <div class="wrapper">
        @yield('content')
        @include('user.common.footer')
        @stack('js')
    </div>

</body>

</html>
