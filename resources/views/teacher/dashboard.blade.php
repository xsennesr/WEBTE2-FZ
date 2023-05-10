@extends('layout.layout-default')

@section('additional_head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
@endsection

@section('content')
    <div class="fs-2 mt-3 mb-5 rounded w-100 py-2 px-3" style="background-color: lightsteelblue">
        Teacher dashboard
    </div>

    <div class="bg-light p-4 rounded">
        <label class="fs-4 text-decoration-underline mb-3">Upload new files</label>
        <form action="{{ route('teacher.upload.zip') }}" method="POST" enctype="multipart/form-data"
                class="d-flex align-items-start flex-column mx-2">
            @csrf
            <input type="file" name="my-file" id="" class="form-control form-control-sm mb-3 w-50">
            <input type="submit" name="submit" id="" class="btn btn-light" style="background: lightsteelblue">
        </form>
    </div>


    @if (isset($sady))
        <div class="my-4">
            <div class="bg-light p-4 mb-4 rounded table-responsive">
                <label class="fs-4 text-decoration-underline mb-4">Uploaded files</label>
                <table id="sady" class="display table table-striped table-light table-hover rounded">
                    <thead class="table-dark">
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
                            <td><a href="{{ route('teacher.edit-batch', ['id' => $sada->id]) }}"
                                   type="button" class="btn btn-light btn-sm" style="background: lightsteelblue">
                                    <span class="text-center">Edit</span>
                                    <i class="bi bi-pencil-square align-text-bottom"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-light p-4 mb-4 rounded table-responsive">
                <label class="fs-4 text-decoration-underline mb-4">Students</label>
                <table id="students" class="display table table-striped table-light table-hover rounded">
                    <thead class="table-dark">
                    <tr>
                        <th>{{ __('messages.name')  }}</th>
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

            <a href="{{ route('teacher.export-csv') }}" class="btn btn-light"
               style="background: lightsteelblue">
                Download CSV
            </a>
        </div>

        <script>
            let table = new DataTable('#sady');
            let table2 = new DataTable('#students');
        </script>

        <script type="text/javascript">
            var url = "{{ route('changeLang') }}";
            $(".changeLang").change(function(){
                window.location.href = url + "?lang="+ $(this).val();
            });
        </script>
    @endif

@endsection
