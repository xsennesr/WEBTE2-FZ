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
   
    @if (isset($priklady))
        <div class="m-5">

            <table id="priklady" class="display">
                <thead>
                    <tr>
                        <th>Sada</th>
                        <th>Nazov priklady</th>
                        <th>Uprav</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($priklady as $priklad)
                        <tr>
                            <td>{{ $priklad->batch_name }}</td>
                            <td>{{ $priklad->task_name }}</td>
                            <td><a href="{{ route('teacher.edit-task', ['id' => $priklad->id]) }}"type="button" class="btn btn-primary"
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

@endsection
