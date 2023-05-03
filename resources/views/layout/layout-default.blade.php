<!DOCTYPE html>
<html lang="en">
@include('layout.includes.head')

<body class="bg-slate-200 flex flex-col min-h-screen">
    @include('layout.includes.navbar')

        @yield('content')

    @include('layout.includes.footer')
</body>

</html>
