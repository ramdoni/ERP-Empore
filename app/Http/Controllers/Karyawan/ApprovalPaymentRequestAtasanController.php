<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApprovalPaymentRequestAtasanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params['data'] = \App\PaymentRequest::where('approved_atasan_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();    

        return view('karyawan.approval-payment-request-atasan.index')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function proses(Request $request)
    {
        $status = new \App\StatusApproval;
        $status->approval_user_id       = \Auth::user()->id;
        $status->jenis_form             = 'payment_request';
        $status->foreign_id             = $request->id;
        $status->status                 = $request->status;
        $status->save();    

        if(isset($request->nominal_approve))
        {
            foreach($request->nominal_approve as $k => $item)
            {
                $i = \App\PaymentRequestForm::where('id', $k)->first();
                if($i)
                {
                    $i->note = $request->note[$k];
                    $i->nominal_approved = $item;
                    $i->save();
                }
            }
        }

        $payment                        = \App\PaymentRequest::where('id', $request->id)->first();
        $payment->is_approved_atasan    = $request->status;
        $payment->save();
        
        return redirect()->route('karyawan.approval.payment-request-atasan.index')->with('message-success', 'Form Payment Request Berhasil diproses !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data'] = \App\PaymentRequest::where('id', $id)->first();

        return view('karyawan.approval-payment-request-atasan.detail')->with($params);
    }
}
