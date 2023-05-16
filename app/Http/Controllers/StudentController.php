<?php

namespace App\Http\Controllers;

use App\Models\MathBatch;
use App\Models\MathTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use PDF;

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

    public function introduction(){
        return view('introduction-student.dashboard');
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
        $command = 'python3 ' . base_path('app/bin/compare.py') . ' ' . escapeshellarg($user_solution) . ' ' . escapeshellarg($solution);
        //todo nainstalujte si python, pip install sympy a to asi staci i guess, keby nie skuste si to spustit v cmd ten script
        // Execute the command and capture the output
        $output = [];
        $return_var = -1;
        exec($command, $output, $return_var);

        // Check the return value to see if the command was successful
        if ($return_var == 0) {
            $result = trim($output[0]); // Get the result from the output
            $points = 0;
            $result = filter_var($result,FILTER_VALIDATE_BOOLEAN);
            if($result){
                  $points = $max_points;
            }
            Auth::user()->priklady()->updateExistingPivot($task->id, [
                'result' => $result,
                'user_solution' => $user_solution,
                'submitted' => true,
                'points' => $points
            ]);
        }
        return back();
    }

    public function generatePDF()
    {
        $data = [];

        $pdf = PDF::loadView('introduction-student.studentContent', $data);

        return $pdf->download('StudentIntroduction.pdf');
    }
}
