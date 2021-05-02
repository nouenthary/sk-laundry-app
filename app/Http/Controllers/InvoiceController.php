<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\User;
use Validator;
use JWTAuth;

class InvoiceController extends Controller
{
     /**
     * Create a new InvoiceController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $users = DB::table('users')->get();
        return response()->json(['message'=> $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invoiceId = DB::table('invoices')->insertGetId(
            array(
                'date' => DB::raw('CURRENT_DATE'),
                'time' => DB::raw('CURRENT_TIMESTAMP'),
                'user_id' => Auth::id(),
                'total' => '12',
                'received_riel' => '5000',
                'received_dollar' => '8',
                'total_riel' => '50000',
                'status' => 'Pending',
                'pay_by' => 'No',
                'print' => 'f',
                'pay_status' => 'pending',
                'created_at' => DB::raw('CURRENT_TIMESTAMP')                
                )
        );

        return Auth::id();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
