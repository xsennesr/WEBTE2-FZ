@extends('layout.layout-default')

@section('content')

    @if(Auth::check())
        @if(Auth::user()->ucitel === 1)
            @php
                header("Location: " . route('teacher.dashboard'));
                exit;
            @endphp
        @else
            @php
                header("Location: " . route('student.dashboard'));
                exit;
            @endphp
        @endif
    @else
        <p>Please log in to continue.</p>
    @endif

@endsection
