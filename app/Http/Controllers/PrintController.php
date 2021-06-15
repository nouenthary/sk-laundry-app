<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgentInvoiceDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Config;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PrintController extends Controller
{
    public function print($id)
    {
        //$orders_id = Crypt::decrypt($id);

        $invoice = DB::table('agent_invoices')
        ->where('id',$id)
        ->first();

        $agent_invoices = DB::table('agent_invoice_details')
        ->where('agent_invoice_id', $id)
        ->where('status','!=','Reject')
        ->get();

        $phone = DB::table('configs')
        ->where('key','phone')
        ->select('value')
        ->first();

        $address = DB::table('configs')
        ->where('key','address')
        ->select('value')
        ->first();

        $note = DB::table('configs')
        ->where('key','noted')
        ->select('value')
        ->first();

        $agent = DB::table('agents')
        ->where('id',$invoice->agent_id)
        ->first();

        $rate = DB::table('configs')
        ->where('key','currency')
        ->select('value')
        ->get();

        $amount_dollar = $invoice->amount / 4100;

        $sum_qty = DB::table('agent_invoice_details')
        ->where('agent_invoice_id', $id)
        ->where('status','!=','Reject');

        $data = [
            'data' => $agent_invoices,
            'phone' => $phone,
            'address' => $address,
            'note' => $note,
            'date' => date("Y-m-d"),
            'invoice' => $id,
            'customer' => $agent,
            'amount' => $invoice->amount,            
            'sum_qty' => $sum_qty->sum('qty'),
            'sum_weight' => $sum_qty->sum('weight'),
            'qrCode' => QrCode::size(54)->generate('Thary') 
        ];
        //$qrCode = QrCode::size(200)->generate('W3Adda Laravel Tutorial'); 
        //return $qrCode;
        return view('print.invoice',$data);
    }
}
