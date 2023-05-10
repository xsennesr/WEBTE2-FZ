@extends('layout.layout-default')

@section('additional_head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
@endsection

@section('content')

    @if (isset($sada))

        <div class="fs-5 mt-3 mb-2 rounded py-2 px-3" style="background-color: lightsteelblue; width: fit-content">
            Edit batch
        </div>

        <div class="container-fluid bg-light rounded my-3 p-4 d-flex justify-content-center">
            <form method="POST" action="{{ route('teacher.update-batch', $sada->id) }}" enctype="multipart/form-data"
                    class="w-50">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="batch_name" class="form-label text-decoration-underline">Batch Name</label>
                    <input type="text" class="form-control form-control-sm" id="batch_name"
                           name="batch_name" value="{{ $sada->name }}">
                </div>
                <div class="mb-3">
                    <label for="max_points" class="form-label text-decoration-underline">Max Points</label>
                    <input type="number" class="form-control form-control-sm" id="max_points"
                           name="max_points" value="{{ $sada->max_points }}">
                </div>
                <div class="mb-3">
                    <label for="publishing_at" class="form-label text-decoration-underline">Publishing At</label>
                    <input type="datetime-local" class="form-control form-control-sm" id="publishing_at"
                           name="publishing_at" value="{{ $sada->publishing_at }}">
                </div>
                <div class="mb-3">
                    <label for="closing_at" class="form-label text-decoration-underline">Closing At</label>
                    <input type="datetime-local" class="form-control form-control-sm" id="closing_at"
                           name="closing_at" value="{{ $sada->closing_at }}">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="available" name="available"
                        {{ $sada->available ? 'checked' : '' }}>
                    <label class="form-check-label" for="available">Available</label>
                </div>
                <div class="d-flex justify-content-end mt-2">
                    <button type="submit" class="btn btn-light ml-auto" style="background: lightsteelblue">
                        Submit
                    </button>
                </div>
            </form>
        </div>


        @if (isset($priklady))

            <div class="fs-5 mt-5 mb-2 rounded py-2 px-3" style="background-color: lightsteelblue; width: fit-content">
                Edit tasks
            </div>

            <div class="container-fluid bg-light rounded my-3 p-4 table-responsive">
                <table id="priklady" class="display table table-striped table-light table-hover rounded">
                    <thead class="table-dark">
                        <tr>
                            <th>Nazov prikladu</th>
                            <th>Uprav</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($priklady as $priklad)
                            <tr>
                                <td>{{ $priklad->task_name }}</td>
                                <td class="text-center">
                                    <a href="{{ route('teacher.edit-task', ['batch_id' => $sada->id, 'task_id' => $priklad->id]) }}"
                                       type="button" class="btn btn-light btn-sm" style="background-color: lightsteelblue">
                                        Uprav
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        <script>
            let table = new DataTable('#priklady');
        </script>
        @endif

        <style>
            @media screen and (max-width: 540px) {
                form {
                    min-width: 100%!important;
                }
            }
        </style>
    @endif
@endsection
