@extends('layout.layout-default')
@section('content')
    <div class="container-fluid d-flex justify-content-center vh-100 align-items-center">
        <form method="POST" action="{{ route('login') }}"
              class="bg-secondary p-5 rounded bg-opacity-25 m-auto w-50">
            @csrf

            <h4 class="text-center text-dark text-decoration-underline mb-3">{{ __('login-page.sign-in')  }}</h4>

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="mb-2">
                    Email
                </label>
                <input type="email" id="email" name="email"
                       class="form-control"
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
                <label for="password"
                       class="mb-2">
                    {{ __('login-page.passw')  }}
                </label>
                <input type="password" id="password" name="password"
                       class="form-control"
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


            <div class="form-group mt-4 d-flex justify-content-center">
                <button type="submit" class="btn btn-dark w-50">
                    {{ __('login-page.button-login')  }}
                </button>
            </div>

            <div class="form-group mt-2">
                <small class="form-text text-muted">  {{ __('login-page.muted-text-login')  }} </small>
                <a href="{{ route('register') }}" class="text-dark"> {{ __('login-page.butt-redirect')  }}</a>
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
