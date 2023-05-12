@extends('layout.layout-default')
@section('content')

<div class="fs-2 mt-3 mb-5 w-100 rounded py-2 px-3" style="background-color: rgba(176,196,222,0.7); border-left: solid black 5px">
    <h2>{{ __('introduction-student.header')  }}</h2>
    {{ __('introduction-student.intro')  }}

    <br><br>
    <ol>
        <li>{{ __('introduction-student.first')  }}</li>
        <li>{{ __('introduction-student.second')  }}</li>
        <li>{{ __('introduction-student.third')  }}</li>
        <li>{{ __('introduction-student.fourth')  }}</li>
        <li>{{ __('introduction-student.fifth')  }}</li>
    </ol>
    <br>
    {{ __('introduction-student.footer')  }}
</div>

@endsection
