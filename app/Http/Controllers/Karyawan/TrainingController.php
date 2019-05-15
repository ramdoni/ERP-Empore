<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Training;
use App\TrainingAllowance;
use App\User;
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
        $params['data'] = Training::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('karyawan.training.index')->with($params);
    }

    /**
     * [detailAll description]
     * @return [type] [description]
     */
    public function detailAll($id)
    {
        $params['data'] = \App\Training::where('id', $id)->first(); 

        $data = $params['data'];

        $params['total_transportasi_nominal'] = $data->transportasi_ticket + $data->transportasi_taxi + $data->transportasi_gasoline + $data->transportasi_tol + $data->transportasi_parkir;

        $params['total_hotel_nominal'] = $data->uang_hotel_nominal + $data->uang_makan_nominal + $data->uang_harian_nominal + $data->uang_pesawat_nominal;
        $params['total_hotel_qty']  = $data->uang_hotel_qty + $data->uang_makan_qty + $data->uang_harian_qty + $data->uang_pesawat_qty;
        
        $params['total_lainnya'] = $data->uang_biaya_lainnya1 + $data->uang_biaya_lainnya2; 
        $params['total_hotel_nominal_dan_qty'] = ($data->uang_hotel_nominal * $data->uang_hotel_qty) + ($data->uang_makan_nominal * $data->uang_makan_qty) + ($data->uang_harian_nominal * $data->uang_harian_qty) + ($data->uang_pesawat_nominal * $data->uang_pesawat_qty) ;

        return view('karyawan.training.detail-all')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        $params['trainingtype'] = TrainingType::all();
        return view('karyawan.training.create')->with($params);
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = Training::where('id', $id)->first();
        
        return view('karyawan.training.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data       = Training::where('id', $id)->first();
        $data->save();

        return redirect()->route('karyawan.training.index')->with('message-success', 'Data saved successfully');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = Training::where('id', $id)->first();
        $data->delete();

        return redirect()->route('karyawan.training.index')->with('message-sucess', 'Data successfully deleted');
    } 

    /**
     * [detailTraining description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detailTraining($id)
    {   
        $params['data'] = \App\Training::where('id', $id)->first();
        $params['trainingtype'] = TrainingType::all();
        return view('karyawan.training.detail-training')->with($params);
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function biaya($id)
    {
        $params['data']             = \App\Training::where('id', $id)->first();
        $params['allowance']        = \App\TrainingAllowance::where('training_id',$id)->get();
        //$params['plafond_dinas']    = plafond_perjalanan_dinas( (\Auth::user()->organisasiposition->name == 'Head' ? 'Supervisor' : \Auth::user()->organisasiposition->name));

        return view('karyawan.training.biaya')->with($params);
    }   

    /**
     * [submitBiaya description]
     * @return [type] [description]
     */
    public function submitBiaya(Request $request)
    {
        $data = \App\Training::where('id', $request->id)->first();
        $data->transportasi_ticket = $request->transportasi_ticket;
        $data->transportasi_taxi = $request->transportasi_taxi;
        $data->transportasi_gasoline = $request->transportasi_gasoline;
        $data->transportasi_tol = $request->transportasi_tol;
        $data->transportasi_parkir = $request->transportasi_parkir;
        
        if(empty(\Auth::user()->empore_organisasi_staff_id) and !empty(\Auth::user()->empore_organisasi_manager_id))
        {
            $data->is_approved_atasan = 1;
        }

        if (request()->hasFile('transportasi_ticket_file'))
        {
            $file = $request->file('transportasi_ticket_file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/file-training/');
            $file->move($destinationPath, $fileName);

            $data->transportasi_ticket_file = $fileName;
        }
        
        if (request()->hasFile('transportasi_taxi_file'))
        {
            $file = $request->file('transportasi_taxi_file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/file-training/');
            $file->move($destinationPath, $fileName);

            $data->transportasi_taxi_file = $fileName;
        }

        $data->transportasi_gasoline    = $request->transportasi_gasoline;
        if (request()->hasFile('transportasi_gasoline_file'))
        {
            $file = $request->file('transportasi_gasoline_file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/file-training/');
            $file->move($destinationPath, $fileName);

            $data->transportasi_gasoline_file = $fileName;
        }

        $data->transportasi_tol    = $request->transportasi_tol;
        if (request()->hasFile('transportasi_tol_file'))
        {
            $file = $request->file('transportasi_tol_file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/file-training/');
            $file->move($destinationPath, $fileName);

            $data->transportasi_tol_file = $fileName;
        }

        $data->transportasi_parkir    = $request->transportasi_parkir;
        if (request()->hasFile('transportasi_parkir_file'))
        {
            $file = $request->file('transportasi_parkir_file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/file-training/');
            $file->move($destinationPath, $fileName);

            $data->transportasi_parkir_file = $fileName;
        }
        
        $data->uang_biaya_lainnya1    = $request->uang_biaya_lainnya1;
        $data->uang_biaya_lainnya1_nominal    = $request->uang_biaya_lainnya1_nominal;
        
        if (request()->hasFile('uang_biaya_lainnya1_file'))
        {
            $file = $request->file('uang_biaya_lainnya1_file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/file-training/');
            $file->move($destinationPath, $fileName);

            $data->uang_biaya_lainnya1_file = $fileName;
        }

        $data->uang_biaya_lainnya2    = $request->uang_biaya_lainnya2;
        $data->uang_biaya_lainnya2_nominal    = $request->uang_biaya_lainnya2_nominal;
        
        if (request()->hasFile('uang_biaya_lainnya2_file'))
        {
            $file = $request->file('uang_biaya_lainnya2_file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/file-training/');
            $file->move($destinationPath, $fileName);

            $data->uang_biaya_lainnya2_file = $fileName;
        }

        $data->status_actual_bill = $request->status_actual_bill;
        $data->sub_total_1 = $request->sub_total_1;
        $data->sub_total_2 = $request->sub_total_2;
        $data->sub_total_3 = $request->sub_total_3;
        $data->noted_bill = $request->noted_bill;
        $data->date_submit_actual_bill = date('Y-m-d');
        $data->save();
        
        foreach($request->date as $key => $item)
            {
                $form = new TrainingAllowance();
                $form->training_id   = $data->id;
                $form->date          = $item;
                $form->meal_plafond  = $request->meal_plafond[$key];
                $form->morning       = $request->morning[$key];
                $form->afternoon     = $request->afternoon[$key];
                $form->evening       = $request->evening[$key];
                $form->daily_plafond = $request->daily_plafond[$key];
                $form->daily         = $request->daily[$key];

                if($request->hasFile('file_struk'))
                {
                    foreach($request->file_struk as $k => $file)
                    {
                        if ($file and $key == $k ) {
                        
                            $image = $file;
                            
                            $name = time().'.'.$image->getClientOriginalExtension();
                            
                            $destinationPath = public_path('storage/file-allowance/');
                            
                            $image->move($destinationPath, $name);

                            $form->file_struk = $name;
                        }
                    }
                }

                $form->save();
            }

        return redirect()->route('karyawan.training.index')->with('message-success', 'Actual bill successfully processed ');
    }

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data                           = new Training();
        $data->user_id                  = \Auth::user()->id;
        // Form Kegiatan
        $data->training_type_id         = $request->training_type_id;
        $data->jenis_training           = $request->jenis_training;
        $data->cabang_id                = $request->cabang_id;
        $data->lokasi_kegiatan          = $request->lokasi_kegiatan;
        $data->tempat_tujuan            = $request->tempat_tujuan;
        $data->topik_kegiatan           = $request->topik_kegiatan;
        $data->tanggal_kegiatan_start   = $request->tanggal_kegiatan_start;
        $data->tanggal_kegiatan_end     = $request->tanggal_kegiatan_end;
        $data->pengambilan_uang_muka    = $request->pengambilan_uang_muka;
        $data->tanggal_pengajuan        = $request->tanggal_pengajuan;
        $data->tanggal_penyelesaian     = $request->tanggal_penyelesaian;
        $data->approved_atasan_id       = $request->approved_atasan_id;
        $data->approved_manager_id       = $request->approved_manager_id;

        if(!empty(\Auth::user()->empore_organisasi_staff_id) and !empty(\Auth::user()->empore_organisasi_supervisor_id) and !empty(\Auth::user()->empore_organisasi_manager_id))
        {
            if((empty($request->approved_atasan_id)) and (empty($request->approved_manager_id)))
            {
                $data->is_approved_atasan = 1;
                $data->is_approved_manager = 1;
                $data->is_approve_atasan_actual_bill = 1;
                $data->is_approve_manager_actual_bill =1;
            }
            if((!empty($request->approved_atasan_id)) and (empty($request->approved_manager_id)))
            {
                 $data->is_approved_manager = 1;
                 $data->is_approve_manager_actual_bill =1;
            }
        }

        if(empty(\Auth::user()->empore_organisasi_staff_id) and !empty(\Auth::user()->empore_organisasi_supervisor_id))
        {
            if((empty($request->approved_atasan_id)) and (empty($request->approved_manager_id)))
            {
                $data->is_approved_atasan = 1;
                $data->is_approved_manager = 1;
                $data->is_approve_atasan_actual_bill = 1;
                $data->is_approve_manager_actual_bill =1;

            }
            if((!empty($request->approved_atasan_id)) and (empty($request->approved_manager_id)))
            {
                 $data->is_approved_manager = 1;
                 $data->is_approve_manager_actual_bill =1;
            }
        }

       if(empty(\Auth::user()->empore_organisasi_staff_id) and empty(\Auth::user()->empore_organisasi_supervisor_id) and !empty(\Auth::user()->empore_organisasi_manager_id))
       {
             if((empty($request->approved_atasan_id)) and (empty($request->approved_manager_id)))
            {
                $data->is_approved_atasan = 1;
                $data->is_approved_manager = 1;
                $data->is_approve_atasan_actual_bill = 1;
                $data->is_approve_manager_actual_bill =1;
            }
       }   

        // Form Perjalanan Menggunakan Pesawat
        $data->pesawat_perjalanan       = $request->pesawat_perjalanan;
        $data->tanggal_berangkat        = $request->tanggal_berangkat;
        $data->waktu_berangkat          = $request->waktu_berangkat;
        $data->tanggal_pulang           = $request->tanggal_pulang;
        $data->waktu_pulang             = $request->waktu_pulang;
        $data->pesawat_rute_dari        = $request->pesawat_rute_dari;
        $data->pesawat_rute_tujuan      = $request->pesawat_rute_tujuan;
        $data->pesawat_kelas            = $request->pesawat_kelas;
        $data->pesawat_maskapai         = $request->pesawat_maskapai;
        $data->status                   = 1;
        $data->others                   = $request->others;
        $data->pergi_bersama            = $request->pergi_bersama;
        $data->note                     = $request->note;
        $data->approve_direktur_id      = get_direktur()->id; 
        $data->save();

        $params['data']     = $data;

        if($request->approved_atasan_id != null) {
           $params['text']     = '<p><strong>Dear Mr/Mrs/Ms '. $data->atasan->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' request for Training & Business Trip and need your approval.</p>';

        \Mail::send('email.training-approval', $params,
            function($message) use($data) {
                $message->from('intimakmurnew@gmail.com');
                $message->to($data->atasan->email);
                $message->subject('IntiMakmur - Submission of Training & Business Trip');
            });
        } elseif($request->atasan_user_id == null)
        {
            $dataDirektur = User::whereNotNull('empore_organisasi_direktur')->whereNull('empore_organisasi_manager_id')->whereNull('empore_organisasi_staff_id')->get();

            foreach ($dataDirektur as $key => $value) {
                # code...
                if($value->email == "") continue;
                 $params['text']     = '<p><strong>Dear Mr/Mrs/Ms '. $value->name .'</strong>,</p> <p> '. $data->user->name .'  / '.  $data->user->nik .' request for Training & Business Trip and need your approval.</p>';

                \Mail::send('email.training-approval', $params,
                function($message) use($data,$value) {
                $message->from('intimakmurnew@gmail.com');
                $message->to($value->email);
                $message->subject('IntiMakmur - Submission of Training & Business Trip');
                });
            }           
        }
        return redirect()->route('karyawan.training.index')->with('message-success', 'Data saved successfully');
    }
}
