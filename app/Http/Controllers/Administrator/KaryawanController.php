<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Department;
use App\Provinsi;
use App\UserEducation;
use App\Kabupaten;
use App\Kecamatan;
use App\Kelurahan;
use App\Division;
use App\Section;

class KaryawanController extends Controller
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
        $params['data'] = User::where('access_id', 2)->orderBy('id', 'DESC')->get();

        return view('administrator.karyawan.index')->with($params);
    }
    /**
     * [gengerateFileKontrak description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    

    /**
     * [printProfile description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function printProfile($id)
    {
        $params['data'] = \App\User::where('id', $id)->first();

        $view = view('administrator.karyawan.print')->with($params);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream();
    }

    /**
     * [importAll description]
     * @return [type] [description]
     */
    public function importAll()
    {
        $temp = \App\UserTemp::all();
        foreach($temp as $item)
        {
            $cekuser = \App\User::where('nik', $item->nik)->first();

            if($cekuser) {
                $user  = $cekuser;
            }
            else
            {
                $user               = new \App\User();
                $user->nik          = $item->nik;
                $user->password         = bcrypt('password'); // set default password
            }
            $user->name         = empty($item->name) ? $user->name : $item->name;
            $user->join_date    = empty($item->join_date) ? $user->join_date : $item->join_date;
            $user->jenis_kelamin= empty($item->gender) ? $user->jenis_kelamin : $item->gender;
            $user->marital_status   = empty($item->marital_status) ? $user->marital_status : $item->marital_status;
            $user->agama        = empty($item->agama) ? $user->agama : $item->agama;
            $user->bpjs_number= empty($item->bpjs_number) ? $user->bpjs_number : $item->bpjs_number;
            $user->jamsostek_number= empty($item->jamsostek_number) ? $user->jamsostek_number : $item->jamsostek_number;
            $user->tempat_lahir     = empty($item->place_of_birth) ? $user->tempat_lahir : $item->place_of_birth ;
            $user->tanggal_lahir    = empty($item->date_of_birth) ? $user->tanggal_lahir : $item->date_of_birth ;
            $user->id_address       = empty($item->id_address) ? $user->id_address : $item->id_address;
            $user->id_city          = empty($item->id_city) ? $user->id_city : $item->id_city;
            $user->id_zip_code      = empty($item->id_zip_code) ? $user->id_zip_code : $item->id_zip_code;
            $user->alamat  = empty($item->alamat) ? $user->alamat : $item->alamat;
            $user->telepon          = empty($item->telp) ? $user->telepon : $item->telp;
            $user->mobile_1         = empty($item->mobile_1) ? $user->mobile_1 : $item->mobile_1;
            $user->mobile_2         = empty($item->mobile_2) ? $user->mobile_2 : $item->mobile_2;
            $user->access_id        = 2;
            $user->status           = 1;
            $user->blood_type       = empty($item->blood_type) ? $user->blood_type : $item->blood_type;
            $user->ktp_number       = empty($item->ktp_number) ? $user->ktp_number : $item->ktp_number;
            $user->passport_number  = empty($item->passport_number) ? $user->passport_number : $item->passport_number;
            $user->kk_number        = empty($item->kk_number) ? $user->kk_number : $item->kk_number;
            $user->npwp_number      = empty($item->npwp_number) ? $user->npwp_number : $item->npwp_number;
            $user->ext              = empty($item->ext) ? $user->ext : $item->ext;
            if($item->email != "-") $user->email            = $item->email;

            // find bank
            $bank  = \App\Bank::where('name', 'LIKE', '%'. $item->bank_1 .'%')->first();
            if($bank) $user->bank_id = $bank->id;
            $user->nama_rekening        = $item->bank_account_name_1;
            $user->nomor_rekening       = $item->bank_account_number;

            $user->sisa_cuti            = $item->cuti_sisa_cuti;
            $user->cuti_yang_terpakai   = $item->cuti_terpakai;
            $user->length_of_service    = $item->cuti_length_of_service;
            $user->cuti_status          = $item->cuti_status;
            $user->cuti_2018            = $item->cuti_cuti_2018;

            // get division
            $user->division_id      = $item->organisasi_division;
            $user->department_id    = $item->organisasi_department;
            $user->section_id       = $item->organisasi_unit;
            $user->organisasi_job_role       = $item->organisasi_position_sub;
            $user->organisasi_position       = $item->organisasi_position;

            $user->cabang_id            = empty($item->organisasi_branch) ? $user->cabang_id : $item->organisasi_branch;
            $user->branch_type          = strtoupper(empty($item->organisasi_ho_or_branch) ? $user->branch_type : $item->organisasi_ho_or_branch);
            $user->organisasi_status    = empty($item->organisasi_status) ? $user->organisasi_status : $item->organisasi_status ;

            if(!empty($item->empore_organisasi_direktur))
            {
                $user->empore_organisasi_direktur   = $item->empore_organisasi_direktur;
            }

            if(!empty($item->empore_organisasi_manager_id))
            {
                $user->empore_organisasi_manager_id = $item->empore_organisasi_manager_id;
            }
            if(!empty($item->empore_organisasi_supervisor_id))
            {
                $user->empore_organisasi_supervisor_id = $item->empore_organisasi_supervisor_id;
            }

            if(!empty($item->empore_organisasi_staff_id))
            {
                $user->empore_organisasi_staff_id   = $item->empore_organisasi_staff_id;
            }

            $user->save();

            if(!empty($item->cuti_cuti_2018) || !empty($item->cuti_terpakai) || !empty($item->cuti_sisa_cuti))
            {
                // cek exist cuti
                $c = \App\UserCuti::where('user_id', $user->id)->where('cuti_id', 1)->first();
                if(!$c)
                {
                    // insert data cuti
                    $c = new \App\UserCuti();
                    $c->user_id     = $user->id;
                }

                $c->cuti_id     = 1;
                if(!empty($item->cuti_status))
                {
                    $c->status      = $item->cuti_status;
                }

                if(!empty($item->cuti_cuti_2018))
                {
                    $c->kuota       = $item->cuti_cuti_2018;
                }

                if(!empty($item->cuti_terpakai))
                {
                    $c->cuti_terpakai= $item->cuti_terpakai;
                }

                if(!empty($item->cuti_sisa_cuti))
                {
                    $c->sisa_cuti   = $item->cuti_sisa_cuti;
                }

                if(!empty($item->cuti_length_of_service))
                {
                    $c->length_of_service= $item->cuti_length_of_service;
                }

                $c->save();
            }

            // EDUCATION
            foreach(\App\UserEducationTemp::where('user_temp_id', $item->id)->get() as $edu)
            {
                if($edu->pendidikan == "") continue;

                // cek pendidikan
                $education = \App\UserEducation::where('user_id', $user->id)->where('pendidikan', $edu->pendidikan)->first();

                if(empty($education))
                {
                    $education                  = new \App\UserEducation();
                    $education->user_id         = $user->id;
                    $education->pendidikan      = !empty($edu->pendidikan) ? $edu->pendidikan : $education->pendidikan;
                    $education->tahun_awal      = !empty($edu->tahun_awal) ? $edu->tahun_awal : $education->tahun_awal;
                    $education->tahun_akhir     = !empty($edu->tahun_akhir) ? $edu->tahun_akhir : $education->tahun_akhir;
                    $education->fakultas        = !empty($edu->fakultas) ? $edu->fakultas : $education->fakultas;
                    $education->jurusan         = !empty($edu->jurusan) ? $edu->jurusan : $education->jurusan;
                    $education->nilai           = !empty($edu->nilai) ? $edu->nilai : $education->nilai;
                    $education->kota            = !empty($edu->kota) ? $edu->kota : $education->kota;
                    $education->save();
                }

                
            }

            // FAMILY
            foreach(\App\UserFamilyTemp::where('user_temp_id', $item->id)->get() as $fa)
            {
                if($fa->nama == "") continue;

                $family     = \App\UserFamily::where('user_id', $user->id)->where('hubungan', $fa->hubungan)->first();

                if(empty($family))
                {
                    $family                 = new \App\UserFamily();
                    $family->user_id        = $user->id;
                    $family->nama           = !empty($fa->nama) ? $fa->nama : $family->nama;
                    $family->hubungan       = !empty($fa->hubungan) ? $fa->hubungan : $family->hubungan;
                    $family->tempat_lahir   = !empty($fa->tempat_lahir) ? $fa->tempat_lahir : $family->tempat_lahir;
                    $family->tanggal_lahir  = !empty($fa->tanggal_lahir) ? $fa->tanggal_lahir : $family->tanggal_lahir;
                    $family->jenjang_pendidikan= !empty($fa->jenjang_pendidikan) ? $fa->jenjang_pendidikan : $family->jenjang_pendidikan;
                    $family->pekerjaan      = !empty($fa->pekerjaan) ? $fa->pekerjaan : $family->pekerjaan;
                    $family->save();
                }

                
            }
        }

        // delete all table temp
        \App\UserTemp::truncate();
        \App\UserEducationTemp::truncate();
        \App\UserFamilyTemp::truncate();

        return redirect()->route('administrator.karyawan.index')->with('message-success', 'Employee data successfully import');
    }

    /**
     * [import description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function importData(Request $request)
    {
        if($request->hasFile('file'))
        {
            //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = [];
            foreach ($worksheet->getRowIterator() AS $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                $cells = [];
                foreach ($cellIterator as $cell) {
                    $cells[] = $cell->getValue();
                }
                $rows[] = $cells;
            }

            // delete all table temp
            \App\UserTemp::truncate();
            \App\UserEducationTemp::truncate();
            \App\UserFamilyTemp::truncate();

            foreach($rows as $key => $item)
            {
                if($key >= 3)
                {
                    $user = new \App\UserTemp();

                    /**
                     * FIND USER
                     *
                     */
                    $find_user = \App\User::where('nik', $item[2])->first();
                    if($find_user)
                    {
                        $user->user_id = $find_user->id;
                    }
                    $user->nik              = $item[0];
                    $user->name             = strtoupper($item[1]);
                   
                    if(!empty($item[2])){
                         $user->join_date        = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[2]);
                    }


                    if($item[3] == 'Male' || $item[3] == 'male' || $item[3] == 'Laki-laki' || $item[3]=='laki-laki' || $item[3]=='Laki-Laki'|| strtoupper($item[3]) == 'LAKI-LAKI' || strtoupper($item[3]) == 'PRIA')
                    {
                        $user->gender           = 'Male';
                    }

                    if($item[3] == 'Female' || $item[3] == 'female' || $item[3] == 'Perempuan' || $item[3] == 'perempuan' || strtoupper($item[3]) == 'PEREMPUAN' || strtoupper($item[3]) == 'WANITA')
                    {
                        $user->gender           = 'Female';
                    }


                    $user->marital_status   = $item[4];

                    $agama = $item[5];

                    if(strtoupper($agama)=='ISLAM'){
                      $agama = 'Muslim';
                    }

                    $user->agama            = $agama;
                    $user->ktp_number       = $item[6];
                    $user->passport_number  = $item[7];
                    $user->kk_number        = $item[8];
                    $user->npwp_number      = $item[9];
                    $user->bpjs_number = $item[10];
                    $user->jamsostek_number = $item[11];
                    $user->place_of_birth   = strtoupper($item[12]);

                    if(!empty($item[13])){
                        $user->date_of_birth    = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[13]);
                    }
                    
                    $user->id_address       = strtoupper($item[14]);

                    // find city
                    $kota = \App\Kabupaten::where('nama', 'LIKE', $item[15])->first();

                    if(isset($kota))
                        $user->id_city          = $kota->id_kab;
                    else
                        $user->id_city          = $item[15];

                    $user->id_zip_code      = $item[16];
                    $user->alamat  = strtoupper($item[17]);
                    $user->telp             = $item[18];
                    $user->ext              = $item[19];
                    $user->mobile_1         = $item[20];
                    $user->mobile_2         = $item[21];
                    $user->email            = $item[22];
                    $user->blood_type       = $item[23];
                    $user->bank_1           = $item[24];
                    $user->bank_account_name_1= $item[25];
                    $user->bank_account_number= $item[26];

                    if(!empty($item[27]))
                    {
                        $direktur = \App\EmporeOrganisasiDirektur::where('name', 'LIKE', '%'. $item[27] .'%')->first();
                        if(!$direktur)
                        {
                            $direktur = new \App\EmporeOrganisasiDirektur();
                            $direktur->name =  $item[27];
                            $direktur->save();
                        }

                        $user->empore_organisasi_direktur = $direktur->id;

                        if(!empty($item[28]))
                        {
                            $manager = \App\EmporeOrganisasiManager::where('name', 'LIKE', '%'. $item[28] .'%')->where('empore_organisasi_direktur_id', $direktur->id)->first();
                            if(!$manager)
                            {
                                $manager = new \App\EmporeOrganisasiManager();
                                $manager->empore_organisasi_direktur_id = $direktur->id;
                                $manager->name =  $item[28];
                                $manager->save();
                            }

                            $user->empore_organisasi_manager_id = $manager->id;
                        }

                        if(!empty($item[29]))
                        {
                            $supervisor = \App\EmporeOrganisasiSupervisor::where('name', 'LIKE', '%'. $item[29] .'%')->where('empore_organisasi_manager_id', $manager->id)->first();
                            if(!$supervisor)
                            {
                                $supervisor = new \App\EmporeOrganisasiSupervisor();
                                $supervisor->empore_organisasi_manager_id = $manager->id;
                                $supervisor->name =  $item[29];
                                $supervisor->save();
                            }

                            $user->empore_organisasi_supervisor_id = $supervisor->id;
                        }

                        if(!empty($item[30]))
                        {
                            $staff = \App\EmporeOrganisasiStaff::where('name', 'LIKE', $item[30])->first();
                            if(!$staff)
                            {
                                $staff = new \App\EmporeOrganisasiStaff();
                                $staff->name =  $item[30];
                                $staff->save();
                            }

                            $user->empore_organisasi_staff_id = $staff->id;
                        }
                    }

                    $cabang = \App\Cabang::where('name', 'LIKE', '%'. strtoupper($item[31]) .'%')->first();
                    if($cabang)
                    {
                        $user->organisasi_branch    = $cabang->id;
                    }
                    else
                    {
                        $cabang = new \App\Cabang();
                        $cabang->name = $item[31];
                        $cabang->save();

                        $user->organisasi_branch    = $cabang->id;
                    }

                    $user->organisasi_ho_or_branch= $item[32];
                    $user->organisasi_status    = $item[33];
                    $user->cuti_length_of_service = $item[34];
                    $user->cuti_cuti_2018       = $item[35];
                    $user->cuti_terpakai        = $item[36];
                    $user->cuti_sisa_cuti       = $item[37];
                    $user->save();

                    // SD
                    if(!empty($item[38])){
                        $education                  = new \App\UserEducationTemp();
                        $education->user_temp_id    = $user->id;
                        $education->pendidikan      = "SD";
                        $education->tahun_awal      = $item[38];
                        $education->tahun_akhir     = $item[39];
                        $education->fakultas        = strtoupper($item[40]);
                        $education->kota            = strtoupper($item[41]); // CITY
                        $education->jurusan         = strtoupper($item[42]); // MAJOR
                        $education->nilai           = $item[43]; // GPA
                        $education->certificate     = $item[44];
                        $education->note            = strtoupper($item[45]);
                        $education->save();
                    }
                    if(!empty($item[46])){
                        $education                  = new \App\UserEducationTemp();
                        $education->user_temp_id    = $user->id;
                        $education->pendidikan      = "SMP";
                        $education->tahun_awal      = $item[46];
                        $education->tahun_akhir     = $item[47];
                        $education->fakultas        = strtoupper($item[48]);
                        $education->kota            = strtoupper($item[49]); // CITY
                        $education->jurusan         = strtoupper($item[50]); // MAJOR
                        $education->nilai           = $item[51]; // GPA
                        $education->certificate     = $item[52];
                        $education->note            = strtoupper($item[53]);
                        $education->save();
                    }
                    if(!empty($item[54])){
                        $education                  = new \App\UserEducationTemp();
                        $education->user_temp_id    = $user->id;
                        $education->pendidikan      = "SMA";
                        $education->tahun_awal      = $item[54];
                        $education->tahun_akhir     = $item[55];
                        $education->fakultas        = strtoupper($item[56]);
                        $education->kota            = strtoupper($item[57]); // CITY
                        $education->jurusan         = strtoupper($item[58]); // MAJOR
                        $education->nilai           = $item[59]; // GPA
                        $education->certificate     = $item[60];
                        $education->note            = strtoupper($item[61]);
                        $education->save();
                    }
                    if(!empty($item[62])){
                        $education                  = new \App\UserEducationTemp();
                        $education->user_temp_id    = $user->id;
                        $education->pendidikan      = "DIPLOMA";
                        $education->tahun_awal      = $item[62];
                        $education->tahun_akhir     = $item[63];
                        $education->fakultas        = strtoupper($item[64]);
                        $education->kota            = strtoupper($item[65]); // CITY
                        $education->jurusan         = strtoupper($item[66]); // MAJOR
                        $education->nilai           = $item[67]; // GPA
                        $education->certificate     = $item[68];
                        $education->note            = strtoupper($item[69]);
                        $education->save();
                    }
                    if(!empty($item[70])){
                        $education                  = new \App\UserEducationTemp();
                        $education->user_temp_id    = $user->id;
                        $education->pendidikan      = "S1";
                        $education->tahun_awal      = $item[70];
                        $education->tahun_akhir     = $item[71];
                        $education->fakultas        = strtoupper($item[72]);
                        $education->kota            = strtoupper($item[73]); // CITY
                        $education->jurusan         = strtoupper($item[74]); // MAJOR
                        $education->nilai           = $item[75]; // GPA
                        $education->certificate     = $item[76];
                        $education->note            = strtoupper($item[77]);
                        $education->save();
                    }
                    if(!empty($item[78])){
                        $education                  = new \App\UserEducationTemp();
                        $education->user_temp_id    = $user->id;
                        $education->pendidikan      = "S2";
                        $education->tahun_awal      = $item[78];
                        $education->tahun_akhir     = $item[79];
                        $education->fakultas        = strtoupper($item[80]);
                        $education->kota            = strtoupper($item[81]); // CITY
                        $education->jurusan         = strtoupper($item[82]); // MAJOR
                        $education->nilai           = $item[83]; // GPA
                        $education->certificate     = $item[84];
                        $education->note            = strtoupper($item[85]);
                        $education->save();
                    }

                    //ISTRI
                    if(!empty($item[86]))
                    {
                        $family                     = new \App\UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = "Istri";
                        $family->nama               = strtoupper($item[86]);
                        $family->gender             = ($item[87]=='Male' ? 'Laki-laki' : 'Perempuan');
                        $family->tempat_lahir       = strtoupper($item[88]);
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[89]);
                        $family->pekerjaan          = strtoupper($item[90]);
                        $family->note               = strtoupper($item[91]);
                        $family->save();
                    }
                    //SUAMI
                     if(!empty($item[92]))
                    {
                        $family                     = new \App\UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = "Suami";
                        $family->nama               = strtoupper($item[92]);
                        $family->gender             = ($item[93]=='Male' ? 'Laki-laki' : 'Perempuan');
                        $family->tempat_lahir       = strtoupper($item[94]);
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[95]);
                        $family->pekerjaan          = strtoupper($item[96]);
                        $family->note               = strtoupper($item[97]);
                        $family->save();
                    }

                    //Anak 1
                    if(!empty($item[98]))
                    {
                        $family                     = new \App\UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = "Anak 1";
                        $family->nama               = strtoupper($item[98]);
                        $family->gender             = ($item[99]=='Male' ? 'Laki-laki' : 'Perempuan');
                        $family->tempat_lahir       = strtoupper($item[100]);
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[101]);
                        $family->pekerjaan          = strtoupper($item[102]);
                        $family->note               = strtoupper($item[103]);
                        $family->save();
                    }

                    //Anak 2
                    if(!empty($item[104]))
                    {
                        $family                     = new \App\UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = "Anak 2";
                        $family->nama               = strtoupper($item[104]);
                        $family->gender             = ($item[105]=='Male' ? 'Laki-laki' : 'Perempuan');
                        $family->tempat_lahir       = strtoupper($item[106]);
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[107]);
                        $family->pekerjaan          = strtoupper($item[108]);
                        $family->note               = strtoupper($item[109]);
                        $family->save();
                    }

                    //Anak 3
                    if(!empty($item[110]))
                    {
                        $family                     = new \App\UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = "Anak 3";
                        $family->nama               = strtoupper($item[110]);
                        $family->gender             = ($item[111]=='Male' ? 'Laki-laki' : 'Perempuan');
                        $family->tempat_lahir       = strtoupper($item[112]);
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[113]);
                        $family->pekerjaan          = strtoupper($item[114]);
                        $family->note               = strtoupper($item[115]);
                        $family->save();
                    }

                    //Anak 4
                    if(!empty($item[116]))
                    {
                        $family                     = new \App\UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = "Anak 4";
                        $family->nama               = strtoupper($item[116]);
                        $family->gender             = ($item[117]=='Male' ? 'Laki-laki' : 'Perempuan');
                        $family->tempat_lahir       = strtoupper($item[118]);
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[119]);
                        $family->pekerjaan          = strtoupper($item[120]);
                        $family->note               = strtoupper($item[121]);
                        $family->save();
                    }
                    //Anak 5
                    if(!empty($item[122]))
                    {
                        $family                     = new \App\UserFamilyTemp();
                        $family->user_temp_id       = $user->id;
                        $family->hubungan           = "Anak 5";
                        $family->nama               = strtoupper($item[122]);
                        $family->gender             = ($item[123]=='Male' ? 'Laki-laki' : 'Perempuan');
                        $family->tempat_lahir       = strtoupper($item[124]);
                        $family->tanggal_lahir      = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[125]);
                        $family->pekerjaan          = strtoupper($item[126]);
                        $family->note               = strtoupper($item[127]);
                        $family->save();
                    }
                  
                }
            }

            return redirect()->route('administrator.karyawan.preview-import')->with('message-success', 'Data successfully imported');
        }
    }

    /**
     * [previewImport description]
     * @return [type] [description]
     */
    public function previewImport()
    {
        $params['data'] = \App\UserTemp::all();

        return view('administrator.karyawan.preview-import')->with($params);
    }

    /**
     * [deleteDependent description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteDependent($id)
    {
        $data = \App\UserFamily::where('id', $id)->first();
        $id = $data->user_id;
        $data->delete();

        return redirect()->route('administrator.karyawan.edit', $id)->with('message-success', 'Data Dependent successfully deleted !');
    }
    

    /**
     * [deleteEducation description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteEducation($id)
    {
        $data = \App\UserEducation::where('id', $id)->first();
        $id = $data->user_id;
        $data->delete();

        return redirect()->route('administrator.karyawan.edit', $id)->with('message-success', 'Data Education successfully deleted !');
    }

    /**
     * [deleteTemp description]
     * @return [type] [description]
     */
    public function deleteTemp($id)
    {
        $data = \App\UserTemp::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.karyawan.preview-import')->with('message-success', 'Data successfully deleted');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data'] = User::where('id', $id)->first();
        $params['department']       = Department::where('division_id', $params['data']['division_id'])->get();
        $params['provinces']        = Provinsi::all();
        $params['dependent']        = \App\UserFamily::where('user_id', $id)->first();
        $params['education']        = UserEducation::where('user_id', $id)->first();
        $params['kabupaten']        = Kabupaten::where('id_prov', $params['data']['provinsi_id'])->get();
        $params['kecamatan']        = Kecamatan::where('id_kab', $params['data']['kabupaten_id'])->get();
        $params['kelurahan']        = Kelurahan::where('id_kec', $params['data']['kecamatan_id'])->get();
        $params['division']         = Division::all();
        $params['section']          = Section::where('division_id', $params['data']['division_id'])->get();
        $params['list_manager']          = \App\EmporeOrganisasiManager::where('empore_organisasi_direktur_id', $params['data']['empore_organisasi_direktur'])->get();
        $params['list_supervisor']          = \App\EmporeOrganisasiSupervisor::where('empore_organisasi_manager_id', $params['data']['empore_organisasi_manager_id'])->get();
        $params['list_staff']          = \App\EmporeOrganisasiStaff::where('empore_organisasi_supervisor_id', $params['data']['empore_organisasi_supervisor_id'])->get();

        return view('administrator.karyawan.edit')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {
        $params['department']   = Department::all();
        $params['provinces']    = Provinsi::all();
        $params['division']     = Division::all();
        $params['department']   = Department::all();
        $params['section']      = Section::all();

        return view('administrator.karyawan.create')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data       = User::where('id', $id)->first();

        if($request->password != $data->password)
        {
            if(!empty($request->password))
            {
                $this->validate($request,[
                    'confirmation'      => 'same:password',
                ]);

                $data->password             = bcrypt($request->password);
            }
        }

        $data->name         = strtoupper($request->name);
        $data->nik          = $request->nik;
        $data->jenis_kelamin= $request->jenis_kelamin;
        $data->email        = $request->email;
        $data->telepon      = $request->telepon;
        $data->agama        = $request->agama;
        $data->alamat       = $request->alamat;
        $data->access_id    = 2; //
        $data->division_id  = $request->division_id;
        $data->department_id= $request->department_id;
        $data->section_id   = $request->section_id;
        $data->type_jabatan = $request->type_jabatan;
        $data->nama_jabatan = $request->nama_jabatan;
        $data->hak_cuti     = 12;
        $data->cuti_yang_terpakai = 0;
        $data->cabang_id    =$request->cabang_id;
        $data->nama_rekening    = $request->nama_rekening;
        $data->nomor_rekening   = $request->nomor_rekening;
        $data->bank_id          = $request->bank_id;
        $data->join_date        = $request->join_date;
        $data->tempat_lahir     = $request->tempat_lahir;
        $data->tanggal_lahir    = $request->tanggal_lahir;
        $data->ktp_number           = $request->ktp_number;
        $data->passport_number      = $request->passport_number;
        $data->kk_number            = $request->kk_number;
        $data->npwp_number          = $request->npwp_number;
        $data->bpjs_number          = $request->bpjs_number;
        $data->jamsostek_number     = $request->jamsostek_number;
        $data->organisasi_position     = $request->organisasi_position;
        $data->organisasi_job_role     = $request->organisasi_job_role;
        $data->section_id              = $request->section_id;
        $data->organisasi_status    = $request->organisasi_status;
        $data->branch_type          = $request->branch_type;
        $data->ext                  = $request->ext;
        $data->is_pic_cabang        = isset($request->is_pic_cabang) ? $request->is_pic_cabang : 0;
        $data->branch_staff_id      = $request->branch_staff_id;
        $data->branch_head_id       = $request->branch_head_id;
        $data->blood_type           = $request->blood_type;
        $data->marital_status       = $request->marital_status;
        $data->mobile_1             = $request->mobile_1;
        $data->mobile_2             = $request->mobile_2;
        $data->id_address           = $request->id_address;
        $data->id_city              = $request->id_city;
        $data->id_zip_code          = $request->id_zip_code;
        $data->empore_organisasi_direktur   = $request->empore_organisasi_direktur;
        $data->empore_organisasi_manager_id = $request->empore_organisasi_manager_id;
        $data->empore_organisasi_supervisor_id = $request->empore_organisasi_supervisor_id;
        $data->empore_organisasi_staff_id   = $request->empore_organisasi_staff_id;

        if ($request->hasFile('foto'))
        {
            $file = $request->file('foto');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/foto/');
            $file->move($destinationPath, $fileName);

            $data->foto = $fileName;
        }

        $data->save();

        if(isset($request->dependent))
        {
            foreach($request->dependent['nama'] as $key => $item)
            {
                $dep = new \App\UserFamily();
                $dep->user_id           = $data->id;
                $dep->nama          = $request->dependent['nama'][$key];
                $dep->hubungan      = $request->dependent['hubungan'][$key];
                $dep->tempat_lahir  = $request->dependent['tempat_lahir'][$key];
                $dep->tanggal_lahir = $request->dependent['tanggal_lahir'][$key];
                $dep->tanggal_meninggal = $request->dependent['tanggal_meninggal'][$key];
                $dep->jenjang_pendidikan = $request->dependent['jenjang_pendidikan'][$key];
                $dep->pekerjaan = $request->dependent['pekerjaan'][$key];
                $dep->tertanggung = $request->dependent['tertanggung'][$key];
                $dep->save();
            }
        }
        if(isset($request->education))
        {
            foreach($request->education['pendidikan'] as $key => $item)
            {
                $edu = new UserEducation();
                $edu->user_id = $data->id;
                $edu->pendidikan    = $request->education['pendidikan'][$key];
                $edu->tahun_awal    = $request->education['tahun_awal'][$key];
                $edu->tahun_akhir   = $request->education['tahun_akhir'][$key];
                $edu->fakultas      = $request->education['fakultas'][$key];
                $edu->jurusan       = $request->education['jurusan'][$key];
                $edu->nilai         = $request->education['nilai'][$key];
                $edu->kota          = $request->education['kota'][$key];
                $edu->save();
            }
        }

        if(isset($request->cuti))
        {
            // user Education
            foreach($request->cuti['cuti_id'] as $key => $item)
            {
                $c = new \App\UserCuti();
                $c->user_id = $data->id;
                $c->cuti_id    = $request->cuti['cuti_id'][$key];
                $c->kuota    = $request->cuti['kuota'][$key];
                $c->cuti_terpakai    = $request->cuti['terpakai'][$key];
                $c->sisa_cuti    = $request->cuti['kuota'][$key] - $request->cuti['terpakai'][$key];
                $c->save();
            }
        }

        return redirect()->route('administrator.karyawan.edit', $data->id)->with('message-success', 'Data successfully saved');
    }

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data               = new User();

        $this->validate($request,[
            'nik'               => 'required|unique:users',
            //'email'               => 'required|unique:users',
            //'confirmation'      => 'same:password',
        ]);

        $data->password             = bcrypt($request->password);
        $data->nik          = $request->nik;
        $data->name         = strtoupper($request->name);
        $data->jenis_kelamin= $request->jenis_kelamin;
        $data->email        = $request->email;
        $data->ext          = $request->ext;
        $data->telepon      = $request->telepon;
        $data->mobile_1     = $request->mobile_1;
        $data->mobile_2     = $request->mobile_2;
        $data->agama        = $request->agama;
        $data->alamat       = $request->alamat;
        $data->id_address   = $request->id_address;
        $data->access_id    = 2;
        $data->id_city      = $request->id_city;
        $data->id_zip_code  = $request->id_zip_code;
        $data->jabatan_cabang= $request->jabatan_cabang;
        $data->division_id  = $request->division_id;
        $data->department_id= $request->department_id;
        $data->section_id   = $request->section_id;
        $data->type_jabatan = $request->type_jabatan;
        $data->nama_jabatan = $request->nama_jabatan;
        $data->hak_cuti     = 12;
        $data->cuti_yang_terpakai = 0;
        $data->cabang_id    =$request->cabang_id;
        $data->nama_rekening    = $request->nama_rekening;
        $data->nomor_rekening   = $request->nomor_rekening;
        $data->bank_id          = $request->bank_id;
        $data->join_date        = $request->join_date;
        $data->tempat_lahir     = $request->tempat_lahir;
        $data->tanggal_lahir    = $request->tanggal_lahir;
        $data->ktp_number           = $request->ktp_number;
        $data->passport_number      = $request->passport_number;
        $data->kk_number            = $request->kk_number;
        $data->npwp_number          = $request->npwp_number;
        $data->bpjs_number          = $request->bpjs_number;
        $data->jamsostek_number     = $request->jamsostek_number;
        $data->organisasi_position     = $request->organisasi_position;
        $data->organisasi_job_role     = $request->organisasi_job_role;
        $data->section_id              = $request->section_id;
        $data->organisasi_status    = $request->organisasi_status;
        $data->branch_type          = $request->branch_type;
        $data->ext                  = $request->ext;
        $data->is_pic_cabang        = isset($request->is_pic_cabang) ? $request->is_pic_cabang : 0;
        $data->blood_type           = $request->blood_type;
        $data->marital_status           = $request->marital_status;
        $data->empore_organisasi_direktur   = $request->empore_organisasi_direktur;
        $data->empore_organisasi_manager_id = $request->empore_organisasi_manager_id;
        $data->empore_organisasi_supervisor_id = $request->empore_organisasi_supervisor_id;
        $data->empore_organisasi_staff_id   = $request->empore_organisasi_staff_id;

        if (request()->hasFile('foto'))
        {
            $file = $request->file('foto');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/foto/');
            $file->move($destinationPath, $fileName);

            $data->foto = $fileName;
        }

        $data->save();

        // user Dependent
        if(isset($request->dependent))
        {
            foreach($request->dependent['nama'] as $key => $item)
            {
                $dep = new \App\UserFamily();
                $dep->user_id           = $data->id;
                $dep->nama          = $request->dependent['nama'][$key];
                $dep->hubungan      = $request->dependent['hubungan'][$key];
                $dep->tempat_lahir  = $request->dependent['tempat_lahir'][$key];
                $dep->tanggal_lahir = $request->dependent['tanggal_lahir'][$key];
                $dep->tanggal_meninggal = $request->dependent['tanggal_meninggal'][$key];
                $dep->jenjang_pendidikan = $request->dependent['jenjangPendidikan'][$key];
                $dep->pekerjaan = $request->dependent['pekerjaan'][$key];
                $dep->tertanggung = $request->dependent['tertanggung'][$key];
                $dep->save();
            }
        }

        if(isset($request->education))
        {
            // user Education
            foreach($request->education['pendidikan'] as $key => $item)
            {
                $edu = new UserEducation();
                $edu->user_id = $data->id;
                $edu->pendidikan    = $request->education['pendidikan'][$key];
                $edu->tahun_awal    = $request->education['tahun_awal'][$key];
                $edu->tahun_akhir   = $request->education['tahun_akhir'][$key];
                $edu->fakultas      = $request->education['fakultas'][$key];
                $edu->jurusan       = $request->education['jurusan'][$key];
                $edu->nilai         = $request->education['nilai'][$key];
                $edu->kota          = $request->education['kota'][$key];
                $edu->save();
            }
        }

        if(isset($request->cuti))
        {
            // user Education
            foreach($request->cuti['cuti_id'] as $key => $item)
            {
                $c = new \App\UserCuti();
                $c->user_id = $data->id;
                $c->cuti_id    = $request->cuti['cuti_id'][$key];
                $c->kuota    = $request->cuti['kuota'][$key];
                $c->save();
            }
        }

        return redirect()->route('administrator.karyawan.index')->with('message-success', 'Data successfully saved !');
    }

    /**
     * [DeleteCuti description]
     * @param [type] $id [description]
     */
    public function DeleteCuti($id)
    {
        $data = \App\UserCuti::where('id', $id)->first();
        $user_id = $data->user_id;
        $data->delete();

        return redirect()->route('administrator.karyawan.edit', $user_id)->with('message-success', 'Data leave successfully deleted');
    }

    /**
     * [deleteOldUser description]
     * @return [type] [description]
     */
    public function deleteOldUser($id)
    {
        $data = User::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.karyawan.preview-import')->with('message-success', 'Old data successfully deleted');
    }

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = User::where('id', $id)->first();
        $data->delete();

        \App\UserFamily::where('user_id', $id)->delete();

        UserEducation::where('user_id', $id)->delete();

        return redirect()->route('administrator.karyawan.index')->with('message-sucess', 'Data successfully deleted');
    }

    /**
     * [autologin description]
     * @return [type] [description]
     */
    public function autologin($id)
    {   
        \Auth::loginUsingId($id);
        \Session::put('is_login_administrator', true);
        
        return redirect()->route('karyawan.dashboard');
    }

    public function downloadExcel()
    {
        $data       = User::where('access_id', 2)->orderBy('id', 'DESC')->get();
        $params = [];

         $params = [];

        foreach($data as $k =>  $item)
        {
            
            $params[$k]['No']                   = $k+1;
            $params[$k]['NIK']                  = $item->nik;
            $params[$k]['Name']                 = $item->name;
            $params[$k]['Join Date']            = $item->join_date;
            $params[$k]['Gender']               = $item->jenis_kelamin;
            $params[$k]['Maritial Status']      = $item->marital_status;
            $params[$k]['Religion']             = $item->agama;
            $params[$k]['KTP Number']           = $item->ktp_number;
            $params[$k]['Passport Number']      = $item->passport_number;
            $params[$k]['KK Number']            = $item->kk_number;
            $params[$k]['NPWP Number']          = $item->npwp_number;
            $params[$k]['No BPJS Kesehatan']    = $item->jamsostek_number;
            $params[$k]['No BPJS Ketenagakerjaan']  = $item->bpjs_number;
            $params[$k]['Place of Birth']       = $item->tempat_lahir;
            $params[$k]['Date of Birth']        = $item->tanggal_lahir;
            $params[$k]['ID Address']           = $item->id_address;
            $params[$k]['ID City']              = isset($item->kota->nama) ? $item->kota->nama : '';
            $params[$k]['ID Zip Code']          = $item->id_zip_code;
            $params[$k]['Current Address']      = $item->alamat;
            $params[$k]['Telp']                 = $item->telepon;
            $params[$k]['Ext']                  = $item->ext;
            $params[$k]['Mobile 1']             = $item->mobile_1;
            $params[$k]['Mobile 2']             = $item->mobile_2;
            $params[$k]['Email']                = $item->email;
            $params[$k]['Blood Type']           = $item->blood_type;

            if(!empty($item->bank_id)) {
                $params[$k]['Bank ']                = $item->bank->name;
            }elseif (empty($item->bank_id)) {
                $params[$k]['Bank ']                ="";
            }

            $params[$k]['Bank Account Name']    = $item->nama_rekening;
            $params[$k]['Bank Account Number']  = $item->nomor_rekening;

            $pos ="";
            if(!empty($item->empore_organisasi_staff_id)){
                $pos= "Staff";
            }elseif (empty($item->empore_organisasi_staff_id) and !empty($item->empore_organisasi_supervisor_id)) {
                $pos= "Supervisor";
            }elseif (empty($item->empore_organisasi_staff_id) and empty($item->empore_organisasi_supervisor_id) and !empty($item->empore_organisasi_manager_id)) {
                 $pos= "Manager";
            }elseif (empty($item->empore_organisasi_staff_id) and empty($item->empore_organisasi_supervisor_id) and empty($item->empore_organisasi_manager_id) and !empty($item->empore_organisasi_direktur)) {
                 $pos= "Direkitur";
            }

            $params[$k]['Position']             = $pos;

            $jobrule ="";
            if(!empty($item->empore_organisasi_staff_id)){
                $jobrule = isset($item->empore_staff->name) ? $item->empore_staff->name : '';

            }elseif (empty($item->empore_organisasi_staff_id) and !empty($item->empore_organisasi_supervisor_id)) {
                $jobrule = isset($item->empore_supervisor->name) ? $item->empore_supervisor->name : ''; 
            }elseif (empty($item->empore_organisasi_staff_id) and empty($item->empore_organisasi_supervisor_id) and !empty($tem->empore_organisasi_manager_id)) {
                $jobrule = isset($item->empore_manager->name) ? $item->empore_manager->name : '';
            }
                                    
            $params[$k]['Job Rule']             = $jobrule;
            
            $params[$k]['status']               = $item->organisasi_status;

            $sd = UserEducation::where('user_id', $item->id)->where('pendidikan','SD')->first();

            if(!empty($sd)) {
                    $params[$k]['Education SD']           = $sd ->pendidikan;
                    $params[$k]['Start Year SD']          = $sd->tahun_awal;
                    $params[$k]['End Year SD']            = $sd->tahun_akhir;
                    $params[$k]['Institution SD']         = $sd->fakultas;
                    $params[$k]['City Education SD']      = $sd->kota;
                    $params[$k]['Major SD']               = $sd->jurusan;
                    $params[$k]['GPA SD']                 = $sd->nilai;
            } else
            {
                    $params[$k]['Education SD']           = "-";
                    $params[$k]['Start Year SD']          = "-";
                    $params[$k]['End Year SD']            = "-";
                    $params[$k]['Institution SD']         = "-";
                    $params[$k]['City Education SD']      = "-";
                    $params[$k]['Major SD']               = "-";
                    $params[$k]['GPA SD']                 = "-";
            }
            $smp = UserEducation::where('user_id', $item->id)->where('pendidikan','SMP')->first();
            if(!empty($smp)) {
                    $params[$k]['Education SMP']           = $smp ->pendidikan;
                    $params[$k]['Start Year SMP']          = $smp->tahun_awal;
                    $params[$k]['End Year SMP']            = $smp->tahun_akhir;
                    $params[$k]['Institution SMP']         = $smp->fakultas;
                    $params[$k]['City Education SMP']      = $smp->kota;
                    $params[$k]['Major SMP']               = $smp->jurusan;
                    $params[$k]['GPA SMP']                 = $smp->nilai;
            } else
            {
                    $params[$k]['Education SMP']           = "-";
                    $params[$k]['Start Year SMP']          = "-";
                    $params[$k]['End Year SMP']            = "-";
                    $params[$k]['Institution SMP']         = "-";
                    $params[$k]['City Education SMP']      = "-";
                    $params[$k]['Major SMP']               = "-";
                    $params[$k]['GPA SMP']                 = "-";
            }

            $sma = UserEducation::where('user_id', $item->id)->where('pendidikan','SMA')->first();
            if(!empty($sma)) {
                    $params[$k]['Education SMA']           = $sma ->pendidikan;
                    $params[$k]['Start Year SMA']          = $sma->tahun_awal;
                    $params[$k]['End Year SMA']            = $sma->tahun_akhir;
                    $params[$k]['Institution SMA']         = $sma->fakultas;
                    $params[$k]['City Education SMA']      = $sma->kota;
                    $params[$k]['Major SMA']               = $sma->jurusan;
                    $params[$k]['GPA SMA']                 = $sma->nilai;
            } else
            {
                    $params[$k]['Education SMA']           = "-";
                    $params[$k]['Start Year SMA']          = "-";
                    $params[$k]['End Year SMA']            = "-";
                    $params[$k]['Institution SMA']         = "-";
                    $params[$k]['City Education SMA']      = "-";
                    $params[$k]['Major SMA']               = "-";
                    $params[$k]['GPA SMA']                 = "-";
            }

            $diploma = UserEducation::where('user_id', $item->id)->where('pendidikan','DIPLOMA')->first();
            if(!empty($diploma)) {
                    $params[$k]['Education DIPLOMA']           = $diploma ->pendidikan;
                    $params[$k]['Start Year DIPLOMA']          = $diploma->tahun_awal;
                    $params[$k]['End Year DIPLOMA']            = $diploma->tahun_akhir;
                    $params[$k]['Institution DIPLOMA']         = $diploma->fakultas;
                    $params[$k]['City Education DIPLOMA']      = $diploma->kota;
                    $params[$k]['Major DIPLOMA']               = $diploma->jurusan;
                    $params[$k]['GPA DIPLOMA']                 = $diploma->nilai;
            } else
            {
                    $params[$k]['Education DIPLOMA']           = "-";
                    $params[$k]['Start Year DIPLOMA']          = "-";
                    $params[$k]['End Year DIPLOMA']            = "-";
                    $params[$k]['Institution DIPLOMA']         = "-";
                    $params[$k]['City Education DIPLOMA']      = "-";
                    $params[$k]['Major DIPLOMA']               = "-";
                    $params[$k]['GPA DIPLOMA']                 = "-";
            }

            $s1 = UserEducation::where('user_id', $item->id)->where('pendidikan','S1')->first();
            if(!empty($s1)) {
                    $params[$k]['Education S1']           = $s1 ->pendidikan;
                    $params[$k]['Start Year S1']          = $s1->tahun_awal;
                    $params[$k]['End Year S1']            = $s1->tahun_akhir;
                    $params[$k]['Institution S1']         = $s1->fakultas;
                    $params[$k]['City Education S1']      = $s1->kota;
                    $params[$k]['Major S1']               = $s1->jurusan;
                    $params[$k]['GPA S1']                 = $s1->nilai;
            } else
            {
                    $params[$k]['Education S1']           = "-";
                    $params[$k]['Start Year S1']          = "-";
                    $params[$k]['End Year S1']            = "-";
                    $params[$k]['Institution S1']         = "-";
                    $params[$k]['City Education S1']      = "-";
                    $params[$k]['Major S1']               = "-";
                    $params[$k]['GPA S1']                 = "-";
            }

            $s2 = UserEducation::where('user_id', $item->id)->where('pendidikan','S2')->first();
            if(!empty($s2)) {
                    $params[$k]['Education S2']           = $s2 ->pendidikan;
                    $params[$k]['Start Year S2']          = $s2->tahun_awal;
                    $params[$k]['End Year S2']            = $s2->tahun_akhir;
                    $params[$k]['Institution S2']         = $s2->fakultas;
                    $params[$k]['City Education S2']      = $s2->kota;
                    $params[$k]['Major S2']               = $s2->jurusan;
                    $params[$k]['GPA S2']                 = $s2->nilai;
            } else
            {
                    $params[$k]['Education S2']           = "-";
                    $params[$k]['Start Year S2']          = "-";
                    $params[$k]['End Year S2']            = "-";
                    $params[$k]['Institution S2']         = "-";
                    $params[$k]['City Education S2']      = "-";
                    $params[$k]['Major S2']               = "-";
                    $params[$k]['GPA S2']                 = "-";
            }
            
            $istri = \App\UserFamily::where('user_id', $item->id)->where('hubungan','Istri')->first();
            if(!empty($istri)) {
                    $params[$k]['Relative Name Istri']           = $istri ->nama;
                    $params[$k]['Place of birth Istri']          = $istri->tempat_lahir;
                    $params[$k]['Date of birth Istri']           = $istri->tanggal_lahir;
                    $params[$k]['Education level Istri']         = $istri->jenjang_pendidikan;
                    $params[$k]['Occupation Istri']              = $istri->pekerjaan;
            } else
            {       
                    $params[$k]['Relative Name Istri']           = "-";
                    $params[$k]['Place of birth Istri']          = "-";
                    $params[$k]['Date of birth Istri']           = "-";
                    $params[$k]['Education level Istri']         = "-";
                    $params[$k]['Occupation Istri']              = "-";
            }

            $suami = \App\UserFamily::where('user_id', $item->id)->where('hubungan','Suami')->first();
            if(!empty($suami)) {
                    $params[$k]['Relative Name Suami']           = $suami ->nama;
                    $params[$k]['Place of birth Suami']          = $suami->tempat_lahir;
                    $params[$k]['Date of birth Suami']           = $suami->tanggal_lahir;
                    $params[$k]['Education level Suami']         = $suami->jenjang_pendidikan;
                    $params[$k]['Occupation Suami']              = $suami->pekerjaan;
            } else
            {       
                    $params[$k]['Relative Name Suami']           = "-";
                    $params[$k]['Place of birth Suami']          = "-";
                    $params[$k]['Date of birth Suami']           = "-";
                    $params[$k]['Education level Suami']         = "-";
                    $params[$k]['Occupation Suami']              = "-";
            }

            $anak1 = \App\UserFamily::where('user_id', $item->id)->where('hubungan','Anak 1')->first();
            if(!empty($anak1)) {
                    $params[$k]['Relative Name Anak 1']           = $anak1 ->nama;
                    $params[$k]['Place of birth Anak 1']          = $anak1->tempat_lahir;
                    $params[$k]['Date of birth Anak 1']           = $anak1->tanggal_lahir;
                    $params[$k]['Education level Anak 1']         = $anak1->jenjang_pendidikan;
                    $params[$k]['Occupation Anak 1']              = $anak1->pekerjaan;
            } else
            {       
                    $params[$k]['Relative Name Anak 1']           = "-";
                    $params[$k]['Place of birth Anak 1']          = "-";
                    $params[$k]['Date of birth Anak 1']           = "-";
                    $params[$k]['Education level Anak 1']         = "-";
                    $params[$k]['Occupation Anak 1']              = "-";
            }

            $anak2 = \App\UserFamily::where('user_id', $item->id)->where('hubungan','Anak 2')->first();
            if(!empty($anak2)) {
                    $params[$k]['Relative Name Anak 2']           = $anak2 ->nama;
                    $params[$k]['Place of birth Anak 2']          = $anak2->tempat_lahir;
                    $params[$k]['Date of birth Anak 2']           = $anak2->tanggal_lahir;
                    $params[$k]['Education level Anak 2']         = $anak2->jenjang_pendidikan;
                    $params[$k]['Occupation Anak 2']              = $anak2->pekerjaan;
            } else
            {       
                    $params[$k]['Relative Name Anak 2']           = "-";
                    $params[$k]['Place of birth Anak 2']          = "-";
                    $params[$k]['Date of birth Anak 2']           = "-";
                    $params[$k]['Education level Anak 2']         = "-";
                    $params[$k]['Occupation Anak 2']              = "-";
            }

            $anak3 = \App\UserFamily::where('user_id', $item->id)->where('hubungan','Anak 3')->first();
            if(!empty($anak3)) {
                    $params[$k]['Relative Name Anak 3']           = $anak3 ->nama;
                    $params[$k]['Place of birth Anak 3']          = $anak3->tempat_lahir;
                    $params[$k]['Date of birth Anak 3']           = $anak3->tanggal_lahir;
                    $params[$k]['Education level Anak 3']         = $anak3->jenjang_pendidikan;
                    $params[$k]['Occupation Anak 3']              = $anak3->pekerjaan;
            } else
            {       
                    $params[$k]['Relative Name Anak 3']           = "-";
                    $params[$k]['Place of birth Anak 3']          = "-";
                    $params[$k]['Date of birth Anak 3']           = "-";
                    $params[$k]['Education level Anak 3']         = "-";
                    $params[$k]['Occupation Anak 3']              = "-";
            }

            $anak4 = \App\UserFamily::where('user_id', $item->id)->where('hubungan','Anak 4')->first();
            if(!empty($anak4)) {
                    $params[$k]['Relative Name Anak 4']           = $anak4 ->nama;
                    $params[$k]['Place of birth Anak 4']          = $anak4->tempat_lahir;
                    $params[$k]['Date of birth Anak 4']           = $anak4->tanggal_lahir;
                    $params[$k]['Education level Anak 4']         = $anak4->jenjang_pendidikan;
                    $params[$k]['Occupation Anak 4']              = $anak4->pekerjaan;
            } else
            {       
                    $params[$k]['Relative Name Anak 4']           = "-";
                    $params[$k]['Place of birth Anak 4']          = "-";
                    $params[$k]['Date of birth Anak 4']           = "-";
                    $params[$k]['Education level Anak 4']         = "-";
                    $params[$k]['Occupation Anak 4']              = "-";
            }

            $anak5 = \App\UserFamily::where('user_id', $item->id)->where('hubungan','Anak 5')->first();
            if(!empty($anak5)) {
                    $params[$k]['Relative Name Anak 5']           = $anak5 ->nama;
                    $params[$k]['Place of birth Anak 5']          = $anak5->tempat_lahir;
                    $params[$k]['Date of birth Anak 5']           = $anak5->tanggal_lahir;
                    $params[$k]['Education level Anak 5']         = $anak5->jenjang_pendidikan;
                    $params[$k]['Occupation Anak 5']              = $anak5->pekerjaan;
            } else
            {       
                    $params[$k]['Relative Name Anak 5']           = "-";
                    $params[$k]['Place of birth Anak 5']          = "-";
                    $params[$k]['Date of birth Anak 5']           = "-";
                    $params[$k]['Education level Anak 5']         = "-";
                    $params[$k]['Occupation Anak 5']              = "-";
            }
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

        return \Excel::create('Report-Employee',  function($excel) use($params, $styleHeader){
              $excel->sheet('mysheet',  function($sheet) use($params){
                $sheet->fromArray($params);
              });
            $excel->getActiveSheet()->getStyle('A1:DF1')->applyFromArray($styleHeader);
        })->download('xls');
    }

}
