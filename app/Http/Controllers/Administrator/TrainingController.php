<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TrainingType;

class TrainingController extends Controller
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
        $data       =  \App\Training::orderBy('id', 'DESC')->select('training.*')->join('users', 'users.id', '=', 'training.user_id');
        $params['data_biaya'] = \App\Training::where('is_approve_atasan_actual_bill', 1)->where('status_actual_bill', 2)->orderBy('id', 'DESC')->get();

        if(request())
        {
            if(!empty(request()->employee_status))
            {
                $data = $data->where('users.organisasi_status', request()->employee_status);
            }

            if(!empty(request()->jabatan))
            {   
                if(request()->jabatan == 'Direktur')
                {
                    $data = $data->whereNull('users.empore_organisasi_staff_id')->whereNull('users.empore_organisasi_supervisor_id')->whereNull('users.empore_organisasi_manager_id')->where('users.empore_organisasi_direktur', '<>', '');
                }

                if(request()->jabatan == 'Manager')
                {
                    $data = $data->whereNull('users.empore_organisasi_staff_id')->whereNull('users.empore_organisasi_supervisor_id')->where('users.empore_organisasi_manager_id', '<>', '');
                }

                if(request()->jabatan == 'Supervisor')
                {
                    $data = $data->whereNull('users.empore_organisasi_staff_id')->where('users.empore_organisasi_supervisor_id', '<>', '')->where('users.empore_organisasi_manager_id', '<>', '');
                }

                if(request()->jabatan == 'Staff')
                {
                    $data = $data->where('users.empore_organisasi_staff_id', '<>', '');
                }
            }

            if(request()->action == 'download')
            {
                $this->downloadExcel($data->get());
            }
        }
        
        $params['data']     = $data->get();

        return view('administrator.training.index')->with($params);
    }

    /**
     * [batal description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function batal(Request $request)
    {   
        $data       = \App\Training::where('id', $request->id)->first();
        $data->status = 4;
        $data->note_pembatalan = $request->note;
        $data->save(); 

        return redirect()->route('administrator.training.index')->with('message-success', 'Leave successfully cancellation');
    }

    /**
     * [prosesBiaya description]
     * @return [type] [description]
     */
    public function prosesBiaya(Request $request)
    {
        $data = \App\Training::where('id', $request->id)->first();

        $data->transportasi_ticket_disetujui    = $request->transportasi_ticket_disetujui;
        $data->transportasi_ticket_catatan      = $request->transportasi_ticket_catatan;
        $data->transportasi_taxi_disetujui      = $request->transportasi_taxi_disetujui;
        $data->transportasi_taxi_catatan        = $request->transportasi_taxi_catatan;
        $data->transportasi_gasoline_disetujui  = $request->transportasi_gasolin_disetujui;
        $data->transportasi_gasoline_catatan    = $request->transportasi_gasolin_catatan;
        $data->transportasi_tol_disetujui       = $request->transportasi_tol_disetujui;
        $data->transportasi_tol_catatan         = $request->transportasi_tol_catatan;
        $data->transportasi_parkir_disetujui    = $request->transportasi_parkir_disetujui;
        $data->transportasi_parkir_catatan      = $request->transportasi_parkir_catatan;
        $data->uang_hotel_nominal_disetujui     = $request->uang_hotel_nominal_disetujui;
        $data->uang_hotel_catatan               = $request->uang_hotel_catatan;
        $data->uang_makan_nominal_disetujui     = $request->uang_makan_nominal_disetujui;
        $data->uang_makan_catatan               = $request->uang_makan_catatan;
        $data->uang_harian_nominal_disetujui    = $request->uang_harian_nominal_disetujui;
        $data->uang_harian_catatan              = $request->uang_harian_catatan;
        $data->uang_pesawat_nominal_disetujui   = $request->pesawat_nominal_disetujui;
        $data->uang_pesawat_catatan             = $request->uang_pesawat_catatan;
        $data->uang_biaya_lainnya1_nominal_disetujui = $request->uang_biaya_lainnya1_nominal_disetujui;
        $data->uang_biaya_lainnya1_catatan      = $request->uang_biaya_lainnya1_catatan;
        $data->uang_biaya_lainnya2_nominal_disetujui = $request->uang_biaya_lainnya2_nominal_disetujui;
        $data->uang_biaya_lainnya2_catatan      = $request->uang_biaya_lainnya2_catatan;
        $data->is_approve_hrd_actual_bill = 1;
        $data->sub_total_1_disetujui            = $request->sub_total_1_disetujui;
        $data->sub_total_2_disetujui            = $request->sub_total_2_disetujui;
        $data->sub_total_3_disetujui            = $request->sub_total_3_disetujui;

        // jika tidak ada uang muka maka tidak perlu approval finance
        if(empty($training->pengambilan_uang_muka))
        {   
            if($request->status_actual_bill == 1)
            {
                $data->status_actual_bill = 3; // approved
            }
            else
            {
                $data->status_actual_bill = 4; // reject
            }
        }

        $data->save();

        return redirect()->route('administrator.training.index')->with('message-success', 'Form Actual Bill successfully process');
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

        return view('administrator.training.biaya')->with($params);
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

        $training->approved_hrd = $status;
        $training->approved_hrd_id = \Auth::user()->id;
        $training->approved_hrd_date = date('Y-m-d H:i:s');

        // jika ada uang muka maka butuh approval di finance
        if(empty($training->pengambilan_uang_muka))
        {   
            if($status ==0)
            {
                $training->status = 3;

                // send email atasan
                $objDemo = new \stdClass();
                $objDemo->content = '<p>Dear '. $training->user->name .'</p><p> Your Training & Business Trip Rejected.</p>' ;    
            }
            else
            {
                $training->status = 2;
                // send email atasan
                $objDemo = new \stdClass();
                $objDemo->content = '<p>Dear '. $training->user->name .'</p><p> Your Training & Business Trip Approved.</p>' ; 
            }
        }

        // cek user yang mengetahui
        $mengetahui = \App\SettingApproval::where('jenis_form', 'training_mengetahui')->get(); 
        foreach($mengetahui as $item)
        {
            //\Mail::to($item->user->email)->send(new \App\Mail\GeneralMail($objDemo));
            //\Mail::to('doni.enginer@gmail.com')->send(new \App\Mail\GeneralMail($objDemo));
        }

        //\Mail::to($overtime->user->)->send(new \App\Mail\GeneralMail($objDemo));
        //\Mail::to('doni.enginer@gmail.com')->send(new \App\Mail\GeneralMail($objDemo));
        $training->save();

        return redirect()->route('administrator.training.index')->with('message-success', 'Training suceddfully process !');
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
        return view('administrator.training.detail')->with($params);
    }

    /**
     * [downloadExlce description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function downloadExcel($data)
    {
        $params = [];

        foreach($data as $no =>  $item)
        {
            $params[$no]['NO']               = $no+1;
            $params[$no]['NIK']              = $item->user->nik;
            $params[$no]['NAMA KARYAWAN']    = $item->user->name;
            $params[$no]['POSITION']         = empore_jabatan($item->user_id);
            $params[$no]['TGL KEGIATAN AWAL']   = date('d F Y', strtotime($item->tanggal_kegiatan_start));
            $params[$no]['TGL KEGIATAN AKHIR']  = date('d F Y', strtotime($item->tanggal_kegiatan_end));
            //$params[$no]['JENIS KEGIATAN']      = $item->jenis_training;
            $params[$no]['JENIS KEGIATAN']      = isset($item->trainingtype) ? $item->trainingtype->name:'' ;
             
            $params[$no]['TGL PENGAJUAN']       = date('d F Y', strtotime($item->created_at));

            $status = '';
            if($item->is_approved_atasan == ""){
                $status = 'Waiting Approval';
            }
            else
            {
                if($item->approve_direktur == "" and $item->is_approved_atasan == 1 and $item->status != 4)
                {
                    $status = 'Waiting Approval';
                }
                if($item->approve_direktur == 1)
                {
                    $status = 'Approved';
                }
            }
            if($item->status == 4)
            {
                $status = 'Canceled';
            }
            if($item->status == 3)
            {
                $status = 'Reject';
            }

            $params[$no]['STATUS']           = $status;

            $params[$no]['TGL APPROVAL DIREKTUR']        = $item->approve_direktur_date !== NULL ? date('d F Y', strtotime($item->approve_direktur_date)) : '';
            $params[$no]['TGL SUBMIT ACTUAL BILL']= $item->date_submit_actual_bill !== NULL ? date('d F Y', strtotime($item->date_submit_actual_bill)) : ''; 
            $params[$no]['TOTAL TRANSPORTASI']   = $item->sub_total_1;
            $params[$no]['TOTAL TRANSPORTASI DISETUJUI']   = $item->sub_total_1;
            $params[$no]['TOTAL TUNJANGAN MAKAN DAN HARIAN']   = $item->sub_total_1_disetujui;
            $params[$no]['TOTAL TUNJANGAN MAKAN DAN HARIAN DISETUJUI']   = $item->sub_total_2_disetujui;    
            $params[$no]['LAIN-LAIN 1']                 = $item->uang_biaya_lainnya1_nominal;
            $params[$no]['LAIN-LAIN 2']                 = $item->uang_biaya_lainnya2_nominal;
            $params[$no]['NOMINAL LAIN-LAIN DISETUJUI'] = $item->uang_biaya_lainnya1_nominal_disetujui + $item->uang_biaya_lainnya2_nominal_disetujui;
            $params[$no]['CASH ADVANCE']                = $item->pengambilan_uang_muka;
            $params[$no]['TOTAL ACTUAL BILL']           = $item->sub_total_1 + $item->sub_total_2 + $item->sub_total_3;
            $params[$no]['TOTAL BILL DISETUJUI']        = $item->sub_total_1_disetujui + $item->sub_total_2_disetujui + $item->sub_total_3_disetujui;

            $dateTemp ='';

            if(!empty($item->approve_direktur_date)){
                $dateTemp = date('d F Y', strtotime($item->approve_direktur_date));
            }else{
                $dateTemp ='';
            }
            $params[$no]['TGL APPROVAL BILL OLEH DIREKTUR']           = $dateTemp;
            $params[$no]['DIREKTUR']                  = isset($item->direktur->name) ? $item->direktur->name : "";
        }

        $styleHeader = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FFA0A0A0',
                ],
                'endColor' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
            ''
        ];

        return \Excel::create('Report-Training-dan-Perjalanan-Dinas-Karyawan',  function($excel) use($params, $styleHeader){
              $excel->sheet('mysheet',  function($sheet) use($params){
                $sheet->fromArray($params);
              });
            $excel->getActiveSheet()->getStyle('A1:AM1')->applyFromArray($styleHeader);
        })->download('xls');
    }
}