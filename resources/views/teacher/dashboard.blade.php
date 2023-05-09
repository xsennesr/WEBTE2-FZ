@extends('layout.layout-default')

@section('additional_head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
@endsection

@section('content')
    <div class="">
        Teacher dashboard
    </div>
    <form action="{{ route('teacher.upload.zip') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="my-file" id="">
        <input type="submit" name="submit" id="">
    </form>

    @if (isset($sady))
        <div class="m-5">

            <table id="sady" class="display">
                <thead>
                    <tr>
                        <th>Sada</th>
                        <th>Body</th>
                        <th>Dostupny</th>
                        <th>Dostupne od</th>
                        <th>Dostupne do</th>
                        <th>Uprav</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sady as $sada)
                        <tr>
                            <td>{{ $sada->name }}</td>
                            <td>{{ $sada->max_points ?? 'Undefined'}}</td>
                            <td>{{ $sada->available ? 'Yes' : 'No' }}</td>
                            <td>{{ $sada->publishing_at }}</td>
                            <td>{{ $sada->closing_at }}</td>
                            <td><a href="{{ route('teacher.edit-batch', ['id' => $sada->id]) }}"type="button" class="btn btn-primary"
                                   >Uprav</a>
                        </tr>
                    @endforeach

                </tbody>
            </table>

            <table id="students" class="display">
                <thead>
                    <tr>
                        <th>Meno</th>
                        <th>ID</th>
                        <th>Vygenerované</th>
                        <th>Odovzdané</th>
                        <th>Počet bodov</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->id }}</td>
                        <td>0</td>
                        <td>0</td>
                        <td>{{ $user->priklady->sum('pivot.points') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <script>
            let table = new DataTable('#sady');
            let table2 = new DataTable('#students');
        </script>
    @endif

@endsection
