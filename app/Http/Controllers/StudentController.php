<?php

namespace App\Http\Controllers;

use App\Models\MathBatch;
use App\Models\MathTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function dashboard()
    {
        $availableBatches = MathBatch::where('available', true)->get();
        return view('student.dashboard', ['batches' => $availableBatches]);
    }
    public function generateTask(Request $request)
    {
        /* $user = Auth::id();
        $selectedBatches = $request->input('selected-batch', []);
        //Eloquent by chatgpt. not tested.
        $randomTask = MathTask::whereIn('batch_id', $selectedBatches)
            ->whereNotIn('id', function ($query) use ($user) {
                $query->select('task_id')
                    ->from('user_task')
                    ->where('user_id', $user);
            })
            ->inRandomOrder()
            ->first();
        //TODO add $randomRow to junction table user_mathTasks.
        //  $user->priklady()->attach($randomTask->id);
        dd($randomTask); */
        //return back()->with();
    }
}
