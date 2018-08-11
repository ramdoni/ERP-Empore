<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MedicalReimbursement;
use App\MedicalReimbursementForm;
use App\User;

class MedicalController extends Controller
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
        $params['data'] = MedicalReimbursement::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.medical.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        $params['karyawan'] = User::where('access_id', 2)->get();

        return view('karyawan.medical.create')->with($params);
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data'] = MedicalReimbursement::where('id', $id)->first();;
        $params['form'] = MedicalReimbursementForm::where('medical_reimbursement_id', $id)->get();
        $params['karyawan'] = User::where('access_id', 2)->get();

        return view('karyawan.medical.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data       = MedicalReimbursement::where('id', $id)->first();
        $data->tanggal_pengajuan = $request->tanggal_pengajuan;
        $data->status       = 1;  
        $data->save();

        MedicalReimbursementForm::where('medical_reimbursement_id', $id)->delete();

        foreach($request->tanggal_kwitansi as $key => $item)
        {   
            $form                           = new MedicalReimbursementForm();
            $form->medical_reimbursement_id = $data->id;
            $form->tanggal_kwitansi         = $request->tanggal_kwitansi[$key];
            $form->user_family_id           = $request->user_family_id[$key];
            $form->jenis_klaim              = $request->jenis_klaim[$key];
            $form->jumlah                   = $request->jumlah[$key];
            $form->save();
        }

        return redirect()->route('karyawan.medical.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = MedicalReimbursement::where('id', $id)->first();
        $data->delete();

        MedicalReimbursementForm::where('medical_reimbursement_id', $id)->delete();

        return redirect()->route('karyawan.medical.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data                       = new MedicalReimbursement();
        $data->user_id              = \Auth::user()->id;
        $data->tanggal_pengajuan    = $request->tanggal_pengajuan;
        $data->status               = 1;  
        $data->approved_atasan_id   = $request->atasan_user_id; 
        $data->approve_direktur_id      = get_direktur(\Auth::user()->id)->id; 
        if(empty(\Auth::user()->empore_organisasi_staff_id) and !empty(\Auth::user()->empore_organisasi_manager_id))
        {
            $data->is_approved_atasan = 1;
        }
        $data->save();

        foreach($request->tanggal_kwitansi as $key => $item)
        {   
            $form                           = new MedicalReimbursementForm();
            $form->medical_reimbursement_id = $data->id;
            $form->tanggal_kwitansi         = $request->tanggal_kwitansi[$key];
            $form->user_family_id              = $request->user_family_id[$key];
            $form->jenis_klaim              = $request->jenis_klaim[$key];
            $form->jumlah                   = $request->jumlah[$key];
            $form->save();
        }

        $params['data']     = $data;
        $params['text']     = '<p><strong>Dear Bapak/Ibu '. $data->atasan->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' mengajukan Medical Reimbursement butuh persetujuan Anda.</p>';

        \Mail::send('email.medical-approval', $params,
            function($message) use($data) {
                $message->from('emporeht@gmail.com');
                $message->to($data->atasan->email);
                $message->subject('Empore - Pengajuan Medical Reimbursement');
            }
        );

        return redirect()->route('karyawan.medical.index')->with('message-success', 'Anda berhasil mengajukan Medical Reimbursement !');
    }
}
