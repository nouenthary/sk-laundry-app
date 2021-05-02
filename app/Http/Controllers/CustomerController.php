<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $customers = DB::table('customers')->where('status', 'enable');

        if ($request->get('name') != '') {
            $customers->where('name', $request->get('name'));
        }
        if ($request->get('phone') != '') {
            $customers->where('phone', $request->get('phone'));
        }

        return ['data' => $customers->get()];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // check name
        $customer_name = Customer::where('name',$request->name)->where('status','enable')->first();
        if(isset($customer_name)){
            return ['error' => 'name is exist already.'];
        }
        // check phone
        $customer_phone = Customer::where('phone',$request->phone)->where('status','enable')->first();
        if(isset($customer_phone)){
            return ['error' => 'phone is exist already.'];
        }

        Customer::create($request->all());

        return response()->json(['message' => 'customer create successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $customers = DB::table('customers')->find($id);

        if (isEmpty($customers)) {
            return ['error' => "customer id find not found."];
        }
        return ['data' => $customers];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {
        // check name
        $customer_name = Customer::where('name',$request->name)
            ->where('status','enable')
            ->where('id','!=',$request->id)
            ->first();
        if(isset($customer_name)){
            return ['error' => 'name is exist already.'];
        }
        // check phone
        $customer_phone = Customer::where('phone',$request->phone)
            ->where('status','enable')
            ->where('id', '!=',$request->id)
            ->first();
        if(isset($customer_phone)){
            return ['error' => 'phone is exist already.'];
        }

        DB::table('customers')
            ->where('id', $request->get('id'))
            ->update($request->all());

        return ['message' => 'customer update successfully.'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $customers = Customer::where('id', $id)->get();

        if (!isset($customers)) {
            return ['error' => 'customer id not found.'];
        }

        DB::table('customers')
            ->where('id', $id)
            ->update(['status' => '0']);

        return ['message' => 'customer is deleted.'];
    }
}
