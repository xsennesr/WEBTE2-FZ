<?php

namespace App\Http\Controllers;

use App\Models\MathBatch;
use App\Models\MathTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class StudentController extends Controller
{
    public function dashboard()
    {
        $currentDate = date('Y-m-d');

        $query1 = MathBatch::whereNull('publishing_at')
            ->whereNull('closing_at')
            ->where('available', true)
            ->get();

        $query2 = MathBatch::whereNotNull('publishing_at')
            ->where('publishing_at', '<=', $currentDate)
            ->whereNull('closing_at')
            ->get();

        $query3 = MathBatch::whereNull('publishing_at')
            ->whereNotNull('closing_at')
            ->where('closing_at', '>=', $currentDate)
            ->get();

        $query4 = MathBatch::whereNotNull('publishing_at')
            ->where('publishing_at', '<=', $currentDate)
            ->whereNotNull('closing_at')
            ->where('closing_at', '>=', $currentDate)
            ->get();

        $availableBatches = array_merge($query1->toArray(), $query2->toArray(), $query3->toArray(), $query4->toArray());
        return view('student.dashboard', ['batches' => $availableBatches, 'tasks' => Auth::user()->priklady]);
    }
    public function generateTask(Request $request)
    {
        //Vyzera ze funguje ale testoval som to tak 5minut iba
        $user = Auth::user();
        $userId = $user->id;;
        $user2 = User::find($userId);

        $selectedBatches = $request->input('selected-batch', []);
        if (!$selectedBatches) {
            return back()->with('error', 'Vyber aspon jednu sadu');
        }
        $randomTask = MathTask::whereIn('batch_id', $selectedBatches)
            ->whereNotIn('id', function ($query) use ($userId) {
                $query->select('math_task_id')
                    ->from('user_math_task')
                    ->where('user_id', $userId);
            })
            ->inRandomOrder()
            ->first();
        if (!$randomTask) {
            return back()->with('error', 'Uz si si vygeneroval vsetky priklady z tejto sady!');
        }
        $user2->priklady()->attach($randomTask->id);
        return back();
    }
    public function renderTask($id)
    {
        $task = MathTask::find($id);
        $priklad = Auth::user()->priklady->firstWhere('pivot.math_task_id', $id)->pivot;
        return view('student.render-task', ['task' => $task, 'priklad' => $priklad]);
    }
    public function submitTask(Request $request)
    {
        dd($request->input('user-solution'));
        return back();
    }
}
