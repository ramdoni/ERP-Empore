<?php

namespace App\Http\Controllers\Karyawan;

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
        $params['data'] = \App\RequestPaySlip::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.request-pay-slip.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('karyawan.request-pay-slip.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data'] = \App\RequestPaySlipItem::where('request_pay_slip_id', $id)->first();
        $params['dataArray'] = \App\RequestPaySlipItem::where('request_pay_slip_id', $id)->get();

        return view('karyawan.request-pay-slip.edit')->with($params);
    }

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = \App\RequestPaySlip::where('id', $id)->first();
        $data->delete();

        return redirect()->route('karyawan.request-pay-slip.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data                       = new \App\RequestPaySlip();
        $data->user_id              = \Auth::user()->id;
        $data->status               = 1;   
        $data->save();

        foreach($request->bulan as $key => $i)
        {   
            $item               = new \App\RequestPaySlipItem();
            $item->tahun        = $request->tahun;
            $item->request_pay_slip_id = $data->id;
            $item->bulan        = $i;
            $item->status       = 1; 
            $item->user_id      = \Auth::user()->id;
            $item->save();
        }

        return redirect()->route('karyawan.request-pay-slip.index')->with('message-success', 'Anda berhasil mengajukan Pay Slip !');
    }
}
