@extends('layout.layout-default')

@section('additional_head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
@endsection

@section('content')


   
    @if (isset($sada))
        <div>
            <form method="POST" action="{{ route('teacher.update-batch', $sada->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="batch_name" class="form-label">Batch Name</label>
                    <input type="text" class="form-control" id="batch_name" name="batch_name" value="{{ $sada->name }}">
                </div>
                <div class="mb-3">
                    <label for="max_points" class="form-label">Max Points</label>
                    <input type="number" class="form-control" id="max_points" name="max_points" value="{{ $sada->max_points }}">
                </div>
                <div class="mb-3">
                    <label for="publishing_at" class="form-label">Publishing At</label>
                    <input type="datetime-local" class="form-control" id="publishing_at" name="publishing_at"
                        value="{{ $sada->publishing_at }}">
                </div>
                <div class="mb-3">
                    <label for="closing_at" class="form-label">Closing At</label>
                    <input type="datetime-local" class="form-control" id="closing_at" name="closing_at"
                        value="{{ $sada->closing_at }}">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="available" name="available"
                        {{ $sada->available ? 'checked' : '' }}>
                    <label class="form-check-label" for="available">Available</label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        @if (isset($priklady))
        <div class="m-5">

            <table id="priklady" class="display">
                <thead>
                    <tr>
                        <th>Nazov prikladu</th>
                        <th>Uprav</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($priklady as $priklad)
                        <tr>
                            <td>{{ $priklad->task_name }}</td>
                            <td><a href="{{ route('teacher.edit-task', ['batch_id' => $sada->id, 'task_id' => $priklad->id]) }}"type="button" class="btn btn-primary"
                                   >Uprav</a>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <script>
            let table = new DataTable('#priklady');
        </script>
    @endif
    @endif

@endsection
