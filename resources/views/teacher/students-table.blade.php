@extends('layout.layout-default')

@section('additional_head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
@endsection

@section('content')
    <div class="fs-2 mt-3 mb-5 w-100 rounded py-2 px-3" style="background-color: rgba(176,196,222,0.7); border-left: solid black 5px">
        {{ __('teacher-dashb.student-table-title')  }}
    </div>

    @if (isset($users))
        <div class="bg-light p-4 mb-4 rounded table-responsive">
            <!--<label class="fs-4 text-decoration-underline mb-4">{{ __('teacher-dashb.student-table-title')  }}</label>-->
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
                        <td><a href="{{route('teacher.show-student', $user->id)}}" class="text-dark">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td class="text-center">{{ $user->id }}</td>
                        <td class="text-center">{{ $user->priklady->count() }}</td>
                        <td class="text-center">{{ $user->odovzdane_priklady->count() }}</td>
                        <td class="text-center">{{ $user->priklady->sum('pivot.points') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-2 w-100">
            <a href="{{ route('teacher.export-csv') }}" class="btn btn-light py-2 px-3 mt-2 mb-3 mr-auto"
               style="background: lightsteelblue">
                {{ __('teacher-dashb.csv-butt')  }}
            </a>
        </div>



        <script>
            let table2 = new DataTable('#students');
        </script>

        <script type="text/javascript">
            document.getElementById('stud-t').style.color = 'whitesmoke';

            var urll = "{{ route('changeLang') }}";
            $(".changeLang").change(function(){
                window.location.href = urll + "?lang="+ $(this).val();
            });
        </script>
    @endif


@endsection
