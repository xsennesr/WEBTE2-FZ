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

    <script>
        const alertEl = document.querySelector('.alert');
        if (alertEl) {
            setTimeout(function() {
                alertEl.classList.add('fade');
                setTimeout(function() {
                    alertEl.remove();
                }, 1000);
            }, 3500);
        }
    </script>
</body>

</html>
