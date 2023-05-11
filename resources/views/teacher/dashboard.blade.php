@extends('layout.layout-default')

@section('additional_head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
@endsection

@section('content')
    <div class="fs-2 mt-3 mb-5 rounded w-100 py-2 px-3" style="background-color: lightsteelblue">
        {{ __('teacher-dashb.title-main')  }}
    </div>

    <div class="bg-light p-4 rounded">
        <label class="fs-4 text-decoration-underline mb-3">{{ __('teacher-dashb.title-upload')  }}</label>
        <form action="{{ route('teacher.upload.zip') }}" method="POST" enctype="multipart/form-data"
                class="d-flex align-items-start flex-column mx-2">
            @csrf
            <input type="file" name="my-file" id="" class="form-control form-control-sm mb-3 w-50">
            <button type="submit" name="submit" id="" class="btn btn-light" style="background: lightsteelblue">
                {{ __('teacher-dashb.upload-butt')  }}
            </button>
        </form>
    </div>


    @if (isset($sady))
        <div class="my-4">
            <div class="bg-light p-4 mb-4 rounded table-responsive">
                <label class="fs-4 text-decoration-underline mb-4">{{ __('teacher-dashb.title-uploads')  }}</label>
                <table id="sady" class="display table table-striped table-light table-hover rounded">
                    <thead class="table-dark">
                    <tr>
                        <th>{{ __('teacher-dashb.th-batch')  }}</th>
                        <th class="text-center">{{ __('teacher-dashb.th-point')  }}</th>
                        <th class="text-center">{{ __('teacher-dashb.th-avail')  }}</th>
                        <th class="text-center">{{ __('teacher-dashb.th-avail-from')  }}</th>
                        <th class="text-center">{{ __('teacher-dashb.th-avail-to')  }}</th>
                        <th class="text-center">{{ __('teacher-dashb.th-action')  }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($sady as $sada)
                        <tr>
                            <td>{{ $sada->name }}</td>
                            <td class="text-center">{{ $sada->max_points ??  __('teacher-dashb.th-points-unset') }}</td>
                            <td class="text-center">
                                @if ($sada->available)
                                    <i class="bi bi-check2 wf-bolder fs-5 text-light rounded bg-success pb-1 px-1"></i>
                                @else
                                    <i class="bi bi-x wf-bolder fs-5 text-light rounded bg-danger pb-1 px-1"></i>
                                @endif
                            </td>
                            <td class="text-center">{{ $sada->publishing_at }}</td>
                            <td class="text-center">{{ $sada->closing_at }}</td>
                            <td class="text-center"><a href="{{ route('teacher.edit-batch', ['id' => $sada->id]) }}"
                                   type="button" class="btn btn-light" style="background: lightsteelblue">
                                    <span class="text-center">{{ __('teacher-dashb.table-edit-butt')  }}</span>
                                    <i class="bi bi-pencil-square align-text-bottom"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-light p-4 mb-4 rounded table-responsive">
                <label class="fs-4 text-decoration-underline mb-4">{{ __('teacher-dashb.student-table-title')  }}</label>
                <table id="students" class="display table table-striped table-light table-hover rounded">
                    <thead class="table-dark">
                    <tr>
                        <th>{{ __('teacher-dashb.student-table-th-name')  }}</th>
                        <th class="text-center">ID</th>
                        <th class="text-center">{{ __('teacher-dashb.student-table-th-generated')  }}</th>
                        <th class="text-center">{{ __('teacher-dashb.student-table-th-submitted')  }}</th>
                        <th class="text-center">{{ __('teacher-dashb.th-point')  }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td class="text-center">{{ $user->id }}</td>
                            <td class="text-center">{{ $user->priklady->count() }}</td>
                            <td class="text-center">{{ $user->odovzdane_priklady->count() }}</td>
                            <td class="text-center">{{ $user->priklady->sum('pivot.points') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <a href="{{ route('teacher.export-csv') }}" class="btn btn-light"
               style="background: lightsteelblue">
                {{ __('teacher-dashb.csv-butt')  }}
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
