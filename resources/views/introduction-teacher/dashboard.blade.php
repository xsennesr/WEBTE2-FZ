@extends('layout.layout-default')
@section('content')

@include('introduction-teacher.teacherContent')


<div class="d-flex justify-content-end mt-2 w-100">

    <a href="/teacher/generatePDF" class="btn btn-light mr-auto mt-4 mb-3" style="background: lightsteelblue">
        {{ __('introduction.pdf-btn')  }}
    </a>
</div>

    <script>
        document.getElementById('info').style.color = 'whitesmoke';
    </script>

@endsection
