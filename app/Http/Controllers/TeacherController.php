<?php

namespace App\Http\Controllers;

use App\Models\MathBatch;
use App\Models\MathTask;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $sady = MathBatch::all();
        $users = User::where('ucitel', false)->get();
        return view('teacher.dashboard', ['sady'=> $sady, 'users'=> $users]);
    }

    public function editTask($batch_id,$task_id)
    {
        $priklad = MathTask::where('id', $task_id)->first();
        return view('teacher.edit-task', ['priklad' => $priklad]);
    }

    public function editBatch($id){
        $sada = MathBatch::findOrFail($id);
        return view('teacher.edit-batch',[
            'priklady' => $sada->priklady,
            'sada' => $sada,
        ]);
    }

    public function updateBatch(Request $request,$id){

        $updated = MathBatch::findOrFail($id)->update([
            'name' => $request->input('batch_name'),
            'max_points' => $request->input('max_points'),
            'available' => boolval($request->input('available')),
            'publishing_at' => $request->input('publishing_at'),
            'closing_at' => $request->input('closing_at'),
        ]);
        if($updated) {
            return back()->with('success', 'Sada uspesne zmenena!');
       } else {
           return back()->with('error', 'Sadu sa nepodarilo zmenit');
       }
    }


    public function updateTask(Request $request, $id)
    {
        $task = MathTask::findOrFail($id);
        $updated = $task->update([
            'task_name' => $request->input('task_name'),
            'task' => $request->input('task'),
            'image' => MathTask::imageToBase64($request->file('image')) ?? $request->input('image-base64'),
            'solution' => $request->input('solution'),
        ]);
        if($updated) {
             return back()->with('success', 'Priklad uspesne zmeneny!');
        } else {
            return back()->with('error', 'Priklad sa nepodarilo zmenit');
        }
    }

    public function exportCsv()
    {
        $users = User::where('ucitel', false)->get();
        $csvFileName = 'students.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        $handle = fopen('php://temp', 'w');
        $bom = chr(0xEF) . chr(0xBB) . chr(0xBF);
        fwrite($handle, $bom);
        fputcsv($handle, ['Meno', 'ID', 'Vygenerované', 'Odovzdané', 'Počet bodov'], ';');
        foreach ($users as $user) {
            fputcsv($handle, [
                $user->name,
                $user->id,
                0,
                0,
                $user->priklady->sum('pivot.points')
            ], ';');
        }
        fseek($handle, 0);
        $csvContent = stream_get_contents($handle);
        fclose($handle);
        $response = Response::make($csvContent, 200, $headers);
        return $response;
    }
}
