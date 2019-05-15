<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

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

        $params['data']     = $cuti;

        if($request->status == 0)
        {
            $cuti->status = 3 ;

            $params['text']     = '<p><strong>Dear Mr/Mrs/Ms '. $cuti->user->name .'</strong>,</p> <p>  Your submission of leave/permit <strong style="color: red;">rejected</strong>.</p>';

            \Mail::send('email.cuti-approval', $params,
                function($message) use($cuti) {
                    $message->from('intimakmurnew@gmail.com');
                    $message->to($cuti->karyawan->email);
                    $message->subject('IntiMakmur - Submission of Leave / Permit');
                }
            );
        }
        else
        {
            if($cuti->approved_manager_id == null){
                 $dataDirektur = User::whereNotNull('empore_organisasi_direktur')->whereNull('empore_organisasi_manager_id')->whereNull('empore_organisasi_staff_id')->get();
                foreach ($dataDirektur as $key => $value) {
                    # code...
                    if($value->email == "") continue;
                    $params['text']     = '<p><strong>Dear Mr/Mrs/Ms '. $value->name .'</strong>,</p> <p> '. $cuti->user->name .'  / '.  $cuti->user->nik .' request for leave/permit and need your approval.</p>';
                    \Mail::send('email.cuti-approval', $params,
                        function($message) use($cuti,$value) {
                            $message->from('intimakmurnew@gmail.com');
                            $message->to($value->email);
                            $message->subject('IntiMakmur - Submission of Leave / Permit');
                        }
                    );
                }
            } elseif ($cuti->approved_manager_id != null) {
                $params['text']     = '<p><strong>Dear Mr/Mrs/Ms '. $cuti->manager->name .'</strong>,</p> <p> '. $cuti->user->name .'  / '.  $cuti->user->nik .' request for leave/permit and need your approval.</p>';

                \Mail::send('email.cuti-approval', $params,
                    function($message) use($cuti) {
                        $message->from('intimakmurnew@gmail.com');
                        $message->to($cuti->manager->email);
                        $message->subject('IntiMakmur - Submission of Leave / Permit');
                    }
                );
            }
            
        }

        $cuti->save();

        return redirect()->route('karyawan.approval.cuti-atasan.index')->with('message-success', 'Data Successfully processed !');
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
