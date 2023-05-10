@extends('layout.layout-default')
@section('additional_head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
@endsection
@section('content')

    <div class="fs-2 mt-3 mb-5 rounded w-100 py-2 px-3" style="background-color: lightsteelblue">
        Student dashboard
    </div>

    <div class="bg-light p-4 rounded">
        <label class="fs-4 text-decoration-underline mb-3">Dostupné sady príkladov</label>

        <form action="{{ route('student.generate-task') }}" method="POST" class="mx-2">
            @csrf
            @foreach ($batches as $batch)
                <div class="form-group mb-3">
                    <input type="checkbox" class="form-check-input" id="selected-batch" name="selected-batch[]"
                        value="{{ $batch->id }}">
                    <label for="selected-batch" class="mx-2">{{ $batch->name }}</label>
                    <input type="hidden" name="batch-id" id="batch-id" value="{{ $batch->id }}">
                </div>
            @endforeach
            <button type="submit" class="btn btn-light" style="background: lightsteelblue">
                Generuj priklad
            </button>
        </form>
    </div>

    @if (isset($tasks))
        <div class="my-4">
            <div class="bg-light p-4 mb-4 rounded table-responsive">
                <label class="fs-4 text-decoration-underline mb-4">Príklady</label>
                <table id="priklady" class="display table table-striped table-light table-hover rounded">
                    <thead class="table-dark">
                    <tr>
                        <th>Nazov prikladu</th>
                        <th>Odovzdane</th>
                        <th>Vysledok</th>
                        <th>Ziskane body</th>
                        <th>Akcia</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($tasks as $priklad)
                        <tr>
                            <td>{{ $priklad->task_name }}</td>
                            <td>{{ $priklad->pivot->submitted ? 'Ano' : "Nie" }}</td>
                            <td>{{ $priklad->pivot->result ? 'Spravny' : ($priklad->result === false ? 'Nespravny' : 'Este ziadny') }}</td>

                            <td>{{ $priklad->pivot->points}}</td>
                            <td><a href="{{route('student.render-task', $priklad->id)}}" type="button"
                                   class="btn btn-light btn-sm" style="background: lightsteelblue">Vyriešiť</a>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <script>
            let table = new DataTable('#priklady');
        </script>
@endsection
