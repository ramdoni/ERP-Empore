<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApprovalPaymentRequestController extends Controller
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
        $params['data'] = \App\PaymentRequest::where('approve_direktur_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.approval-payment-request.index')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function proses(Request $request)
    {   
        if(isset($request->nominal_approve))
        {
            foreach($request->nominal_approve as $k => $item)
            {
                $i = \App\PaymentRequestForm::where('id', $k)->first();
                if($i)
                {
                    $i->note                = $request->note[$k];
                    $i->nominal_approved    = $item;
                    $i->save();
                }
            }
        }
        
        $payment = \App\PaymentRequest::where('id', $request->id)->first();
        $status = $request->status;
        $payment->approve_direktur = $status;
        if($status >=1)
        {
            $status = 3;

            // send email atasan
            $objDemo = new \stdClass();
            $objDemo->content = '<p>Dear '. $payment->user->name .'</p><p> Pengajuan Payment Request anda ditolak.</p>' ;
        }
        else
        {
            $status = 2;

            // send email atasan
            $objDemo = new \stdClass();
            $objDemo->content = '<p>Dear '. $payment->user->name .'</p><p> Pengajuan Payment Request anda disetujui.</p>' ;
        }

        $payment->status = $status;
        $payment->save();

        return redirect()->route('karyawan.approval.payment_request.index')->with('message-success', 'Form Payment Request Berhasil diproses !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data'] = \App\PaymentRequest::where('id', $id)->first();

        return view('karyawan.approval-payment-request.detail')->with($params);
    }
}
