<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ModelUser;
use Auth;
use Session;
use Illuminate\Support\Facades\Input;
use App\Directorate;
use App\Division;
use App\Department;
use App\Section;
use App\Provinsi;
use App\Kabupaten;
use App\Kecamatan;
use App\Kelurahan;
use App\User;

class AjaxController extends Controller
{
    protected $respon;

    /**
     * [__construct description]
     */
    public function __construct()
    {
        /**
         * [$this->respon description]
         * @var [type]
         */
        $this->respon = ['message' => 'error'];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ;
    }

    /**
     * [updatePasswordAdministrator description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updatePasswordAdministrator(Request $request)
    {
        $params = ['message' => 'success'];
        
        if($request->ajax())
        {
            $data               = \App\User::where('id', \Auth::user()->id)->first();
            
            if(!\Hash::check($request->currentpassword, $data->password))
            {
                $params['message']  = 'error';
                $params['data']     = 'Current password salah';
            }
            else
            {
                $data->password                 = bcrypt($request->password);
                $data->last_change_password     = date('Y-m-d H:i:s');
                $data->save();

                \Session::flash('message-success', 'Password successfully changed');
            }
        }   
        
        return response()->json($params);
    }

    /**
     * [updateFirstPassword description]
     * @return [type] [description]
     */
    public function updatePassword(Request $request)
    {
        $params = ['message' => 'success'];
        
        if($request->ajax())
        {
            $data               = \App\User::where('id', $request->id)->first();
            $data->password     = bcrypt($request->password);
            $data->is_reset_first_password = 1; 
            $data->last_change_password = date('Y-m-d H:i:s');
            $data->save();

            \Session::flash('message-success', 'Password successfully changed');
        }   
        
        return response()->json($params);
    }

    /**
     * [updateInventarisMobil description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateInventarisMobil(Request $request)
    {
        $params = ['message' => 'success'];
        
        if($request->ajax())
        {
            $data = \App\UserInventarisMobil::where('id', $request->id)->first();
            $data->tipe_mobil           = $request->tipe_mobil;
            $data->tahun                = $request->tahun;
            $data->no_polisi            = $request->no_polisi;
            $data->status_mobil         = $request->status_mobil;
            $data->save();

            \Session::flash('message-success', 'Data successfully changed');
        }   
        
        return response()->json($params);
    }

    /**
     * [updateInventarisLainnya description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateInventarisLainnya(Request $request)
    {
        $params = ['message' => 'success'];
        
        if($request->ajax())
        {
            $data = \App\UserInventaris::where('id', $request->id)->first();
            $data->jenis            = $request->jenis;
            $data->description      = $request->description;
            $data->save();

            \Session::flash('message-success', 'Data successfully changed');
        }   
        
        return response()->json($params);
    }

    /**
     * [updateCuti description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateCuti(Request $request)
    {
        $params = ['message' => 'success'];
        
        if($request->ajax())
        {
            $data = \App\UserCuti::where('id', $request->id)->first();
            $data->cuti_id          = $request->cuti_id;
            $data->kuota            = $request->kuota;
            $data->cuti_terpakai    = $request->terpakai;
            $data->sisa_cuti        = $request->kuota - $request->terpakai;
            $data->save();

            \Session::flash('message-success', 'Data successfully changed');
        }   
        
        return response()->json($params);
    }

    /**
     * [updateEducation description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateEducation(Request $request)
    {
        $params = ['message' => 'success'];
        
        if($request->ajax())
        {
            $data = \App\UserEducation::where('id', $request->id)->first();
            $data->pendidikan       = $request->pendidikan;
            $data->tahun_awal       = $request->tahun_awal;
            $data->tahun_akhir      = $request->tahun_akhir;
            $data->fakultas         = $request->fakultas;
            $data->jurusan          = $request->jurusan;
            $data->nilai            = $request->nilai;
            $data->kota             = $request->kota;
            $data->save();

            \Session::flash('message-success', 'Data successfully changed');
        }   
        
        return response()->json($params);
    }

    /**
     * [updateDependent description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateDependent(Request $request)
    {
        $params = ['message' => 'success'];
        
        if($request->ajax())
        {
            $data = \App\UserFamily::where('id', $request->id)->first();
            $data->nama             = $request->nama;
            $data->hubungan         = $request->hubungan;
            $data->tempat_lahir     = $request->tempat_lahir;
            $data->tanggal_lahir    = $request->tanggal_lahir;
            $data->tanggal_meninggal= $request->tanggal_meninggal;
            $data->jenjang_pendidikan=$request->jenjang_pendidikan;
            $data->pekerjaan        = $request->pekerjaan;
            $data->tertanggung      = $request->tertanggung;
            $data->save();

            \Session::flash('message-success', 'Data successfully changed');
        }   
        
        return response()->json($params);
    }

    
    /**
     * [getKaryawan description]
     * @return [type] [description]
     */
    public function getKaryawan(Request $request)
    {
        $params = [];
        if($request->ajax())
        {
                $data =  \App\User::where('name', 'LIKE', "%". $request->name . "%")->orWhere('nik', 'LIKE', '%'. $request->name .'%')->get();

                $params = [];
                foreach($data as $k => $item)
                {
                    if($k >= 10) continue;

                    $params[$k]['id'] = $item->id;
                    $params[$k]['value'] = $item->nik .' - '. $item->name;
                }
        }
        
        return response()->json($params); 
    }

    /**
     * [getAirports description]
     * @return [type] [description]
     */
    public function getAirports(Request $request)
    {
        $data = [];
        if($request->ajax())
        {
            if(strlen($request->word) >=3 ) 
            { 
                $data =  \App\Airports::where('name', 'LIKE', "%". $request->word . "%")->orWhere('cityName', 'LIKE', '%'. $request->word .'%')->orWhere('countryName', 'LIKE', '%'. strtoupper($request->word) .'%')->groupBy('code')->get();

                $params = [];
                foreach($data as $k => $item)
                {
                    if($k == 10) continue;

                    $params[$k] = $item;
                    $params[$k]['value'] = $item->name .' - '. $item->cityName;
                }
            }
        }
        
        return response()->json($params);   
    }


   

    /**
     * [getStatusApproval description]
     * @return [type] [description]
     */
    public function getHistoryApproval(Request $request)
    {
        if($request->ajax())
        {
            $data = \App\StatusApproval::where('jenis_form', $request->jenis_form)->where('foreign_id', $request->foreign_id)->get();

            $obj = [];
            foreach($data as $key => $item)
            {
                $obj[$key] = $item;
                $obj[$key]['user_approval'] = $item->user_approval;
            }

            return response()->json(['message' => 'success', 'data' => $obj]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getHistoryApprovalCuti description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getHistoryApprovalCuti(Request $request)
    {
        if($request->ajax())
        {
            $data = \App\CutiKaryawan::where('id', $request->foreign_id)->first();

            $atasan = \App\User::where('id', $data->approved_atasan_id)->first();
            $manager = \App\User::where('id', $data->approved_manager_id)->first();
            $direktur = \App\User::where('id', $data->approve_direktur_id)->first();
            
            $data->atasan = "";
            $data->jenis_karyawan = strtolower(jabatan_level_user($data->user_id));

            if(isset($atasan))
            {
                $data->atasan = $atasan->nik .' - '. $atasan->name;
            }
            if(isset($manager))
            {
                $data->manager = $manager->nik .' - '. $manager->name;
            }
            if(isset($direktur))
            {
                $data->direktur = $direktur->nik .' - '. $direktur->name;
            }

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }


   
    /**
     * [getHistoryApprovalCuti description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getHistoryApprovalTraining(Request $request)
    {
        if($request->ajax())
        {
            $data = \App\Training::where('id', $request->foreign_id)->first();
            $atasan = \App\User::where('id', $data->approved_atasan_id)->first();
            $manager = \App\User::where('id', $data->approved_manager_id)->first();
            $direktur = \App\User::where('id', $data->approve_direktur_id)->first();

            $data->atasan = "";

            $data->jenis_karyawan = strtolower(jabatan_level_user($data->user_id));

            if(isset($atasan))
            {
                $data->atasan = $atasan->nik .' - '. $atasan->name;
            }
            if(isset($manager))
            {
                $data->manager = $manager->nik .' - '. $manager->name;
            }

            if(isset($direktur))
            {
                $data->direktur = $direktur->nik .' - '. $direktur->name;
            }

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getHistoryApprovalTrainingBill description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getHistoryApprovalTrainingBill(Request $request)
    {
        if($request->ajax())
        {
            $data = \App\Training::where('id', $request->foreign_id)->first();
            $atasan = \App\User::where('id', $data->approved_atasan_id)->first();
            $manager = \App\User::where('id', $data->approved_manager_id)->first();
            $direktur = \App\User::where('id', $data->approve_direktur_id)->first();
            
            $data->atasan = "";
            $data->manager = "";
            $data->direktur = "";



            if(!empty($data->user->empore_organisasi_staff_id))
            {
                $data->jenis_karyawan = 'staff';
            }
            if(empty($data->user->empore_organisasi_staff_id) and !empty($data->empore_organisasi_supervisor_id))
            {
                $data->jenis_karyawan = 'supervisor';
            }


            if(empty($data->user->empore_organisasi_staff_id) and empty($data->empore_organisasi_supervisor_id) and !empty($data->user->empore_organisasi_manager_id))
            {
                $data->jenis_karyawan = 'manager';
            }

            if(isset($atasan))
            {
                $data->atasan = $atasan->nik .' - '. $atasan->name;
            }
            if(isset($manager))
            {
                $data->manager = $manager->nik .' - '. $manager->name;
            }

            if(isset($direktur))
            {
                $data->direktur = $direktur->nik .' - '. $direktur->name;
            }

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingOvertimeHrOperation description]
     * @param Request $request [description]
     */
    public function addSettingTrainingGaDepartment(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'training_mengetahui';
            $data->user_id      = $request->id;
            $data->nama_approval= 'GA Department';
            $data->save();

            Session::flash('message-success', 'User Approval successfully added');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingOvertimeHrOperation description]
     * @param Request $request [description]
     */
    public function addSettingTrainingHRD(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'training';
            $data->user_id      = $request->id;
            $data->nama_approval= 'HRD';
            $data->save();

            Session::flash('message-success', 'User Approval successfully added');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

     /**
     * [addSettingOvertimeHrOperation description]
     * @param Request $request [description]
     */
    public function addSettingTrainingFinance(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'training';
            $data->user_id      = $request->id;
            $data->nama_approval= 'Finance';
            $data->save();

            Session::flash('message-success', 'User Approval successfully added');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }


    /**
     * [addInvetarisMobil description]
     * @param Request $request [description]
     */
    public function addInvetarisMobil(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\UserInvetarisMobil();
            $data->user_id      = $request->user_id;
            $data->tipe_mobil   = $request->tipe_mobil;
            $data->tahun        = $request->tahun;
            $data->no_polisi    = $request->no_polisi;
            $data->status_mobil = $request->status_mobil;
            $data->save();
            
            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addtSettingCutiPersonalia description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function addtSettingCutiPersonalia(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'cuti';
            $data->user_id      = $request->id;
            $data->nama_approval= 'Personalia';
            $data->save();

            Session::flash('message-success', 'User Approval successfully added');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addtSettingCutiAtasan description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function addtSettingCutiAtasan(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'cuti';
            $data->user_id      = $request->id;
            $data->nama_approval= 'Atasan';
            $data->save();
            
            Session::flash('message-success', 'User Approval successfully added');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getKaryawanById description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getKaryawanById(Request $request)
    {
        if($request->ajax())
        {
            $data = User::where('id', $request->id)->first();

            $data->department_name  = isset($data->department) ? $data->department->name : '';
            $data->cabang_name      = isset($data->cabang->name) ? $data->cabang->name : '';

            $data->dependent =  \App\UserFamily::where('user_id', $data->id)->get();
            $data->jabatan      = empore_jabatan($request->id);

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getKabupateByProvinsi description]
     * @return [type] [description]
     */
    public function getKabupatenByProvinsi(Request $request)
    {
        if($request->ajax())
        {
            $kabupaten = Kabupaten::where('id_prov', $request->id)->get();

            return response()->json(['message' => 'success', 'data' => $kabupaten]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getKecamatanByKabupaten description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getKecamatanByKabupaten(Request $request)
    {
        if($request->ajax())
        {
            $kabupaten = Kecamatan::where('id_kab', $request->id)->get();

            return response()->json(['message' => 'success', 'data' => $kabupaten]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getKelurahanByKecamatan description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getKelurahanByKecamatan(Request $request)
    {
        if($request->ajax())
        {
            $kabupaten = Kelurahan::where('id_kec', $request->id)->get();

            return response()->json(['message' => 'success', 'data' => $kabupaten]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getDivisionByDirectorate description]
     * @return [type] [description]
     */
    public function getDepartmentByDivision(Request $request)
    {
        if($request->ajax())
        {
            $data = Department::where('division_id', $request->id)->get();
        
            return response()->json(['message'=> 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getDepartmentByDivision description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getSectionByDepartment(Request $request)
    {
        if($request->ajax())
        {
            $data = Section::where('department_id', $request->id)->get();
        
            return response()->json(['message'=> 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getDivisionByDirectorate description]
     * @return [type] [description]
     */
    public function getDivisionByDirectorate(Request $request)
    {
        if($request->ajax())
        {
            $data = Division::where('directorate_id', $request->id)->get();
        
            return response()->json(['message'=> 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getStructureBranch description]
     * @return [type] [description]
     */
    public function getStructureBranch()
    {
        foreach(\App\BranchHead::all() as $k => $item)
        {
            $data[$k]['name'] = 'Head';
            $data[$k]['title'] = $item->name;
            $data[$k]['children'] = [];

            foreach(\App\BranchStaff::where('branch_head_id', $item->id)->get() as $k2 => $i2)
            {
                $data[$k]['children'][$k2]['title'] = $i2->name;
                $data[$k]['children'][$k2]['name'] = 'Staff';
            }
        }

        return response()->json($data);
    }

   

    /**
     * [getStructure description]
     * @return [type] [description]
     */
    public function getStructure()
    {
        $data = [];

        $directorate = \App\EmporeOrganisasiDirektur::all();
        foreach($directorate as $key_dir => $dir)
        {
            $data['name'] = 'Director';
            $data['title'] = $dir->name;
            $data['children'] = [];

            $num_key_div = 0;
            foreach(\App\EmporeOrganisasiManager::where('empore_organisasi_direktur_id', $dir->id)->get() as $key_div => $div)
            {
                $data['children'][$key_div]['name'] = 'Manager';
                $data['children'][$key_div]['title'] = $div->name;

                foreach(\App\EmporeOrganisasiSupervisor::where('empore_organisasi_manager_id', $div->id)->get() as $key_dept => $dept)
                {
                    $data['children'][$key_div]['children'][$key_dept]['name'] = 'Supervisor';
                    $data['children'][$key_div]['children'][$key_dept]['title'] = $dept->name;

                    foreach(\App\EmporeOrganisasiStaff::where('empore_organisasi_supervisor_id', $dept->id)->get() as $key_staff => $staff)
                    {
                        $data['children'][$key_div]['children'][$key_dept]['children'][$key_staff]['name'] = 'Staff';
                        $data['children'][$key_div]['children'][$key_dept]['children'][$key_staff]['title'] = $staff->name;
                        $data['children'][$key_div]['children'][$key_dept]['children'][$key_staff]['title'] = $staff->name;
                    }
                }
                $num_key_div++;
            }
        }

        return response()->json($data);
    } 

}