<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApprovalOvertimeAtasanController extends Controller
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
        $params['data'] = \App\OvertimeSheet::where('approved_atasan_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.approval-overtime-atasan.index')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function proses(Request $request)
    {
        $overtime                           = \App\OvertimeSheet::where('id', $request->id)->first();
        $overtime->is_approved_atasan       = $request->status;
        $overtime->date_approved_atasan     = date('Y-m-d H:i:s');
        $overtime->save();   

        return redirect()->route('karyawan.approval.overtime-atasan.index')->with('messages-success', 'Form Cuti Berhasil diproses !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data'] = \App\OvertimeSheet::where('id', $id)->first();

        return view('karyawan.approval-overtime-atasan.detail')->with($params);
    }
}
