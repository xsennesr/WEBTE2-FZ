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

<script src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML" type="text/javascript"></script>

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
        </div>
        <div id="task_output" class="mb-3">
            {{ $priklad->task }}
        </div>
        <div id="task_buffer" class="hidden"></div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="text" class="form-control" id="image" name="image" value="{{ $priklad->image }}">
        </div>
        <div class="mb-3">
            <label for="solution" class="form-label">Solution</label>
            <textarea class="form-control" id="solution" name="solution" rows="6">{{ $priklad->solution }}</textarea>
        </div>
        <div id="solution_output" class="mb-3">
            {{ $priklad->solution }}
        </div>
        <div id="solution_buffer" class="hidden"></div>
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
    <script defer>
        var Preview_TASK = {
          delay: 10,        // delay after keystroke before updating
          preview: null,     // filled in by Init below
          buffer: null,      // filled in by Init below
          timeout: null,     // store setTimout id
          mjRunning: false,  // true when MathJax is processing
          mjPending: false,  // true when a typeset has been queued
          oldText: null,     // used to check if an update is needed
          //
          //  Get the preview and buffer DIV's
          //
          Init: function (source) {
            this.preview = document.getElementById("task_output");
            this.buffer = document.getElementById("task_buffer");
          },
          //
          //  Switch the buffer and preview, and display the right one.
          //  (We use visibility:hidden rather than display:none since
          //  the results of running MathJax are more accurate that way.)
          //
          SwapBuffers: function () {
            var buffer = this.preview, preview = this.buffer;
            this.buffer = buffer; this.preview = preview;
            buffer.style.visibility = "hidden"; buffer.style.position = "absolute";
            preview.style.position = ""; preview.style.visibility = "";
          },
          //
          //  This gets called when a key is pressed in the textarea.
          //  We check if there is already a pending update and clear it if so.
          //  Then set up an update to occur after a small delay (so if more keys
          //    are pressed, the update won't occur until after there has been 
          //    a pause in the typing).
          //  The callback function is set up below, after the Preview object is set up.
          //
          Update: function () {
            if (this.timeout) {clearTimeout(this.timeout)}
            this.timeout = setTimeout(this.callback,this.delay);
          },
          //
          //  Creates the preview and runs MathJax on it.
          //  If MathJax is already trying to render the code, return
          //  If the text hasn't changed, return
          //  Otherwise, indicate that MathJax is running, and start the
          //    typesetting.  After it is done, call PreviewDone.
          //  
          CreatePreview: function () {
            Preview_TASK.timeout = null;
            if (this.mjPending) return;
            var text = document.getElementById("task").value;
            
            if (text === this.oldtext) return;
            if (this.mjRunning) {
              this.mjPending = true;
              MathJax.Hub.Queue(["CreatePreview",this]);
            } else {
              this.buffer.innerHTML = this.oldtext = text;
              this.mjRunning = true;
              MathJax.Hub.Queue(
            ["Typeset",MathJax.Hub,this.buffer],
            ["PreviewDone",this]
              );
            }
          },
          //
          //  Indicate that MathJax is no longer running,
          //  and swap the buffers to show the results.
          //
          PreviewDone: function () {
            this.mjRunning = this.mjPending = false;
            this.SwapBuffers();
          }
        };
        var Preview_SOL = {
          delay: 10,        // delay after keystroke before updating
          preview: null,     // filled in by Init below
          buffer: null,      // filled in by Init below
          timeout: null,     // store setTimout id
          mjRunning: false,  // true when MathJax is processing
          mjPending: false,  // true when a typeset has been queued
          oldText: null,     // used to check if an update is needed

          Init: function (source) {
            this.preview = document.getElementById("solution_output");
            this.buffer = document.getElementById("solution_buffer");
          },

          SwapBuffers: function () {
            var buffer = this.preview, preview = this.buffer;
            this.buffer = buffer; this.preview = preview;
            buffer.style.visibility = "hidden"; buffer.style.position = "absolute";
            preview.style.position = ""; preview.style.visibility = "";
          },

          Update: function () {
            if (this.timeout) {clearTimeout(this.timeout)}
            this.timeout = setTimeout(this.callback,this.delay);
          },

          CreatePreview: function () {
            Preview_TASK.timeout = null;
            if (this.mjPending) return;
            var text = document.getElementById("solution").value;
            
            if (text === this.oldtext) return;
            if (this.mjRunning) {
              this.mjPending = true;
              MathJax.Hub.Queue(["CreatePreview",this]);
            } else {
              this.buffer.innerHTML = this.oldtext = text;
              this.mjRunning = true;
              MathJax.Hub.Queue(
            ["Typeset",MathJax.Hub,this.buffer],
            ["PreviewDone",this]
              );
            }
          },
          PreviewDone: function () {
            this.mjRunning = this.mjPending = false;
            this.SwapBuffers();
          }
        };
        //
        //  Cache a callback to the CreatePreview action
        //
        window.onload = function(){
                Preview_TASK.Init();
                Preview_TASK.callback = MathJax.Callback("CreatePreview", Preview_TASK);
                Preview_TASK.callback.autoReset = true;  // make sure it can run more than once
                Preview_TASK.Update();

                Preview_SOL.Init();
                Preview_SOL.callback = MathJax.Callback("CreatePreview", Preview_SOL);
                Preview_SOL.callback.autoReset = true;  // make sure it can run more than once
                Preview_SOL.Update();
        }
    </script>
    <script>

        $("#task").keyup(function () {
            Preview_TASK.Update()
        });
        $("#solution").keyup(function () {
            Preview_SOL.Update()
        });
    </script>
@endsection
