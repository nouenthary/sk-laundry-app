<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class UploadController extends Controller
{
    public function Upload(Request $request){       
        $file_name = '';
        
        if($request->hasFile('file')){
            
            $validator = Validator::make($request->all(),[
                'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',                
            ]);   

            if($validator->fails()){                
                return $validator;
            }

            $file_name = $request->file('file')->store('public/products'); 
            $file_name = explode('/',$file_name)[2];          
        }     

        return $file_name;
    }
}
