@extends('layout.layout-default')
@section('content')
    <div class="container-fluid d-flex justify-content-center vh-100 align-items-center my-5">
        <form method="POST" action="{{ route('register') }}"
              class="bg-secondary px-5 py-4 rounded bg-opacity-25 w-50">
            @csrf

            <h4 class="text-center text-dark text-decoration-underline mb-3"> {{ __('login-page.sign-up')  }}</h4>

            <!-- Name -->
            <div class="form-group">
                <label for="name" class="mb-1">
                    {{ __('login-page.name')  }}
                </label>
                <input type="text" id="name" name="name"
                       class="form-control form-control-sm"
                       placeholder="John"
                       required>
                <span class="text-danger">
                <ul>
                    @foreach ($errors->get('name') as $err )
                        <li>
                            {{ $err }}
                        </li>
                    @endforeach
            </span>
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="mb-1">
                    Email
                </label>
                <input type="email" id="email" name="email"
                       class="form-control form-control-sm"
                       placeholder="{{ __('login-page.email-placeholder')  }}"
                       required>
                <span class="text-danger">
                <ul>
                    @foreach ($errors->get('email') as $err )
                        <li>
                            {{ $err }}
                        </li>
                    @endforeach
            </span>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="mb-1">
                    {{ __('login-page.passw')  }}
                </label>
                <input type="password" id="password" name="password"
                       class="form-control form-control-sm"
                       placeholder="•••••••••"
                       required>
                <span class="text-danger">
                <ul>
                    @foreach ($errors->get('password') as $err )
                        <li>
                            {{ $err }}
                        </li>
                    @endforeach
            </span>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="mb-1">
                    {{ __('login-page.conf-passw')  }}
                </label>
                <input type="password" id="password_confirmation"  name="password_confirmation"
                       class="form-control form-control-sm"
                       placeholder="•••••••••"
                       required>
                <span class="text-danger">
                <ul>
                    @foreach ($errors->get('password_confirmation') as $err )
                        <li>
                            {{ $err }}
                        </li>
                    @endforeach
            </span>
            </div>

            <!-- Teacher Check-box -->
            <div class="form-group">
                <div class="form-check">
                    <label class="form-check-label" for="teacher">
                        {{ __('login-page.teacher')  }}
                    </label>
                    <input class="form-check-input" type="checkbox" id="teacher" name="teacher">
                </div>
            </div>

            <!-- Teacher Token -->
            <div class="form-group mt-3" id="teacherBox" style="display: none">
                <label for="teacher_token" id="teacher_label" class="mb-1">
                    {{ __('login-page.token')  }}
                </label>
                <input type="text" id="teacher_token" name="teacher_token" class="form-control form-control-sm">
                <span class="text-danger">
                <ul>
                    @foreach ($errors->get('teacher_token') as $err )
                        <li>
                            {{ $err }}
                        </li>
                    @endforeach
            </span>
                <script>
                    let teacherCheckbox = document.getElementById('teacher');
                    let teacherBox = document.getElementById('teacherBox');

                    teacherCheckbox.addEventListener('change', function() {
                        if (this.checked) {
                            teacherBox.style.display = 'block';
                        } else {
                            teacherBox.style.display = 'none';
                        }
                    });
                </script>
            </div>


            <div class="form-group mt-4 d-flex justify-content-center">
                <button type="submit" class="btn btn-dark w-50">
                    {{ __('login-page.reg-butt')  }}
                </button>
            </div>

            <div class="form-group mt-2">
                <small class="form-text text-muted"> {{ __('login-page.muted-text-reg')  }} </small>
                <a href="{{ route('login') }}" class="text-dark"> {{ __('login-page.butt-redirect-log')  }}</a>
            </div>

        </form>
    </div>

    <style>
        @media screen and (max-width: 990px) {
            form {
                min-width: 90vw!important;
            }
        }
    </style>
@endsection
