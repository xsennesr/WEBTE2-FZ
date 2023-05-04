<?php

namespace App\Http\Controllers;

use App\Models\MathTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RecursiveIteratorIterator;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;
use ZipArchive;

class ZipController extends Controller
{
    public function uploadFile(Request $request)
    {
        //TODO umoznit nahrat samotny .tex subor
        $request->validate([
            'my-file' => 'required|mimes:zip'
        ]);
        $file = $request->file('my-file');
        $name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $newName = time() . '_' . uniqid() . '.' . $extension;

        Storage::putFileAs('public', $file, $newName);
        if($this->parseAndUpload('storage/' . $newName)) {
            return back()->with('success', 'Priklady uspesne ulozene!');
        } else {
            return back()->with('error', 'Nastala chyba');
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
        $pathToFiles = array();
        $pathToImages = array();
        if ($zip->open($name) === true) {
            $zip->extractTo($extractPath);
            $zip->close();
            $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($tmpDirName, recursiveDirectoryIterator::SKIP_DOTS));
            foreach ($rii as $file) {
                if ($file->isDir() || $file->getExtension() !== 'tex') {
                    continue;
                }
                array_push($contentOfLatex, [
                    'content' => File::get($file->getPathname()),
                    'batch_name' => basename($file, '.tex')
                ], );
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

            // dd(file_get_contents(public_path("/storage/tmpForLatex/images/blokovka01_00002.jpg")));


            $finalArray = array();
            foreach ($matchesSection as $file) {
                foreach($file['content'] as $section) {
                    preg_match($regexTask, $section, $matchesTask);
                    preg_match($regexSolution, $section, $matchesSolution);
                    preg_match($regexTaskNames, $section, $matchesTaskNames);
                    preg_match($regexTaskImages, $section, $matchesTaskImages);
                    $matchesTask[1] =  preg_replace($regexRemoveInclude, "", $matchesTask[1]);
                    $base64Image = null;
                    if(isset($matchesTaskImages[0])){
                        preg_match('/[^\/]+\.[a-z]+$/i',$matchesTaskImages[0],$test);
                        if(isset($pathToImages[$test[0]])){
                            $content = file_get_contents(public_path($pathToImages[$test[0]][0]));
                            $base64Image = 'data:image/'.$pathToImages[$test[0]][1].';base64,'.base64_encode($content);
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
                        MathTask::create([
                            "batch_name" => $file['batch_name'],
                            "task_name" => $matchesTaskNames[0],
                            "task" => $matchesTask[1],
                            "image" => $base64Image,
                            "solution" => $matchesSolution[1],
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
}
