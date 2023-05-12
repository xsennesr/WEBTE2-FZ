@extends('layout.layout-default')
@section('additional_head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
@endsection
@section('content')
    @if (isset($student))
        <div class="fs-2 mt-3 mb-3 text-decoration-underline">
            {{ $student->name }}
        </div>

        <div class="bg-light p-4 mb-4 rounded table-responsive">
            <table id="student" class="display table table-striped table-light table-hover rounded">
                <thead class="table-dark">
                <tr>
                    <th>{{ __('student-dashb.tasks-name')  }}</th>
                    <th class="text-center">{{ __('student-dashb.task-subm')  }}</th>
                    <th class="text-center">{{ __('student-dashb.task-result')  }}</th>
                    <th class="text-center">{{ __('teacher-dashb.edit-task-solution')  }}</th>
                    <th class="text-center">{{ __('student-dashb.task-points')  }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($student->priklady as $priklad)
                    <tr>
                        <td>
                            {{ $priklad->task_name }}
                        </td>
                        <td class="text-center">
                            @if ($priklad->pivot->submitted)
                                <i class="bi bi-check2 wf-bolder fs-5 text-light rounded bg-success pb-1 px-1"></i>
                            @elseif(!$priklad->pivot->submitted)
                                <i class="bi bi-x wf-bolder fs-5 text-light rounded bg-danger pb-1 px-1"></i>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($priklad->pivot->result) {{ __('student-dashb.task-sol-corr') }}
                            @elseif(!$priklad->pivot->result && $priklad->pivot->submitted) {{ __('student-dashb.task-sol-incorr') }}
                            @else {{ __('student-dashb.task-sol-not-subm') }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($priklad->pivot->user_solution) {{ $priklad->pivot->user_solution }}
                            @else {{ '---' }}
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $priklad->pivot->points }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>


        <script>
            let table = new DataTable('#student');
        </script>

        <script type="text/javascript">
            var urll = "{{ route('changeLang') }}";
            $(".changeLang").change(function(){
                window.location.href = urll + "?lang="+ $(this).val();
            });
        </script>
    @endif
@endsection
