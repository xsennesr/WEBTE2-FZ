
<div class="container-expand">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
        <a href="#" class="navbar-brand"> MAT </a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#toggleMobileMenu"
            aria-controls="toggleMobileMenu"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="toggleMobileMenu">
            <ul class="navbar-nav ms-auto">
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
                    </li><!--
                    <li class="nav-item">
                        <a class="nav-link" href="/lang/home">lang/home</a>
                    </li>-->
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

                    <!--<li class="nav-item">
                        <label class="nav-link" for="inputState">{{ __('Language') }}</label>
                    </li>-->

                    <li>
                        <select id="inputState" class="nav-link changeLang bg-dark">
                            <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English</option>
                            <option value="sk" {{ session()->get('locale') == 'sk' ? 'selected' : '' }}>Slovak</option>
                        </select>
                    </li>

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
                            <label class="nav-link" for="inputState" style="display: inline!important;">{{ __('Language') }}</label>
                            <select id="inputState" class="nav-link changeLang bg-dark" style="display: inline!important;">
                                <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English</option>

                                <option value="sk" {{ session()->get('locale') == 'sk' ? 'selected' : '' }}>Slovak</option>
                            </select>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            Log in
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            Register
                        </a>
                    </li>-->
                @endif
            </ul>
        </div>
    </nav>
</div>


<script type="text/javascript">
    let url = "{{ route('changeLang') }}";

    $(".changeLang").change(function(){
        window.location.href = url + "?lang="+ $(this).val();
    });

</script>


<!--
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
          <a class="nav-link" href="/lang/home">lang/home</a>
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
-->
