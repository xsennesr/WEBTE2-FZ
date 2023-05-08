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

        $availableBatches = MathBatch::where(function ($query) use ($currentDate) {
            $query->where('available', true)
            ->orWhere(function ($query) use ($currentDate) {
                $query->where('available', false)
                ->where(function ($query) use ($currentDate) {
                    $query->whereNotNull('publishing_at')
                    ->where('publishing_at', '<=', $currentDate)
                        ->orWhereNotNull('closing_at');
                });
            });
        })
        ->where(function ($query) use ($currentDate) {
            $query->whereDate('closing_at', '>=', $currentDate)
            ->orWhereNull('closing_at');
        })
        ->get();
        //dd($availableBatches);
        $user = Auth::user();
        $userId = $user->id;;
        $user2 = User::find($userId);
        $generatedTasks = $user2->priklady()->get();
        //dd($generatedTasks);
        return view('student.dashboard', ['batches' => $availableBatches, 'tasks' => $generatedTasks]);
    }
    public function generateTask(Request $request)
    {
        //Vyzera ze funguje ale testoval som to tak 5minut iba
        $user = Auth::user();
        $userId = $user->id;;
        $user2 = User::find($userId);

        $selectedBatches = $request->input('selected-batch', []);
        $randomTask = MathTask::whereIn('batch_id', $selectedBatches)
            ->whereNotIn('id', function ($query) use ($userId) {
                $query->select('math_task_id')
                    ->from('user_math_task')
                    ->where('user_id', $userId);
            })
            ->inRandomOrder()
            ->first();
        if(!$randomTask) {
            return back()->with('error', 'Uz si si vygeneroval vsetky priklady z tejto sady!');
        }
        $user2->priklady()->attach($randomTask->id);
        return back();
    }
    public function renderTask($id)
    {
        $task = MathTask::find($id);
        return view('student.render-task', ['task'=>$task]);
    }
    public function submitTask(Request $request) {
        dd($request->input('user-solution'));
        return back()->with('error', 'Uz si si vygeneroval vsetky priklady z tejto sady!');
    }
}
