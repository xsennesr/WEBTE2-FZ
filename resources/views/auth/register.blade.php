{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
@extends('layout.layout-default')
@section('content')
    <div class="container-fluid d-flex justify-content-center vh-100 align-items-center">
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
