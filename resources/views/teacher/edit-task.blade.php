@extends('layout.layout-default')
@section('content')
<?php
//dd($priklad->id);
?>

    <form>
         <div class="mb-3">
            <label for="end-date" class="form-label">Sada prikladu</label>
            <input type="text" value="{{$priklad->batch_name}}">
        </div>
        <div class="mb-3">
            <label for="end-date" class="form-label">Nazov prikladu</label>
            <input type="text" value="{{$priklad->task_name}}">
        </div>
         <div class="mb-3">
            <label for="end-date" class="form-label">Task</label>
            <textarea name="" id="" cols="30" rows="10" value="">{{$priklad->task}}</textarea>
        </div>
        <div class="mb-3">
            <label for="end-date" class="form-label">Solution</label>
            <textarea name="" id="" cols="30" rows="10" value="">{{$priklad->solution}}</textarea>
        </div>
        <div class="mb-3">
            <label for="publish-date" class="form-label">Publish Date</label>
            <input type="datetime-local" class="form-control" id="publish-date" value="{{$priklad->publishing_at}}">
        </div>
        <div class="mb-3">
            <label for="end-date" class="form-label">End Date</label>
            <input type="datetime-local" class="form-control" id="end-date" value="{{$priklad->closing_at}}">
        </div>
        <div class="mb-3">
            <label for="max-points" class="form-label">Max Points</label>
            <input type="number" class="form-control" id="max-points" value="{{$priklad->points}}">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="publish-switch">
            <label class="form-check-label" for="publish-switch">Publish</label>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
