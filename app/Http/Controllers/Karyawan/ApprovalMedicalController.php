<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApprovalMedicalController extends Controller
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
        // cek jenis user
       
        $params['data'] = \App\MedicalReimbursement::where('approve_direktur_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.approval-medical.index')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function proses(Request $request)
    {
        $medical = \App\MedicalReimbursement::where('id', $request->id)->first();        
        $medical->approve_direktur = $request->status;

        $params['data'] = $medical;

        // Jika approve
        if($request->status == 1)
        {
            $medical->status =2;

            $params['text']     = '<p><strong>Dear Bapak/Ibu '. $data->user->name .'</strong>,</p> <p>  Pengajuan Medical Reimbursement anda <strong style="color: green;">DISETUJUI</strong>.</p>';

            \Mail::send('email.medical-approval', $params,
                function($message) use($data) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->karyawan->email);
                    $message->subject('Empore - Pengajuan Medical Reimbursement');
                }
            );
        }
        else // jika reject
        {
            $medical->status = 3;

            $params['text']     = '<p><strong>Dear Bapak/Ibu '. $data->user->name .'</strong>,</p> <p>  Pengajuan Medical Reimbursement anda <strong style="color: red;">DITOLAK</strong>.</p>';

            \Mail::send('email.medical-approval', $params,
                function($message) use($data) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->karyawan->email);
                    $message->subject('Empore - Pengajuan Medical Reimbursement');
                }
            );
        }   

        $medical->save();

        return redirect()->route('karyawan.approval.medical.index')->with('message-success', 'Form Medical Reimbursement Berhasil diproses !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data']         = \App\MedicalReimbursement::where('id', $id)->first();
        $params['approval']     = \App\SettingApproval::where('user_id', \Auth::user()->id)->where('jenis_form','medical')->first();

        return view('karyawan.approval-medical.detail')->with($params);
    }
}
