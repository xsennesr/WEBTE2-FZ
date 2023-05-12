
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
                    @if (Auth::user()->ucitel)
                        <li class="nav-item">
                            <a id="home-t" class="nav-link" href="{{ route('teacher.dashboard') }}">
                                {{ __('login-page.home')  }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a id="stud-t" class="nav-link" href="{{ route('teacher.studentsTable') }}">
                                {{ __('login-page.students')  }}
                            </a>
                        </li>
                    @endif

                    @if (!Auth::user()->ucitel)
                    <li class="nav-item">
                        <a id="home-s" class="nav-link" href="{{ route('student.dashboard') }}">
                            {{ __('login-page.home')  }}
                        </a>
                    </li>
                    @endif


                    <li class="nav-item active">
                        <a id="info" class="nav-link" href="{{ route('index') }}">
                            {{ __('login-page.info')  }}
                        </a>
                    </li>

                    <li>
                        <select id="inputState" class="nav-link changeLang bg-dark">
                            <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>
                                {{ __('login-page.lang-en')  }}
                            </option>
                            <option value="sk" {{ session()->get('locale') == 'sk' ? 'selected' : '' }}>
                                {{ __('login-page.lang-sk')  }}
                            </option>
                        </select>
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                this.closest('form').submit();">
                                {{ __('login-page.log-out')  }}
                            </a>

                        </form>
                    </li>


                @else
                    <li class="nav-item">
                            <label class="nav-link" for="inputState" style="display: inline!important;"> {{ __('login-page.lang-title')  }}</label>
                            <select id="inputState" class="nav-link changeLang bg-dark" style="display: inline!important;">
                                <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>
                                    {{ __('login-page.lang-en')  }}
                                </option>

                                <option value="sk" {{ session()->get('locale') == 'sk' ? 'selected' : '' }}>
                                    {{ __('login-page.lang-sk')  }}
                                </option>
                            </select>
                    </li>
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
