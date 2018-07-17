<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApprovalMedicalAtasanController extends Controller
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
        $params['data'] = \App\MedicalReimbursement::where('approved_atasan_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();
 
        return view('karyawan.approval-medical-atasan.index')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function proses(Request $request)
    {
        $medical = \App\MedicalReimbursement::where('id', $request->id)->first();
        $medical->is_approved_atasan = $request->status;
        $medical->date_approved_atasan = date('Y-m-d H:i:s');
        $medical->save();

        return redirect()->route('karyawan.approval.medical-atasan.index')->with('message-success', 'Form Medical Reimbursement Berhasil diproses !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data'] = \App\MedicalReimbursement::where('id', $id)->first();

        return view('karyawan.approval-medical-atasan.detail')->with($params);
    }
}
