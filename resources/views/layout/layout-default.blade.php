<!DOCTYPE html>
<html lang="en">
@include('layout.includes.head')

<body class="vh-100">
    @include('layout.includes.navbar')

    <div class="container vh-100">
        @include('misc.flash-message')
        @yield('content')
    </div>

    @include('layout.includes.footer')
</body>

</html>
