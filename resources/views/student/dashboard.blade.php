@extends('layout.layout-default')
@section('additional_head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
@endsection
@section('content')
    Dostupne sady prikladov
    <form action="{{ route('student.generate-task') }}" method="POST">
        @csrf
        @foreach ($batches as $batch)
            <div>
                <label for="selected-batch">{{ $batch->name }}</label>
                <input type="checkbox" class="form-check-input" id="selected-batch" name="selected-batch[]"
                    value="{{ $batch->id }}">
                <input type="hidden" name="batch-id" id="batch-id" value="{{ $batch->id }}">
            </div>
        @endforeach
        <button type="submit">Generuj priklad</button>
    </form>
    @if (isset($tasks))
        <div class="m-5">

            <table id="priklady" class="display">
                <thead>
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
                            <td><a href="{{route('student.render-task', $priklad->id)}}"type="button"
                                    class="btn btn-primary">Vyries</a>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        @endif
        <script>
            let table = new DataTable('#priklady');
        </script>

    @endsection
