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
    <form method="POST" action="{{ route('register') }}"
    class="w-1/2 m-auto "
    >
        @csrf

        <!-- Name -->
        <div class="flex flex-col">
            <label for="name" 
            class="block mb-2 text-sm font-medium text-gray-900">
                Name
            </label>
            <input type="text" id="name"  name="name"
             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
             placeholder="John"
             required>
             <span class="text-red-500">
                <ul>
                    @foreach ($errors->get('name') as $err )
                        <li>
                            {{ $err }}
                        </li>
                    @endforeach
            </span>
        </div>
        <!-- Email Address -->
        <div class="flex flex-col">
            <label for="email"
            class="block mb-2 text-sm font-medium text-gray-900">
                Email
            </label>
            <input type="email" id="email" name="email"
             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
             placeholder="xname@stuba.sk"
             required>
             <span class="text-red-500">
                <ul>
                    @foreach ($errors->get('email') as $err )
                        <li>
                            {{ $err }}
                        </li>
                    @endforeach
            </span>
        </div>

        <!-- Password -->
        <div class="flex flex-col">
            <label for="password" 
            class="block mb-2 text-sm font-medium text-gray-900">
                Password
            </label>
            <input type="password" id="password" name="password"
             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
             placeholder="•••••••••"
             required>
             <span class="text-red-500">
                <ul>
                    @foreach ($errors->get('password') as $err )
                        <li>
                            {{ $err }}
                        </li>
                    @endforeach
            </span>
        </div>

        <!-- Confirm Password -->
        <div class="flex flex-col">
            <label for="password_confirmation" 
            class="block mb-2 text-sm font-medium text-gray-900">
                Confirm password
            </label>
            <input type="password" id="password_confirmation"  name="password_confirmation"
             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
             placeholder="•••••••••"
             required>
             <span class="text-red-500">
                <ul>
                    @foreach ($errors->get('password_confirmation') as $err )
                        <li>
                            {{ $err }}
                        </li>
                    @endforeach
            </span>
        </div>
       
        <div class="flex flex-col">
            <label for="teacher" 
            class="block mb-2 text-sm font-medium text-gray-900">
                Teacher
            </label>
            <input type="checkbox" id="teacher"  name="teacher"
             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  block w-full p-2.5 ">
        </div>

        <div class="flex flex-col">
            <label for="teacher_token" id="teacher_label" 
            class="hidden mb-2 text-sm font-medium text-gray-900">
                Teacher token
            </label>
            <input type="text" id="teacher_token"  name="teacher_token"
             class="hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 "
             >
             <span class="text-red-500">
                <ul>
                    @foreach ($errors->get('teacher_token') as $err )
                        <li>
                            {{ $err }}
                        </li>
                    @endforeach
            </span>
            <script>
                var teacherCheckbox = document.getElementById('teacher');
                var teacherToken = document.getElementById('teacher_token');
                var teacherLabel = document.getElementById('teacher_label');
            
                teacherCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        teacherToken.style.display = 'block';
                        teacherLabel.style.display = 'block';
                    } else {
                        teacherToken.style.display = 'none';
                        teacherLabel.style.display = 'none';
                    }
                });
            </script>
        </div>

        
        
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <button type="submit" class="ml-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                {{ __('Register') }}
            </button>
        </div>
    </form>


@endsection
