@extends('layout.layout-default')
@section('content')

@include('introduction-student.studentContent')

<a href="/student/generatePDF" class="btn btn-light mt-4" style="background: lightsteelblue">{{ __('introduction.pdf-btn')  }}</a>

    <script>
        document.getElementById('info').style.color = 'whitesmoke';
    </script>

@endsection
