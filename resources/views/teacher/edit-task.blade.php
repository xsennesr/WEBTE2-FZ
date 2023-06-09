@extends('layout.layout-default')

@section('additional_head')
@endsection
@section('content')
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
  src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
</script>
    {{-- <script src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML" type="text/javascript">
    </script> --}}


    <div class="fs-4 mt-3 mb-2 rounded py-2 px-3" style="background-color: rgba(176,196,222,0.7); border-left: solid black 5px; width: fit-content">
        {{ __('teacher-dashb.edit-task-title')  }}
    </div>

    <div class="container-fluid bg-light rounded my-3 p-4 d-flex justify-content-center">
        <form method="POST" action="{{ route('teacher.update-task', $priklad->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="task_name" class="fs-5 fw-bold form-label text-decoration-underline">
                    {{ __('teacher-dashb.edit-task-title-th-name')  }}
                </label>
                <input type="text" class="form-control form-control-sm" id="task_name"
                       name="task_name" value="{{ $priklad->task_name }}">
            </div>
            <div class="mb-5">
                <label for="task" class="fs-5 fw-bold form-label text-decoration-underline">
                    {{ __('teacher-dashb.edit-task-task')  }}
                </label>
                <textarea class="form-control form-control-sm" id="task" name="task" rows="6">{{ $priklad->task }}</textarea>
            </div>
            <div id="task_output" class="mb-5">
                {{ $priklad->task }}
            </div>
            <div id="task_buffer" class="hidden"></div>
            <div class="my-5">
                <label for="image" class="fs-5 fw-bold form-label text-decoration-underline">
                    {{ __('teacher-dashb.edit-task-image')  }}
                </label>
                <input type="file" class="form-control form-control-sm mb-4" id="image" name="image"
                       accept=".jpg, .png, .jpeg, .webp, .gif">
                <input type="hidden" name="image-base64" id="image-base64" value="{{ $priklad->image }}">
                <img id="image-preview" class="w-75 h-auto mx-auto d-block img-fluid" src="{{ $priklad->image }}" alt="">
            </div>
            <div class="mb-5">
                <label for="solution" class="fs-5 fw-bold form-label text-decoration-underline">
                    {{ __('teacher-dashb.edit-task-solution')  }}
                </label>
                <textarea class="form-control form-control-sm" id="solution" name="solution" rows="6">{{ $priklad->solution }}</textarea>
                <div id="solution-tex"></div>
            </div>
            <div id="solution_output" class="mb-5">
                {{ $priklad->solution }}
            </div>
            <div id="solution_buffer" class="hidden"></div>
            <div class="d-flex justify-content-end mt-2">
                <button type="submit" class="btn btn-light btn-lg ml-auto mt-4" style="background: rgba(63,137,132,0.56)">
                    {{ __('teacher-dashb.edit-batch-submit-butt')  }}
                </button>
            </div>
        </form>
    </div>

    <style>
        @media screen and (max-width: 990px) {
            img {
                min-width: 100%!important;
            }
        }
    </style>

    <script defer>
        var Preview_TASK = {
            delay: 10, // delay after keystroke before updating
            preview: null, // filled in by Init below
            buffer: null, // filled in by Init below
            timeout: null, // store setTimout id
            mjRunning: false, // true when MathJax is processing
            mjPending: false, // true when a typeset has been queued
            oldText: null, // used to check if an update is needed
            //
            //  Get the preview and buffer DIV's
            //
            Init: function(source) {
                this.preview = document.getElementById("task_output");
                this.buffer = document.getElementById("task_buffer");
            },
            //
            //  Switch the buffer and preview, and display the right one.
            //  (We use visibility:hidden rather than display:none since
            //  the results of running MathJax are more accurate that way.)
            //
            SwapBuffers: function() {
                var buffer = this.preview,
                    preview = this.buffer;
                this.buffer = buffer;
                this.preview = preview;
                buffer.style.visibility = "hidden";
                buffer.style.position = "absolute";
                preview.style.position = "";
                preview.style.visibility = "";
            },
            //
            //  This gets called when a key is pressed in the textarea.
            //  We check if there is already a pending update and clear it if so.
            //  Then set up an update to occur after a small delay (so if more keys
            //    are pressed, the update won't occur until after there has been
            //    a pause in the typing).
            //  The callback function is set up below, after the Preview object is set up.
            //
            Update: function() {
                if (this.timeout) {
                    clearTimeout(this.timeout)
                }
                this.timeout = setTimeout(this.callback, this.delay);
            },
            //
            //  Creates the preview and runs MathJax on it.
            //  If MathJax is already trying to render the code, return
            //  If the text hasn't changed, return
            //  Otherwise, indicate that MathJax is running, and start the
            //    typesetting.  After it is done, call PreviewDone.
            //
            CreatePreview: function() {
                Preview_TASK.timeout = null;
                if (this.mjPending) return;
                var text = document.getElementById("task").value;
                if (text === this.oldtext) return;
                if (this.mjRunning) {
                    this.mjPending = true;
                    MathJax.Hub.Queue(["CreatePreview", this]);
                } else {
                    this.buffer.innerHTML = this.oldtext = text;
                    this.mjRunning = true;
                    MathJax.Hub.Queue(
                        ["Typeset", MathJax.Hub, this.buffer],
                        ["PreviewDone", this]
                    );
                }
            },
            //
            //  Indicate that MathJax is no longer running,
            //  and swap the buffers to show the results.
            //
            PreviewDone: function() {
                this.mjRunning = this.mjPending = false;
                this.SwapBuffers();
            }
        };
        var Preview_SOL = {
            delay: 10, // delay after keystroke before updating
            preview: null, // filled in by Init below
            buffer: null, // filled in by Init below
            timeout: null, // store setTimout id
            mjRunning: false, // true when MathJax is processing
            mjPending: false, // true when a typeset has been queued
            oldText: null, // used to check if an update is needed
            Init: function(source) {
                this.preview = document.getElementById("solution_output");
                this.buffer = document.getElementById("solution_buffer");
            },
            SwapBuffers: function() {
                var buffer = this.preview,
                    preview = this.buffer;
                this.buffer = buffer;
                this.preview = preview;
                buffer.style.visibility = "hidden";
                buffer.style.position = "absolute";
                preview.style.position = "";
                preview.style.visibility = "";
            },
            Update: function() {
                if (this.timeout) {
                    clearTimeout(this.timeout)
                }
                this.timeout = setTimeout(this.callback, this.delay);
            },
            CreatePreview: function() {
                Preview_TASK.timeout = null;
                if (this.mjPending) return;
                var text = document.getElementById("solution").value;
                if (text === this.oldtext) return;
                if (this.mjRunning) {
                    this.mjPending = true;
                    MathJax.Hub.Queue(["CreatePreview", this]);
                } else {
                    this.buffer.innerHTML = this.oldtext = text;
                    this.mjRunning = true;
                    MathJax.Hub.Queue(
                        ["Typeset", MathJax.Hub, this.buffer],
                        ["PreviewDone", this]
                    );
                }
            },
            PreviewDone: function() {
                this.mjRunning = this.mjPending = false;
                this.SwapBuffers();
            }
        };
        //
        //  Cache a callback to the CreatePreview action
        //
        window.onload = function() {
            Preview_TASK.Init();
            Preview_TASK.callback = MathJax.Callback("CreatePreview", Preview_TASK);
            Preview_TASK.callback.autoReset = true; // make sure it can run more than once
            Preview_TASK.Update();
            Preview_SOL.Init();
            Preview_SOL.callback = MathJax.Callback("CreatePreview", Preview_SOL);
            Preview_SOL.callback.autoReset = true; // make sure it can run more than once
            Preview_SOL.Update();
        }
    </script>
    <script>
        $("#task").keyup(function() {
            Preview_TASK.Update()
        });
        $("#solution").keyup(function() {
            Preview_SOL.Update()
        });
        $("#image").on("change", function() {
            var file = this.files[0];
            let reader = new FileReader();
            reader.onload = function(event) {
                $("#image-preview").attr("src", event.target.result);
            };
            reader.readAsDataURL(file);
        });
    </script>
@endsection
