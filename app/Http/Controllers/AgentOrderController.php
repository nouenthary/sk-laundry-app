<?php

namespace App\Http\Controllers;

use App\Models\AgentInvoice;
use App\Models\AgentInvoiceDetail;
use App\Models\Agent;
use App\Models\Category;
use App\Models\Service;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AgentOrderController extends Controller
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

    // get all agent orders
    public function getAllAgentOrder(){
        $data = AgentInvoice::where('status','!=','Reject')->get();
        return \DataTables::of($data)        
            ->addColumn('Date',function($data){
                return $data->date.' '.$data->time;
            })
            ->addColumn('Status',function($data){               
                if($data->status == 'Done'){
                    return '<label class="label label-success">'.$data->status.'</label>';    
                }
                return '<label class="label label-primary">'.$data->status.'</label>';          
            })
            ->addColumn('Actions', function($data) {
                return
                    '<a href="/orders/order_id/'.Crypt::encrypt($data->id).'" class="btn btn-primary btn-xs btn-flat" id="btn-edit" data-id="'.$data->id.'"><i class="fa fa-pencil"></i></a>
                    <a href="/print/'.$data->id.'" target="_blank" class="btn btn-default btn-xs btn-flat" id="btn-remove"><i class="fa fa-print"></i></a>';
            })
            ->addColumn('Total',function($data){
                return '$ '.$data->total;
            })
            ->addColumn('User_ID',function($data){
                $user_id = (int) $data->user_id;
                return User::find($user_id)->username;
            })
            ->rawColumns(['Date','Status','Total','User_ID','Actions'])                      
            ->make(true);
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

        $products = Product::where('status','t')->get();

        $service = Service::where('status','t')->where('type','Agent')->get();

        $agent_invoices = AgentInvoiceDetail::where('agent_invoice_id',$orders_id)
            ->join('products','agent_invoice_details.product_id','=','products.id')
            ->join('services','agent_invoice_details.service_id','=','services.id')
            ->where('agent_invoice_details.status','!=','Reject');

        $sum_row = DB::table('agent_invoice_details')
            ->where('agent_invoice_id',$orders_id)
            ->where('status','!=','Reject')
            ->sum('total');

        $data = [
            'agents' => $agents,
            'service' => $service,
            'agent_invoice_id' => $orders_id,
            'agent_invoices' => $agent_invoices
                ->select(
                'agent_invoice_details.*',
                'services.id as sid',
                'services.service_name',
                'products.id as pid',
                'products.product_name'
            )->get(),
            'total_row' => $sum_row,
            'agent_id' => $exist->agent_id,
            'products' => $products,
            'status' => $exist->status
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
        $exist = DB::table('agent_invoice_details')
        //->where('category_id',$request->get('category_id'))
        ->where('product_id',$request->get('product_id'))
        ->where('service_id',$request->get('service_id'))
        ->where('status', '!=', 'Reject')
        ->where('agent_invoice_id',$request->get('agent_invoice_id'))
        ->first();

        if(isset($exist)){
            return ['error' => 'order item has exist please modify.'];
        }

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
        $order->commission = $commissions > 0 ? $commissions * $grand_total / 100 : 0;
        $order->percent_commission = $commissions;

        $order->save();

        $this->SumInvoice($request->get('agent_invoice_id'));

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
        $data = AgentInvoiceDetail::find($id);
        if(!isset($data)){
           return ['error' => 'id not found.'];
        }
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        $data = AgentInvoiceDetail::find($id);

        if(!isset($data)){
            return ['error'=>'id not found.'];
        }

        $exist = DB::table('agent_invoice_details')
        ->where('product_id',$request->get('product_id'))
        ->where('service_id',$request->get('service_id'))
        ->where('status', '!=', 'Reject')
        ->where('id','!=',$id)
        ->where('agent_invoice_id',$data->agent_invoice_id)
        ->first();

        if(isset($exist)){
            return ['error' => 'order item has exist please modify.'];
        }

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

        $data->product_id = $request->get('product_id');
        $data->service_id = $request->get('service_id');
        $data->qty = $request->get('qty');
        $data->weight = $request->get('weight');
        $data->total = $grand_total;
        $data->commission = $commissions > 0 ? $commissions * $grand_total / 100 : 0;

        $data->save();

        $this->SumInvoice($data->agent_invoice_id);

        return ['message' => 'order item update successfully.'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = AgentInvoiceDetail::find($id);

        if(!isset($data)){
            return ['error' => 'id not found.'];
        }

        $data->status = "Reject";

        $data->save();

        $this->SumInvoice($data->agent_invoice_id);

        return ['message' => 'item remove successfully.'];
    }

    // set agent id to invocie
    public function setaAgentToInvoice(Request $request)
    {
        $data = AgentInvoice::find($request->agent_invoice_id);

        if(!isset($data)){
            return ['error' => 'agent invocie id not found.'];
        }

        $data->agent_id = $request->agent_id;

        $data->save();

        DB::update('update agent_invoice_details set agent_id = ? where agent_invoice_id = ?', [$request->agent_id,$request->agent_invoice_id]);

        return ['message' => 'set agent id to invoice successfully.'];
    }

    // sum invoice
    public function SumInvoice($agent_invoice_id)
    {
        $agent_invoice = AgentInvoice::find($agent_invoice_id);

        $sum = DB::table('agent_invoice_details')
            ->where('agent_invoice_id', $agent_invoice_id)
            ->where('status','!=','Reject')
            ->sum('total');

        $agent_invoice->amount = $sum;

        $agent_invoice->save();
    }

    // payment
    public function payment(Request $request)
    {
        $agent_invoice = AgentInvoice::find($request->get('order_id'));

        if($request->get('amount_riel') < $agent_invoice->amount){
            return ['error' => 'can`t payment'];
        }

        $agent_invoice->status = 'Done';

        $agent_invoice->pay_by = 'Cash';

        $agent_invoice->pay_status = 'Done';

        $agent_invoice->total = $request->get('amount_riel');

        $agent_invoice->received_riel = $request->get('amount_riel');

        $agent_invoice->save();

        //
        DB::table('agent_invoice_details')
        ->where('agent_invoice_id',$request->get('order_id'))
        ->where('status','!=','Reject')
        ->update(array('status'=>'Done'));

        return ['message' => 'Payment successfully.'];
    }
}
