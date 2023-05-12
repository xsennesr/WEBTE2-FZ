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
        return view('student.dashboard', ['batches' => $availableBatches, 'tasks' => Auth::user()->priklady]);
    }
    public function generateTask(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $selectedBatches = $request->input('selected-batch', []);
        if (!$selectedBatches) {
            return back()->with('error', __('messages.err1-batch') );
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
            return back()->with('error', __('messages.err2-batch'));
        }
        $user->priklady()->attach($randomTask->id);
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
        $task = MathTask::find($request->input('task_id'));
        $max_points = MathBatch::find($task->batch_id)->max_points;
        $regex = '/^\\s*\\\\begin\\{equation\\*\\}\\s*(.*)\\s*\\\\end\\{equation\\*\\}\\s*$/s';
        $replacement = '$1';
        $equation = preg_replace($regex, $replacement, $task->solution);
        $solution = rtrim($equation);
        $user_solution = $request->input('user-solution');

        // Define the command to execute the Python script
        $command = 'python ' . base_path('app/bin/compare.py') . ' ' . escapeshellarg($user_solution) . ' ' . escapeshellarg($solution);
        //todo nainstalujte si python, pip install sympy a to asi staci i guess, keby nie skuste si to spustit v cmd ten script
        // Execute the command and capture the output
        $output = [];
        $return_var = -1;
        exec($command, $output, $return_var);

        // Check the return value to see if the command was successful
        if ($return_var == 0) {
            $result = trim($output[0]); // Get the result from the output
            if ($result == 0) $result_points = $max_points;
            else $result_points = 0;
            Auth::user()->priklady()->updateExistingPivot($task->id, [
                'result' => filter_var($result, FILTER_VALIDATE_BOOLEAN), //cast to boolean
                'user_solution' => $user_solution,
                'submitted' => true,
                'points' => $result_points
            ]);
        }
        return back();
    }
}
