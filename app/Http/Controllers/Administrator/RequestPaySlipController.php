<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequestPaySlipController extends Controller
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
        $params['data'] = \App\RequestPaySlip::orderBy('id', 'DESC')->get();

        return view('administrator.request-pay-slip.index')->with($params);
    }

    /**
     * [proses description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function proses($id)
    {
        $params['datamaster'] = \App\RequestPaySlip::where('id', $id)->first();
        $params['data'] = \App\RequestPaySlipItem::where('request_pay_slip_id', $id)->first();
        $params['dataArray'] = \App\RequestPaySlipItem::where('request_pay_slip_id', $id)->get();

        return view('administrator.request-pay-slip.proses')->with($params);
    }

    /**
     * [submit description]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function submit(Request $request, $id)
    {
        $data = \App\RequestPaySlip::where('id', $id)->first();
        $data->status = 2;
        $data->note = $request->note;
        $data->save();

        $bulanItem = \App\RequestPaySlipItem::where('request_pay_slip_id', $id)->get();
        $bulan = [];
        $total = 0;
        foreach($bulanItem as $k => $i)
        {
            $bulan[$k] = $i->bulan;$total++;
        }

        $items   = \DB::select(\DB::raw("SELECT payroll_history.*, month(created_at) as bulan FROM payroll_history WHERE MONTH(created_at) IN (". join(',', $bulan) .') and user_id='. $data->user_id .' and YEAR(created_at) ='. $request->tahun .' GROUP BY bulan'));
        $whereIn = [];       
        foreach($items as $i)
        {
            $whereIn[] = $i->id;
        }

        $params['total']        = $total;
        $params['dataArray']    = \App\PayrollHistory::whereIn('id', $whereIn)->get();
        $params['data']         = $data;

        $view =  view('administrator.request-pay-slip.print-pay-slip')->with($params);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        $pdf->stream();

        $output = $pdf->output();
        $destinationPath = public_path('/storage/temp/');

        file_put_contents( $destinationPath . $data->user->nik .'.pdf', $output);

        $file = $destinationPath . $data->user->nik .'.pdf';

        // send email
        $objDemo = new \stdClass();
        $objDemo->content = view('administrator.request-pay-slip.email-pay-slip'); 
        
        if($data->user->email != "")
        { 
            \Mail::send('administrator.request-pay-slip.print-pay-slip', $params,
                function($message) use($file, $data) {
                    $message->from('info@system.com');
                    //$message->to('doni.enginer@gmail.com');
                    $message->to($data->user->email);
                    $message->subject('Request Pay-Slip');
                    $message->attach($file, array(
                            'as' => $data->user->nik .'.pdf', 
                            'mime' => 'application/pdf')
                    );
                }
            );
        }

        return redirect()->route('administrator.request-pay-slip.index')->with('message-success', 'Request Pay Slip berhasil diproses');
    }

}
