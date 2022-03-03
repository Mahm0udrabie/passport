<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class UploadFileController extends Controller
{
     public function uploadFile(Request $request) {
        $validator = Validator::make($request->all(),[
            'file' => 'required|mimes:doc,docx,pdf,txt,csv,jpg,png,jpeg,gif|max:2048',
      ]);

      if($validator->fails()) {

          return response()->json(['error'=>$validator->errors()], 401);
       }


      if ($file = $request->file('file')) {
          $path = $file->store('public/files');
          $name = $file->getClientOriginalName();

          //store your file into directory and db
          $save = new File();
          $save->name = Carbon::now()->timestamp. basename($path);
          $save->path= $path;
          $save->save();

          return response()->json([
              "success" => true,
              "message" => "File successfully uploaded",
              "file" =>  $path,
              "all_files" => $this->getFile()
          ]);
        }
     }
     public function getFile() {
       return File::all();
    }
    public function getFileBYId($fileID) {
        $file = File::where('id', $fileID)->first();
        // dd($file);
        $path = storage_path().'/'.'app'.'/files/'.basename($file->path);
        if (file_exists($path)) {
            return Response::download($path);
        }
    }
}
