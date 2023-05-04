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
    public function updateTask(Request $request)
    {
        return back()->with('success', 'Priklady uspesne ulozene!');
    }
}
