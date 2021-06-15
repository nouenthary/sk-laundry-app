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
        return view('customer.index');
    }

    //get customers
    public function getCustomer(){
        $customers = Customer::where('status','enable')->get();
        return \DataTables::of($customers)
            ->addColumn('Actions', function($customers) {
                return
                    '<button type="button" class="btn btn-primary btn-xs" id="btn-edit" data-id="'.$customers->id.'"><i class="fa fa-pencil"></i></button>
                    <button type="button" data-id="'.$customers->id.'" class="btn btn-danger btn-xs" id="btn-remove"><i class="fa fa-minus"></i></button>';
            })
            ->rawColumns(['Actions'])
            ->make(true);
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
        $customers = Customer::find($id);

        if (!isset($customers)) {
            return ['error' => "customer id find not found."];
        }
        return $customers;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
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
            ->where('id',$id)
            ->update([
                'name' => $request->get('name'),
                'phone' => $request->get('phone'),
                'address' => $request->get('address')
            ]);

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
            ->update(['status' => 'disable']);

        return ['message' => 'customer is deleted.'];
    }

    // get customer and phone
    public function GetCustomerNameAndPhone(){
        $customer = DB::select("select id, name, phone from customers where status ='enable'");
        return $customer;
    }
}
