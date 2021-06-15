<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;

class LoginController extends Controller
{
    public function index(){
        return view('login.index');
    }

    public function login(Request $request){

        $user = array(
            'username' => $request->get('username') ,
            'password' => $request->get('password')
        );

        if (Auth::attempt($user))
        {
            return redirect('/');
        }
        else
        {
            return redirect()->back();
        }
    }

    // logout
    public function logout(Request $request) {
        Auth::logout();
        return redirect('/signin');
    }

    // user profile
    public function changeProfile(){
        return view('login.profile');
    }

    //update password
    public function updatePassword(Request $request){                

        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required',
        ]);

        $hashedPassword = Auth::user()->password;
        
        $old_password = $request->get('old_password');
        $new_password = $request->get('new_password');    
        
        if(Hash::check($old_password, $hashedPassword)){
            if(!Hash::check($new_password, $hashedPassword)){
                $users = User::find(Auth::user()->id);
                $users->password = bcrypt($request->new_password);
                User::where( 'id' , Auth::user()->id)->update( array( 'password' =>  $users->password));

                session()->flash('message','your password updated');
                return redirect()->back();
            }
            else {
                session()->flash('message','new password can not be the old password!');
                return redirect()->back();
            }
        }
        else {
            session()->flash('message','old password doesnt matched ');
            return redirect()->back();
        }          
    } 
    
    
    // change profile
    public function changePhoto(Request $request){
        $file_name = '';
        
        if($request->hasFile('file')){
            
            $validator = Validator::make($request->all(),[
                'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',                
            ]);   

            if($validator->fails()){                
                return $validator;
            }

            $file_name = $request->file('file')->store('public/profile'); 
            $file_name = explode('/',$file_name)[2];          
        }     

        $user = User::find(Auth::user()->id);

        $user->photo = $file_name;

        $user->save();

        return $file_name;
    }
}