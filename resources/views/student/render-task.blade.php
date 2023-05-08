@extends('layout.layout-default')
@section('additional_head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
@endsection
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
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form action="{{ route('student.submit-task') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <div class="task-wording">
                            <p>{{ $task->task }}</p>
                            @if ($task->image)
                                <img class="img-fluid" src="{{ $task->image }}" alt="">
                            @endif
                        </div>
                    </div>

                    <div class="form-group w-75 p-3">
                        <label for="solution">Solution:</label>
                        <input type="hidden" name="user-solution" id="user-solution-hidden">
                        <math-field id="user-solution" name="user-solution" required></math-field>
                    </div>


                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        $('form').submit(function(event) {
            // Get the content of the math-field
            let mathFieldContent = $('#user-solution').val();

            // Assign the math-field content to the hidden input field
            $('#user-solution-hidden').val(mathFieldContent);
        });
    </script>
@endsection
