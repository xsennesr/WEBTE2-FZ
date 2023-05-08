
{{-- <x-guest-layout> --}}
    <!-- Session Status -->
    {{-- <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form> --}}
{{-- </x-guest-layout> --}}
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
