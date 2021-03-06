<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TrainingType;
use App\User;

class ApprovalTrainingController extends Controller
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
        $params['data']         = \App\Training::where('approve_direktur_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('karyawan.approval-training.index')->with($params);
    }

    /**
     * [prosesBiaya description]
     * @return [type] [description]
     */
    public function prosesBiaya(Request $request)
    {
        $data = \App\Training::where('id', $request->id)->first();
        $data->approve_direktur_actual_bill_date = date('Y-m-d H:i:s');

        $approval = \App\SettingApproval::where('user_id', \Auth::user()->id)->where('jenis_form','training')->first();

        $data->transportasi_ticket_disetujui    = $request->transportasi_ticket_disetujui;
        $data->transportasi_ticket_catatan      = $request->transportasi_ticket_catatan;
        $data->transportasi_taxi_disetujui      = $request->transportasi_taxi_disetujui;
        $data->transportasi_taxi_catatan        = $request->transportasi_taxi_catatan;
        $data->transportasi_gasoline_disetujui  = $request->transportasi_gasoline_disetujui;
        $data->transportasi_gasoline_catatan    = $request->transportasi_gasoline_catatan;
        $data->transportasi_tol_disetujui       = $request->transportasi_tol_disetujui;
        $data->transportasi_tol_catatan         = $request->transportasi_tol_catatan;
        $data->transportasi_parkir_disetujui    = $request->transportasi_parkir_disetujui;
        $data->transportasi_parkir_catatan      = $request->transportasi_parkir_catatan;
        $data->uang_biaya_lainnya1_nominal_disetujui = $request->uang_biaya_lainnya1_nominal_disetujui;
        $data->uang_biaya_lainnya1_catatan      = $request->uang_biaya_lainnya1_catatan;
        $data->uang_biaya_lainnya2_nominal_disetujui = $request->uang_biaya_lainnya2_nominal_disetujui;
        $data->uang_biaya_lainnya2_catatan      = $request->uang_biaya_lainnya2_catatan;

        $data->sub_total_1_disetujui            = $request->sub_total_1_disetujui;
        $data->sub_total_2_disetujui            = $request->sub_total_2_disetujui;
        $data->sub_total_3_disetujui            = $request->sub_total_3_disetujui;
        $data->approve_direktur_actual_bill     = $request->status_actual_bill; 

        if($request->status_actual_bill == 1)
        {
            $data->status_actual_bill = 3; // approved
        }
        else
        {
            $data->status_actual_bill = 4; // reject
        }
        $data->noted_bill = $request->noted_bill;
        $data->save();

        foreach($request->id_allowance as $key => $item)
            {
                $form = \App\TrainingAllowance::where('id', $request->id_allowance[$key] )->first();
                $form->morning_approved         = $request->morning_approved[$key];
                $form->afternoon_approved       = $request->afternoon_approved[$key];
                $form->evening_approved         = $request->evening_approved[$key];
                $form->daily_approved           = $request->daily_approved[$key];
                $form->save();
            }


        return redirect()->route('karyawan.approval.training.index')->with('message-success', 'Data Successfully processed');
    }

    /**
     * [biaya description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function biaya($id)
    {
        $params['data'] = \App\Training::where('id', $id)->first();
        $params['allowance']        = \App\TrainingAllowance::where('training_id',$id)->get();

        return view('karyawan.approval-training.biaya')->with($params);
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
        $status->jenis_form             = 'training';
        $status->foreign_id             = $request->id;
        $status->status                 = $request->status;
        $status->noted                  = $request->noted;
        $status->save();    

        $status = $request->status;
        $training = \App\Training::where('id', $request->id)->first();
        $training->approve_direktur = $status;    
        $training->approve_direktur_date = date('Y-m-d H:i:s');    

        // jika ada uang muka maka butuh approval di finance
        if($status ==0)
        {
            $training->status = 3;

            $params['data']     = $training;
            $params['text']     = '<p> Your Training & Business Trip <label style="color: red;"><b>Rejected</b></label>.</p>';
            \Mail::send('email.training-approval', $params,
                function($message) use($training) {
                    $message->from('intimakmurnew@gmail.com');
                    $message->to($training->user->email);
                    $message->subject('IntiMakmur - Submission of Training & Business Trip');
                }
            );    
        }
        else
        {
            $training->status = 2;
            $params['data']     = $training;
            $params['text']     = '<p> Your Training & Business Trip <label style="color: green;"><b>Approved</b></label>.</p>';

            \Mail::send('email.training-approval', $params,
                function($message) use($training) {
                    $message->from('intimakmurnew@gmail.com');
                    $message->to($training->user->email);
                    $message->subject('IntiMakmur - Submission of Training & Business Trip');
                }
            );
        }
        
        $training->save();

        return redirect()->route('karyawan.approval.training.index')->with('messages-success', 'Data Successfully processed !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data'] = \App\Training::where('id', $id)->first();
        $params['trainingtype'] = TrainingType::all();
        return view('karyawan.approval-training.detail')->with($params);
    }
}
