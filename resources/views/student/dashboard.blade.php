@extends('layout.layout-default')

@section('content')
    <div class="flex justify-center mx-auto text-2xl m-10">
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


    </div>
@endsection
