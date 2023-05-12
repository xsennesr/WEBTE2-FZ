@extends('layout.layout-default')
@section('additional_head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
@endsection
@section('content')

    <div class="fs-2 mt-3 mb-5 w-100 rounded py-2 px-3" style="background-color: rgba(176,196,222,0.7); border-left: solid black 5px">
        {{ __('student-dashb.title-main')  }}
    </div>

    <div class="bg-light p-4 rounded">
        <label class="fs-4 text-decoration-underline mb-3">
            {{ __('student-dashb.title-batches')  }}
        </label>

        <form action="{{ route('student.generate-task') }}" method="POST" class="mx-2">
            @csrf
            @foreach ($batches as $batch)
                <div class="form-group mb-3">
                    <input type="checkbox" class="form-check-input" id="selected-batch" name="selected-batch[]"
                        value="{{ $batch['id'] }}">
                    <label for="selected-batch" class="mx-2">{{ $batch['name'] }}</label>
                    <input type="hidden" name="batch-id" id="batch-id" value="{{ $batch['id'] }}">
                </div>
            @endforeach
            <button type="submit" class="btn btn-light mt-4" style="background: lightsteelblue">
                {{ __('student-dashb.gen-butt')  }}
            </button>
        </form>
    </div>

    @if (isset($tasks))
        <div class="my-4">
            <div class="bg-light p-4 mb-4 rounded table-responsive">
                <label class="fs-4 text-decoration-underline mb-4">
                    {{ __('student-dashb.title-tasks')  }}
                </label>
                <table id="priklady" class="display table table-striped table-light table-hover rounded">
                    <thead class="table-dark">
                    <tr>
                        <th>{{ __('student-dashb.tasks-name')  }}</th>
                        <th class="text-center">{{ __('student-dashb.task-subm')  }}</th>
                        <th class="text-center">{{ __('student-dashb.task-result')  }}</th>
                        <th class="text-center">{{ __('student-dashb.task-points')  }}</th>
                        <th class="text-center">{{ __('student-dashb.task-action')  }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($tasks as $priklad)
                        <tr>
                            <td>{{ $priklad->task_name }}</td>
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
                            <td class="text-center">{{ $priklad->pivot->points}}</td>
                            <td class="text-center"><a href="{{route('student.render-task', $priklad->id)}}" type="button"
                                   class="btn btn-light" style="background-color: #eedb8c">
                            @if (!$priklad->pivot->submitted)
                                        {{ __('student-dashb.task-solve-butt')  }}
                            @else
                                        {{ __('student-dashb.task-show-butt')  }}
                            @endif
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <script>
            let table = new DataTable('#priklady');
            document.getElementById('home-s').style.color = 'whitesmoke';
        </script>
@endsection
