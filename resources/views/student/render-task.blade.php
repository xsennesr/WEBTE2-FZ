@extends('layout.layout-default')
@section('additional_head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

    <script type="text/x-mathjax-config">
        MathJax.Hub.Config({
            extensions: ["tex2jax.js"],
            jax: ["input/TeX", "output/HTML-CSS"],
            tex2jax: {
            inlineMath: [ ['$','$'], ["\\(","\\)"] ],
            displayMath: [ ['$$','$$'], ["\\[","\\]"] ],
            processEscapes: true
            },
            "HTML-CSS": { availableFonts: ["TeX"] }
        });
    </script>
    <script type="text/javascript" async
        src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
    <script defer src="//unpkg.com/mathlive"></script>
@endsection
@section('content')

    <div class="fs-3 mt-3 mb-3 text-decoration-underline">
        Príklad na vyriešenie
    </div>

    <div class="container-fluid bg-light p-4 rounded d-flex justify-content-center flex-column my-3">
        <div class="fs-6 task-wording text-center">
            <p class="mb-5 rounded py-3" style="background: lightsteelblue">{{ $task->task }}</p>
            @if ($task->image)
                <img class="img-fluid w-75 h-auto mx-auto d-block my-5" src="{{ $task->image }}" alt="">
            @endif
        </div>

        <form action="{{ route('student.submit-task') }}" method="POST" class="mb-0">
            @csrf
            <div class="d-flex justify-content-center flex-column form-group m-auto w-100 p-3">
                <label for="solution"
                       class="fs-5 fw-normal text-decoration-underline mx-1 mb-3">
                    Solution:
                </label>
                <input type="hidden" name="user-solution" id="user-solution-hidden">
                <math-field id="user-solution" name="user-solution" required class="w-100"></math-field>
                <input type="hidden" name="task_id" value="{{ $task->id }}">
                <div class="d-flex justify-content-end mt-5">
                    <button type="submit" class="btn btn-light text-dark px-4 ml-auto"
                            style="background: lightsteelblue">
                        Submit
                    </button>
                </div>
            </div>
        </form>

        <!-- TODO:: -->
        @if ($priklad->user_solution)
            <p class="fs-5 fw-normal text-decoration-underline mx-1 mb-3">Your solution:</p>
            <p>{{ $priklad->user_solution }}</p>
        @endif
    </div>

    <style>
        @media screen and (max-width: 990px) {
            img {
                min-width: 100%!important;
            }
        }
    </style>

    <script>
        $('form').submit(function(event) {
            // Get the content of the math-field
            let mathFieldContent = $('#user-solution').val();

            // Assign the math-field content to the hidden input field
            $('#user-solution-hidden').val(mathFieldContent);
        });
    </script>
    <script type="module">
  import { ComputeEngine } from
    'https://unpkg.com/@cortex-js/compute-engine?module';

  const ce = new ComputeEngine();
  console.log(ce.parse('\\dfrac{6}{(5s+2)^2}e^{-4s}').json);
  // ➔ "-1"
</script>
@endsection
