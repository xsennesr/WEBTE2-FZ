<?php

namespace App\Http\Controllers;

use App\Models\MathBatch;
use App\Models\MathTask;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $sady = MathBatch::all();
        return view('teacher.dashboard', ['sady'=> $sady]);
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
        dd("asdad");
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
}
