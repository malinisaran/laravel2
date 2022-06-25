<?php

namespace App\Http\Controllers;
use App\Http\Controllers;
use App\Models\File;
use Validator; 

use Illuminate\Http\Request;

class APIFileUploadController extends Controller
{
    public function upload(Request $request)
    {
 
       $validator = Validator::make($request->all(),[ 
        'file'  => 'required|mimes:png,jpg,jpeg,gif|max:2048',
        ]);   
 
        if($validator->fails()) {          
            
            return response()->json(['error'=>$validator->errors()], 401);                        
         }  
 
  
        if ($file = $request->file('file')) {
            $path = $file->store('public/files');
            $name = $file->getClientOriginalName();
 
            //store your file into directory and db
            $save = new File();
            $save->name = $file;
            $save->store_path= $path;
            $save->save();
              
            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
                "file" => $file
            ]);
  
        }
 
  
    }
}

