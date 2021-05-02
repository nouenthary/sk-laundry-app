<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;
    /**
     * login api
     *
     * @return Response
     */
    public function login(){
        if(Auth::attempt(['username' => request('username'), 'password' => request('password')])){
            $user = Auth::user();
            $token = $user->createToken('SK_API')-> accessToken;
            return response()->json(
                ['token' => $token, 'user' => $user],
                $this-> successStatus
            );
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    /**
     * Register api
     *
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $this->AddCommission($user->id);

        $success['token'] =  $user->createToken('SK_API')-> accessToken;

        return response()->json(['success'=>$success , 'user' => $user], $this-> successStatus);
    }

    // add commission
    public function AddCommission($user_id){
        DB::table('commissions')->insert([
            'user_id' => $user_id,
            'percent' => 0,
            'user_update' => Auth::id(),
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);
    }
    /**
     * details api
     *
     * @return Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }
}
