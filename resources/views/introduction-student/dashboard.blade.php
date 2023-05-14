@extends('layout.layout-default')
@section('content')

@include('introduction-student.studentContent')


<div class="d-flex justify-content-end mt-2 w-100">
    <a href="/student/generatePDF" class="btn btn-light mt-4 mr-auto mb-3" style="background: lightsteelblue">
        {{ __('introduction.pdf-btn')  }}
    </a>
</div>

    <script>
        document.getElementById('info').style.color = 'whitesmoke';
    </script>

@endsection
