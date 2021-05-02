<?php

namespace App\Http\Controllers;

use App\Models\InvoiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use \Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = DB::table('invoice_details')->where('status', '!=', 'Reject');

        return response()->json(['data' => $orders->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invoiceId = DB::table('invoices')->insertGetId(
            array(
                'date' => DB::raw('CURRENT_DATE'),
                'time' => DB::raw('CURRENT_TIMESTAMP'),
                'user_id' => Auth::id(),
                'total' => '0',
                'received_riel' => '0',
                'received_dollar' => '0',
                'total_riel' => '0',
                'status' => 'Pending',
                'pay_by' => 'No',
                'print' => 'f',
                'pay_status' => 'Pending',
                'created_at' => DB::raw('CURRENT_TIMESTAMP'),
                'updated_at' => DB::raw('CURRENT_TIMESTAMP')
            )
        );


        $commissions = $this->GetCommission();

        $orders = $request->get('order');

        $date = Carbon::now()->toDateString();

        $time = Carbon::now()->toTimeString();


        for ($i = 0; $i < count($orders); $i++) {

            $service = $this->GetService($orders[$i]['service_id']);

            $orders[$i]['price'] = $service->price;
            $orders[$i]['discount'] = $service->discount;

            $total = 0;
            if ($service->unit_type == 'Kg') {
                $total = $orders[$i]['weight'] * $service->price;
            } else if ($service->unit_type == 'Pcs') {
                $total = $orders[$i]['qty'] * $service->price;
            }

            $grand_total = $total;

            if ($orders[$i]['discount'] > 0) {
                $grand_total = $total - ($total * $orders[$i]['discount'] / 100);
            }

            $orders[$i]['total'] = $grand_total;
            $orders[$i]['date'] = $date;
            $orders[$i]['time'] = $time;
            $orders[$i]['status'] = 'Pending';
            $orders[$i]['customer_id'] = $request->get('customer_id');
            $orders[$i]['user_id'] = Auth::id();
            $orders[$i]['percent_commission'] = $commissions;
            $orders[$i]['commission'] = $commissions > 0 ? $commissions * $grand_total / 100 : 0;
            $orders[$i]['invoice_id'] = $invoiceId;
            $orders[$i]['created_at'] = Carbon::now()->toDateTimeString();
            $orders[$i]['updated_at'] = Carbon::now()->toDateTimeString();

            InvoiceDetail::create($orders[$i]);
        }

        return response()->json($orders);
    }

    // commission %
    private function GetCommission()
    {
        $commission = DB::table('commissions')->where('user_id', Auth::id())->first();

        $percent = 0;
        if (isset($commission->percent)) {
            $percent = $commission->percent;
        }

        return $percent;
    }

    // service
    private function GetService($id)
    {
        return DB::table('services')->where('id', $id)->first();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = InvoiceDetail::where('id', $id)->first();

        if ($order) {
            $order->status = 'Reject';
            $order->user_id = Auth::id();
            $order->save();

            return response()->json(['message' => 'order id was delete.']);
        }

        return response()->json(['error' => 'order id not found.'],404);
    }
}
