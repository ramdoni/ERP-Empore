<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApprovalOvertimeController extends Controller
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
        $params['data'] = \App\OvertimeSheet::where('approve_direktur_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.approval-overtime.index')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function proses(Request $request)
    {
        $overtime = \App\OvertimeSheet::where('id', $request->id)->first();
        $overtime->approve_direktur = $request->status;
        $overtime->approve_direktur_date = date('Y-m-d H:i:s');
        
        if($request->status ==0)
        {
            $status = 3;

            // send email atasan
            $objDemo = new \stdClass();
            $objDemo->content = '<p>Dear '. $overtime->user->name .'</p><p> Pengajuan Overtime anda ditolak.</p>' ;    
        }
        else
        {
            $status = 2;
            // send email atasan
            $objDemo = new \stdClass();
            $objDemo->content = '<p>Dear '. $overtime->user->name .'</p><p> Pengajuan Overtime anda disetujui.</p>' ; 
        }
        
        //\Mail::to($overtime->user->)->send(new \App\Mail\GeneralMail($objDemo));
        //\Mail::to('doni.enginer@gmail.com')->send(new \App\Mail\GeneralMail($objDemo));

        $overtime->status = $status;
        $overtime->save();

        return redirect()->route('karyawan.approval.overtime.index')->with('messages-success', 'Form Cuti Berhasil diproses !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data']         = \App\OvertimeSheet::where('id', $id)->first();
        $params['approval']     = \App\SettingApproval::where('user_id', \Auth::user()->id)->where('jenis_form','overtime')->first();

        return view('karyawan.approval-overtime.detail')->with($params);
    }
}
