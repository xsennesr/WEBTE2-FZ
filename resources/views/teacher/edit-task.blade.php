@extends('layout.layout-default')

@section('additional_head')
@endsection
@section('content')
    <script>
        window.MathJax = {
            options: {
                renderActions: {
                    addMenu: []
                },
                skipHtmlTags: ["script", "style","textarea", "pre", "code"], //their contents won't be scanned for math
                includeHtmlTags: {
                    br: '\n',
                    wbr: '',
                    '#comment': '',
                }, //  HTML tags that can appear within math
            },
            loader: {
                load: ['[tex]/tagFormat']
            },
            tex: {

                inlineMath: [
                    ["$", "$"]
                ],
                displayMath: [
                    ["$$", "$$"]
                ],
                processEscapes: true,
                packages: {
                    '[+]': ['tagFormat']
                },
                digits: /^(?:[\d۰-۹]+(?:[,٬'][\d۰-۹]{3})*(?:[\.\/٫][\d۰-۹]*)?|[\.\/٫][\d۰-۹]+)/, // introduce numbers
                tagSide: "right",
                tagIndent: ".8em",
                multlineWidth: "85%",
                tags: "all",
                tagFormat: {
                    number: function(n) {
                        return String(n)
                            .replace(/0/g, "۰")
                            .replace(/1/g, "۱")
                            .replace(/2/g, "۲")
                            .replace(/3/g, "۳")
                            .replace(/4/g, "۴")
                            .replace(/5/g, "۵")
                            .replace(/6/g, "۶")
                            .replace(/7/g, "۷")
                            .replace(/8/g, "۸")
                            .replace(/9/g, "۹");
                    }
                },
                environments: {
                    task: ['{\\let\\displaystyle\\textstyle\\begin{aligned}', '\\end{aligned}}'],
                    solution: ['{\\let\\displaystyle\\textstyle\\begin{aligned}', '\\end{aligned}}']
                }

            },
             svg: {
                 fontCache: 'global', // or 'local' or 'none'
                 mtextInheritFont: true, // required to correctly render RTL Persian text inside a formula
                 scale: 0.97, // global scaling factor for all expressions
                 minScale: 0.6 // smallest scaling factor to use
             },
             startup: {
                 typeset: true,
                 ready: function() {
                     MathJax.startup.defaultReady();
                     MathJax.startup.promise.then(function() {
                         console.log("MathJax is ready to use!");
                     });
                 }
             }
        };
    </script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js"></script>

    \begin{task}
    Nájdite prenosovú funkciu $F(s)=\dfrac{Y(s)}{W(s)}$ pre systém opísaný blokovou schémou:
    \end{task}

    \begin{equation*}
    Nájdite prenosovú funkciu $F(s)=\dfrac{Y(s)}{W(s)}$ pre systém opísaný blokovou schémou:
    \end{equation*}

    \begin{solution}
    \begin{equation*}
    \dfrac{2s^2+13s+10}{s^3+7s^2+18s+15}
    \end{equation*}
    \end{solution}



    <form method="POST" action="{{ route('teacher.update-task', $priklad->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="batch_name" class="form-label ">Batch Name</label>
            <input type="text" class="form-control" id="batch_name" name="batch_name" value="{{ $priklad->batch_name }}">
        </div>
        <div class="mb-3">
            <label for="task_name" class="form-label">Task Name</label>
            <input type="text" class="form-control" id="task_name" name="task_name" value="{{ $priklad->task_name }}">
        </div>
        <div class="mb-3">
            <label for="task" class="form-label">Task</label>
            <textarea class="form-control" id="task" name="task" rows="6">{{ $priklad->task }}</textarea>
            <div id="task-tex"></div>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="text" class="form-control" id="image" name="image" value="{{ $priklad->image }}">
        </div>
        <div class="mb-3">
            <label for="solution" class="form-label">Solution</label>
            <textarea class="form-control" id="solution" name="solution" rows="6">{{ $priklad->solution }}</textarea>
             <div id="solution-tex"></div>
        </div>
        <div class="mb-3">
            <label for="max_points" class="form-label">Max Points</label>
            <input type="number" class="form-control" id="max_points" name="max_points" value="{{ $priklad->max_points }}">
        </div>
        <div class="mb-3">
            <label for="publishing_at" class="form-label">Publishing At</label>
            <input type="date" class="form-control" id="publishing_at" name="publishing_at"
                value="{{ $priklad->publishing_at }}">
        </div>
        <div class="mb-3">
            <label for="closing_at" class="form-label">Closing At</label>
            <input type="date" class="form-control" id="closing_at" name="closing_at" value="{{ $priklad->closing_at }}">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="available" name="available"
                {{ $priklad->available ? 'checked' : '' }}>
            <label class="form-check-label" for="available">Available</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    {{--  <script type="text/x-mathjax-config">
        MathJax.Hub.Config({
            jax: ["input/TeX", "output/HTML-CSS"],
            tex2jax: {
            inlineMath: [ ['$','$'], ["\\(","\\)"] ],
            displayMath: [ ['$$','$$'], ["\\[","\\]"] ],
            processEscapes: true
            },
            "HTML-CSS": { fonts: ["TeX"] }
        });
    </script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.7/MathJax.js"></script> --}}
@endsection
