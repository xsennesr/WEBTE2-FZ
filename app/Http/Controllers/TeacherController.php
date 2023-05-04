<?php

namespace App\Http\Controllers;

use App\Models\MathTask;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $priklady = MathTask::all();
        return view('teacher.dashboard', ['priklady'=> $priklady]);
    }

    public function editTask($id)
    {
        $priklad = MathTask::where('id', $id)->first();
       // dd($priklad);
        return view('teacher.edit-task', ['priklad' => $priklad]);
    }
    public function updateTask(Request $request, $id)
    {
        $task = MathTask::findOrFail($id);
        $task->batch_name = $request->input('batch_name');
        $task->task_name = $request->input('task_name');
        $task->task = $request->input('task');
        $task->image = MathTask::imageToBase64($request->file('image')) ?? $request->input('image-base64');
        $task->solution = $request->input('solution');
        $task->max_points = $request->input('max_points');
        $task->available = boolval($request->input('available'));
        $task->publishing_at = $request->input('publishing_at');
        $task->closing_at = $request->input('closing_at');
        if($task->save()) {
             return back()->with('success', 'Priklad uspesne zmeneny!');
        } else {
            return back()->with('success', 'Priklad sa nepodarilo zmenit');
        }
    }
}
