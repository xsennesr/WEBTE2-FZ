@extends('layout.layout-default')
@section('content')

<div class="fs-2 mt-3 mb-5 w-100 rounded py-2 px-3" style="background-color: rgba(176,196,222,0.7); border-left: solid black 5px">
    <h1>{{ __('introduction.s-header')  }}</h1>
    <label>{{ __('introduction.s-intro')  }}</label>

    <br><br>
    <ol>
        <li>{{ __('introduction.s-first')  }}</li>
        <li>{{ __('introduction.s-second')  }}</li>
        <li>{{ __('introduction.s-third')  }}</li>
        <li>{{ __('introduction.s-fourth')  }}</li>
        <li>{{ __('introduction.s-fifth')  }}</li>
    </ol>
    <br>
    {{ __('introduction.s-footer')  }}
</div>

@endsection
