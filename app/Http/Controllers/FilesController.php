<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Files; 
use Validator;
class FilesController extends Controller
{
    public function index()
    {
        $datas = Files::all();
        return response()->json(['status'=>'success','datas'=>$datas],200);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[ 
            'file' => 'required|mimes:doc,docx,pdf,txt,csv,jpeg,jpg,png|max:2048',
        ]);

        if($validator->fails()) {   
            return response()->json(['error'=>$validator->errors()], 401);                        
         } 

        if ($file = $request->file('file')) {
            $path = $file->store('public/files');
            $name = $file->getClientOriginalName();
  
            $save = new Files();
            $save->title = $file;
            $save->file= $path;
            $save->save();
              
            return response()->json([
                "success" => true,
                "message" => "Dosya başarıyla yüklendi",
                "file" => $name
            ]);
  
        }
    }
}
