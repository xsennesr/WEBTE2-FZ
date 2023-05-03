@extends('layout.layout-default')

@section('content')
    <div>
        <div class="">
            <div class="flex mx-auto justify-center">
                <form action="{{ route('upload.zip') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col mx-auto max-w-fit rounded-md p-3 my-2 bg-slate-300 ">
                        <label for="my-file">Nahraj sadu prikladov!</label>
                        <input type="file" name="my-file" class="mb-1">
                        <hr>
                    </div>
                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Button
                    </button>
                </form>
            </div>
        </div>
    </div>
    @if (isset($parsedZip))
        <div>
            @foreach ($parsedZip as $priklad)
                <div class="bg-gray-300 p-3 m-10 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4">Batch Name:</h2>
                    <p class="mb-4">{{$priklad['batch_name']}}</p>

                    <h2 class="text-xl font-bold mb-4">Task Name:</h2>
                    <p class="mb-4">{{$priklad['taskName']}}</p>

                    <h2 class="text-xl font-bold mb-4">Task:</h2>
                    <p class="mb-4">{{$priklad['task']}}</p>

                    <h2 class="text-xl font-bold mb-4">Image:</h2>
                    <p>{{$priklad['image']}}</p>

                    <h2 class="text-xl font-bold mb-4">Solution:</h2>
                    <p>{{$priklad['solution']}}</p>
                </div>
            @endforeach
        </div>
    @endif
@endsection
