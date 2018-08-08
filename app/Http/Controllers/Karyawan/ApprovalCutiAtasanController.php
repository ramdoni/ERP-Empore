<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApprovalCutiAtasanController extends Controller
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
        $params['data'] = \App\CutiKaryawan::where('approved_atasan_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.approval-cuti-atasan.index')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function proses(Request $request)
    {
        $cuti                           = \App\CutiKaryawan::where('id', $request->id)->first();
        $cuti->is_approved_atasan       = $request->status;
        $cuti->catatan_atasan           = $request->noted;
        $cuti->date_approved_atasan     = date('Y-m-d H:i:s');

        $params['atasan']   = $cuti->direktur;
        $params['user']     = $cuti->karyawan;
        $params['cuti']     = $cuti;

        if($request->status == 0)
        {
            $cuti->status = 3 ;
            $params['atasan']   = $cuti->atasan;
            \Mail::send('email.cuti-denied', $params,
                function($message) use($cuti) {
                    $message->from('emporeht@gmail.com');
                    $message->to($cuti->karyawan->email);
                    $message->subject('Empore - Pengajuan Cuti / Izin');
                }
            );
        }
        else
        {
            \Mail::send('email.cuti-approval', $params,
                function($message) use($cuti) {
                    $message->from('emporeht@gmail.com');
                    $message->to($cuti->direktur->email);
                    $message->subject('Empore - Pengajuan Cuti / Izin');
                }
            );
        }

        $cuti->save();

        return redirect()->route('karyawan.approval.cuti-atasan.index')->with('message-success', 'Form Cuti Berhasil diproses !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data'] = \App\CutiKaryawan::where('id', $id)->first();

        return view('karyawan.approval-cuti-atasan.detail')->with($params);
    }
}
