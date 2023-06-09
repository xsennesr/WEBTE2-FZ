<?php

namespace App\Http\Controllers;

use App\Models\MathBatch;
use App\Models\MathTask;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RecursiveIteratorIterator;
use SplFileInfo;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;
use ZipArchive;

class ZipController extends Controller
{
    public function uploadFile(Request $request)
    {
        $request->validate([
            'my-file' => 'required|mimes:zip,tex'
        ]);
        $file = $request->file('my-file');
        $name = $file->getClientOriginalName();

        Storage::putFileAs('public', $file, $name);
        if ($this->parseAndUpload('storage/' . $name)) {
            return back()->with('success', __('messages.mess1-file'));
        } else {
            return back()->with('error', __('messages.err1-file'));
        }
    }
    private function parseAndUpload($name)
    {
        $tmpDirName = 'tmpForLatex/';
        $zip = new ZipArchive();
        $extractPath = public_path($tmpDirName);
        if (!File::isDirectory($extractPath)) {
            File::makeDirectory($extractPath, 0711, true, true);
        }
        $contentOfLatex = array();
        $pathToImages = array();
        if ($zip->open($name) === true) {
            $zip->extractTo($extractPath);
            $zip->close();
            $filesToRead = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($tmpDirName, recursiveDirectoryIterator::SKIP_DOTS));
        }
        else {
            $filesToRead = array(new SplFileInfo($name));
        }

        foreach ($filesToRead as $file) {
            if ($file->isDir() || $file->getExtension() !== 'tex') {
                $pathToImages[basename($file->getPathname(), $file->getExtension()) . $file->getExtension()] = [$file->getPathname(), $file->getExtension()];
                continue;
            }
            array_push($contentOfLatex, [
                'content' => File::get($file->getPathname()),
                'batch_name' => basename($file, '.tex')
            ],);
        }

        $regexSections = "/\\\\section\\*?\\{[^{}]*\\}\\s*(?:.|\\n)*?\\\\end\\{solution\\}/s";
        $regexTask = "/\\\\begin\\{task\\}\\s*(.*?)\s*\\\\end\\{task\\}/s";
        $regexSolution = "/\\\\begin\\{solution\\}\\s*(.*?)\s*\\\\end\\{solution\\}/s";
        $regexTaskNames = "/(?<=\\\\section\\*\\{)[^{}]+(?=\\})/s";
        $regexTaskImages = "/(?<=\\\\includegraphics\\{)[^{}]+(?=\\})/s";
        $regexRemoveInclude = "/\\\\includegraphics\\{[^\}]*\\}\s*/";

        $matchesSection = array();
        $matchesTask = array();
        $matchesSolution = array();
        $matchesTaskNames = array();
        $matchesTaskImages = array();
        foreach ($contentOfLatex as $file) {
            preg_match_all($regexSections, $file['content'], $fileMatches);
            array_push($matchesSection, [
                'content' => $fileMatches[0],
                'batch_name' =>  $file['batch_name']
            ]);
        }


        $finalArray = array();
        foreach ($matchesSection as $file) {
            try {
                $batch = MathBatch::create([
                    'name' =>  $file['batch_name'],
                ]);
            } catch (\Throwable $th) {
                //throw $th;
            }
            foreach ($file['content'] as $section) {
                preg_match($regexTask, $section, $matchesTask);
                preg_match($regexSolution, $section, $matchesSolution);
                preg_match($regexTaskNames, $section, $matchesTaskNames);
                preg_match($regexTaskImages, $section, $matchesTaskImages);
                $matchesTask[1] =  preg_replace($regexRemoveInclude, "", $matchesTask[1]);
                $base64Image = null;
                if (isset($matchesTaskImages[0])) {
                    preg_match('/[^\/]+\.[a-z]+$/i', $matchesTaskImages[0], $test);
                    if (isset($pathToImages[$test[0]])) {
                        $content = file_get_contents(public_path($pathToImages[$test[0]][0]));
                        $base64Image = 'data:image/' . $pathToImages[$test[0]][1] . ';base64,' . base64_encode($content);
                    }
                }

                array_push($finalArray, [
                    "batch_name" => $file['batch_name'],
                    "taskName" => $matchesTaskNames[0],
                    "task" => $matchesTask[1],
                    "image" => $base64Image,
                    "solution" => $matchesSolution[1],
                ]);
                try {
                    $task = MathTask::create([
                        "task_name" => $matchesTaskNames[0],
                        "task" => $matchesTask[1],
                        "image" => $base64Image,
                        "solution" => $matchesSolution[1],
                        'batch_id' => $batch->id,
                    ]);
                } catch (\Throwable $th) {
                }
            }
        }
        File::delete($name);
        File::deleteDirectory($tmpDirName);
        return $finalArray;
    }
}
