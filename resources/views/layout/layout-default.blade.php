<!DOCTYPE html>
<html lang="en">
@include('layout.includes.head')

<body style="min-height: 100vh">
    @include('layout.includes.navbar')

    <div class="container" style="min-height: 100vh">
        @include('misc.flash-message')
        @yield('content')
    </div>

    @include('layout.includes.footer')
</body>

</html>
