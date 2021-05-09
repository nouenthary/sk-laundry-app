<?php

namespace App\Http\Controllers;

use App\Models\AgentInvoice;
use App\Models\AgentInvoiceDetail;
use App\Models\Agent;
use App\Models\Category;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AgentInvoice::where('status','!=','Reject')->get();

        $data = [
            'data' => $data
        ];

        return view('orders.index', $data);
    }

    public function numberPad($number, $n)
    {
        return str_pad((int) $number, $n, "0", STR_PAD_LEFT);
    }

    public function GetInvoice(){

        $order_id = DB::select('SELECT invoice_no
                                     FROM "agent_invoices"
                                     WHERE id = (SELECT max(id) from "agent_invoices")');

        if(count($order_id) == 0){
            return 1;
        }

        $order_id = $order_id[0]->invoice_no + 1;

        return $order_id;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $order_id = $this->GetInvoice();

        $invoiceId = DB::table('agent_invoices')->insertGetId(
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
                'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
                'amount'=> '0',
                'invoice_no' => $this->numberPad($order_id,"6")
            )
        );

        $encrypt = Crypt::encrypt($invoiceId);

        return redirect("orders/order_id/". $encrypt);
    }

    public function add($order_id){

        $orders_id = Crypt::decrypt($order_id);

        $exist = AgentInvoice::where('id',$orders_id)->first();

        if(!isset($exist)){
            return redirect()->back();
        }


        $agents = Agent::where('status','Enable')->get();

        $categories = Category::where('status','t')->get();

        $service = Service::where('status','t')->where('type','Agent')->get();

        $agent_invoices = AgentInvoiceDetail::where('agent_invoice_id',$orders_id)
            ->join('categories','agent_invoice_details.category_id','=','categories.id')
            ->join('products','agent_invoice_details.product_id','=','products.id')
            ->join('services','agent_invoice_details.service_id','=','services.id')
            ->where('agent_invoice_details.status','!=','Reject');

        $data = [
            'categories' => $categories,
            'agents' => $agents,
            'service' => $service,
            'agent_invoice_id' => $orders_id,
            'agent_invoices' => $agent_invoices
                ->select(
                'categories.id as cid',
                'categories.category_name',
                'agent_invoice_details.*',
                'services.id as sid',
                'services.service_name',
                'products.id as pid',
                'products.product_name'
            )->get(),
            'total_row' => 0,
        ];


        return view('agent.order', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = Carbon::now()->toDateString();

        $time = Carbon::now()->toTimeString();

        $commissions = $this->GetCommission();

        $service = $this->GetService($request->get('service_id'));

        $total = 0;
        if ($service->unit_type == 'Kg') {
            $total = $request->get('weight') * $service->price;
        } else if ($service->unit_type == 'Pcs') {
            $total = $request->get('qty') * $service->price;
        }

        $grand_total = $total;

        if ($service->discount > 0) {
            $grand_total = $total - ($total * $service->discount / 100);
        }

        $order = new AgentInvoiceDetail();
        $order->category_id = $request->get('category_id');
        $order->product_id = $request->get('product_id');
        $order->service_id = $request->get('service_id');
        $order->qty = $request->get('qty');
        $order->weight = $request->get('weight');
        $order->price = $service->price;
        $order->discount = $service->discount;
        $order->total = $grand_total;
        $order->agent_invoice_id = $request->get('agent_invoice_id');
        $order->user_id = Auth::id();
        $order->date = $date;
        $order->time = $time;
        $order->status = 'Pending';
        $order->agent_id = $request->get('agent_id');
        $order->commission = $commissions > 0 ? $commissions * $grand_total / 100 : 0;;
        $order->percent_commission = $commissions;

        $order->save();

        return ['message' => 'Item was added.'];
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        return $id;
    }
}
