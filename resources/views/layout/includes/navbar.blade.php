
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  {{-- <div class="collapse navbar-collapse" id="navbarNavDropdown"> --}}
  <div class=" float-right">
    <ul class="navbar-nav">
      @if (Auth::user())
        <li class="nav-item active">
          <a class="nav-link" href="{{ route('index') }}">Home <span class="sr-only">(current)</span></a>
        </li>
        @if (Auth::user()->ucitel)
          <li class="nav-item">
            <a class="nav-link" href="{{ route('teacher.dashboard') }}">Teacher</a>
          </li>
        @endif
        <li class="nav-item">
          <a class="nav-link" href="{{ route('student.dashboard') }}">Student</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/lang/home'">lang/home</a>
        </li>
        {{-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Dropdown link
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li> --}}

        <li class="nav-item">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                {{ __('Log Out') }}
            </a>
          </form>
        </li>


      @else
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">
            Log in
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('register') }}">
            Register
          </a>
        </li>
      @endif

    </ul>
  </div>
  {{-- </div> --}}
</nav>
