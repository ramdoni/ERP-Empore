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

            \Session::flash('message-success', 'Password berhasil di rubah');
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

            \Session::flash('message-success', 'Data Cuti Berhasil di update');
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

            \Session::flash('message-success', 'Data Inventaris Berhasil di update');
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

            \Session::flash('message-success', 'Data Cuti Berhasil di update');
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

            \Session::flash('message-success', 'Data Education Berhasil di update');
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

            \Session::flash('message-success', 'Data Dependent Berhasil di update');
        }   
        
        return response()->json($params);
    }

    /**
     * [getBulangPaySlip description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getBulangPaySlip(Request $request)
    {
        $params = [];
        if($request->ajax())
        {
            //$params = \App\Payroll::select(\DB::raw('month(created_at) as bulan'))->whereYear('created_at', '=', $request->tahun)->where('user_id', $request->user_id)->get();

            $params = \App\User::select(\DB::raw('month(join_date) as bulan'))->whereYear('join_date', '=', $request->tahun)->where('id', $request->user_id)->first();

            $bulanArray = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Augustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
            
            $bulan = [];
            for($b = $params->bulan; $b <= date('m'); $b++)
            {
                $bulan[$b]['id'] = $b;
                $bulan[$b]['name'] = $bulanArray[$b];
            }
        }

        return response()->json($bulan);
    }

    /**
     * [getCalculatePayroll description]
     * @return [type] [description]
     */
    public function getCalculatePayroll(Request $request)
    {
        $biaya_jabatan = \App\PayrollOthers::where('id', 1)->first()->value;
        $upah_minimum = \App\PayrollOthers::where('id', 2)->first()->value;
        
        $params = [];
        if($request->ajax())
        {
            $jkk_result = 0;
            if(!empty($request->jkk))
            {
                $jkk_result             = ($request->salary * $request->jkk / 100);                
            }

            // Salary + Call allowance + Yearly Bonus THR or others + Transport allowance + Homebase allowance + Laptop allowance + Other income + Medical Claim + Overtime Claim.
            $overtime_claim = $request->ot_multiple_hours / 173 * $request->salary;
            
            //$gross_income = ($request->salary + $request->homebase_allowance + $request->laptop_allowance + $request->other_income + $request->medical_claim +  $overtime_claim) * 12 + $request->bonus;

            $gross_income = ($request->salary + $jkk_result + $request->call_allow + $request->transport_allowance + $request->homebase_allowance + $request->laptop_allowance + $request->other_income + $overtime_claim ) * 12 + $request->bonus;

            // burdern allowance
            $burden_allow = 5 * $gross_income / 100;
            if($burden_allow > $biaya_jabatan)
            {
                $burden_allow = $biaya_jabatan;
            }

            // Jamsostek Premium
            $jamsostek = 0;
            $jamsostek_persen = 3;
            if($request->salary > $upah_minimum)
            {
                $jamsostek = ($request->salary * $jamsostek_persen / 100) * 12;
            }
            else
            {
                $jamsostek = ($upah_minimum * $jamsostek_persen / 100) * 12;

            }

            $total_deduction = $jamsostek + $burden_allow;

            $net_yearly_income          = $gross_income - $total_deduction;

            $untaxable_income = 0;

            $ptkp = \App\PayrollPtkp::where('id', 1)->first();
            if($request->marital_status == 'Bujangan/Wanita' || $request->marital_status == "")
            {
                $untaxable_income = $ptkp->bujangan_wanita;
            }
            if($request->marital_status == 'Menikah')
            {
                $untaxable_income = $ptkp->menikan;
            }
            if($request->marital_status == 'Menikah Anak 1')
            {
                $untaxable_income = $ptkp->menikah_anak_1;
            }
            if($request->marital_status == 'Menikah Anak 2')
            {
                $untaxable_income = $ptkp->menikah_anak_2;
            }
            if($request->marital_status == 'Menikah Anak 3')
            {
                $untaxable_income = $ptkp->menikah_anak_3;
            }

            $taxable_yearly_income = $net_yearly_income - $untaxable_income;

            // Perhitungan 5 persen
            $income_tax_calculation_5 = 0;
            if($taxable_yearly_income < 0)
            {
                $income_tax_calculation_5 = 0;   
            }
            elseif($taxable_yearly_income <= 50000000)
            {
                $income_tax_calculation_5 = 0.05 * $taxable_yearly_income;
            }
            if($taxable_yearly_income >= 50000000)
            {
                $income_tax_calculation_5 = 0.05 * 50000000;
            }

            // Perhitungan 15 persen
            $income_tax_calculation_15 = 0;
            if($taxable_yearly_income >= 250000000 )
            {
                $income_tax_calculation_15 = 0.15 * (250000000 - 50000000);
            }
            if($taxable_yearly_income >= 50000000 and $taxable_yearly_income <= 250000000)
            {
                $income_tax_calculation_15 = 0.15 * ($taxable_yearly_income - 50000000);
            }

            // Perhitungan 25 persen
            $income_tax_calculation_25 = 0;
            if($taxable_yearly_income >= 500000000)
            {
                $income_tax_calculation_25 = 0.25 * (500000000 - 250000000);
            }
 
            if($taxable_yearly_income <= 500000000 and $taxable_yearly_income >= 250000000)
            {
                $income_tax_calculation_25 = 0.25 * ($taxable_yearly_income - 250000000);
            }

            $income_tax_calculation_30 = 0;
            if($taxable_yearly_income >= 500000000)
            {
                $income_tax_calculation_30 = 0.35 * ($taxable_yearly_income - 500000000);
            }

            $yearly_income_tax = $income_tax_calculation_5 + $income_tax_calculation_15 + $income_tax_calculation_25 + $income_tax_calculation_30;
            $monthly_income_tax = $yearly_income_tax / 12;
            $basic_salary       = $gross_income / 12;
            $less               = ($jamsostek / 12) + $jkk_result + $monthly_income_tax; 
            $thp                = $basic_salary - $less;

            $params['jkk_result']           = number_format($jkk_result);
            $params['gross_income']         = number_format($gross_income); 
            $params['burden_allow']         = number_format($burden_allow);
            $params['jamsostek_result']     = number_format($jamsostek);
            $params['total_deduction']      = number_format($total_deduction);
            $params['net_yearly_income']    = number_format($net_yearly_income);
            $params['untaxable_income']     = number_format($untaxable_income);
            $params['taxable_yearly_income']        = number_format($taxable_yearly_income);
            $params['income_tax_calculation_5']     = number_format($income_tax_calculation_5); 
            $params['income_tax_calculation_15']    = number_format($income_tax_calculation_15); 
            $params['income_tax_calculation_25']    = number_format($income_tax_calculation_25); 
            $params['income_tax_calculation_30']    = number_format($income_tax_calculation_30); 
            $params['yearly_income_tax']            = number_format($yearly_income_tax);
            $params['monthly_income_tax']           = number_format($monthly_income_tax);
            $params['basic_salary']                 = number_format($basic_salary);
            $params['less']                         = number_format($less);
            $params['thp']                          = number_format($thp);
            $params['overtime_claim']               = $overtime_claim;
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
     * [getKaryawan description]
     * @return [type] [description]
     */
    public function getKaryawanPayroll(Request $request)
    {
        $params = [];
        if($request->ajax())
        {
            $data =  \App\User::where('name', 'LIKE', "%". $request->name . "%")->orWhere('nik', 'LIKE', '%'. $request->name .'%')->get();

            $karyawan = [];
            foreach($data as $k => $i)
            {
                $payroll = \App\Payroll::where('user_id', $i->id)->first();
                // existing user payroll skip
                if($payroll) continue;

                if($i->access_id != 2) continue; // jika bukan karyawan maka skip

                $karyawan[$k]['id']     = $i->id;
                $karyawan[$k]['value']  = $i->nik .' - '. $i->name;
            }
        }

        return response()->json($karyawan); 
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
     * [getHistoryApprovalOvertime description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getHistoryApprovalMedical(Request $request)
    {
        if($request->ajax())
        {
            $data = \App\MedicalReimbursement::where('id', $request->foreign_id)->first();

            $data->jenis_karyawan = strtolower(jabatan_level_user($data->user_id));

            if(isset($data->atasan->name))
            {
                $data->atasan_name = $data->atasan->nik .' - '. $data->atasan->name;
            }
 
            if(isset($data->direktur->name))
            {
                $data->direktur_name = $data->direktur->nik .' - '. $data->direktur->name;
            }


            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getHistoryApprovalOvertime description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getHistoryApprovalOvertime(Request $request)
    {
        if($request->ajax())
        {
            $data = \App\OvertimeSheet::where('id', $request->foreign_id)->first();

            $data->jenis_karyawan = strtolower(jabatan_level_user($data->user_id));

            if(isset($data->atasan->name))
            {
                $data->atasan_name = $data->atasan->nik .' - '. $data->atasan->name;
            }
 
            if(isset($data->direktur->name))
            {
                $data->direktur_name = $data->direktur->nik .' - '. $data->direktur->name;
            }


            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [getHistoryApprovalPaymentRequest description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getHistoryApprovalPaymentRequest(Request $request)
    {
        if($request->ajax())
        {
            $data = \App\PaymentRequest::where('id', $request->foreign_id)->first();
            $data->jenis_karyawan = strtolower(jabatan_level_user($data->user_id));

            if(isset($data->atasan->name))
            {
                $data->atasan_name = $data->atasan->nik .' - '. $data->atasan->name;
            }
 
            if(isset($data->direktur->name))
            {
                $data->direktur_name = $data->direktur->nik .' - '. $data->direktur->name;
            }

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
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
            $direktur = \App\User::where('id', $data->approve_direktur_id)->first();
            
            $data->atasan = "";
            $data->jenis_karyawan = strtolower(jabatan_level_user($data->user_id));

            if(isset($atasan))
            {
                $data->atasan = $atasan->nik .' - '. $atasan->name;
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
    public function getHistoryApprovalExit(Request $request)
    {
        if($request->ajax())
        {
            $data = \App\ExitInterview::where('id', $request->foreign_id)->first();
            $data->jenis_karyawan = strtolower(jabatan_level_user($data->user_id));

            if(isset($data->atasan->name))
            {
                $data->atasan_name = $data->atasan->nik .' - '. $data->atasan->name;
            }
 
            if(isset($data->direktur->name))
            {
                $data->direktur_name = $data->direktur->nik .' - '. $data->direktur->name;
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
            $direktur = \App\User::where('id', $data->approve_direktur_id)->first();

            $data->atasan = "";

            $data->jenis_karyawan = strtolower(jabatan_level_user($data->user_id));

            if(isset($atasan))
            {
                $data->atasan = $atasan->nik .' - '. $atasan->name;
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
            $direktur = \App\User::where('id', $data->approve_direktur_id)->first();
            
            $data->atasan = "";

            if(!empty($data->user->empore_organisasi_staff_id))
            {
                $data->jenis_karyawan = 'staff';
            }

            if(empty($data->user->empore_organisasi_staff_id) and !empty($data->user->empore_organisasi_manager_id))
            {
                $data->jenis_karyawan = 'manager';
            }

            if(isset($atasan))
            {
                $data->atasan = $atasan->nik .' - '. $atasan->name;
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

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingOvertimeManagerDepartment description]
     * @param Request $request [description]
     */
    public function addSettingOvertimeManagerDepartment(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'overtime';
            $data->user_id      = $request->id;
            $data->nama_approval= 'Manager Department';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingOvertimeManagerDepartment description]
     * @param Request $request [description]
     */
    public function addSettingExitHRD(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'exit_clearance';
            $data->user_id      = $request->id;
            $data->nama_approval= 'HRD';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingOvertimeManagerDepartment description]
     * @param Request $request [description]
     */
    public function addSettingExitGA(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'exit_clearance';
            $data->user_id      = $request->id;
            $data->nama_approval= 'GA';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingOvertimeManagerDepartment description]
     * @param Request $request [description]
     */
    public function addSettingExitIT(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'exit_clearance';
            $data->user_id      = $request->id;
            $data->nama_approval= 'IT';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingOvertimeManagerDepartment description]
     * @param Request $request [description]
     */
    public function addSettingExitAccounting(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'exit_clearance';
            $data->user_id      = $request->id;
            $data->nama_approval= 'Accounting';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

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

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

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

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingOvertimeHrOperation description]
     * @param Request $request [description]
     */
    public function addSettingOvertimeHrOperation(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'overtime';
            $data->user_id      = $request->id;
            $data->nama_approval= 'HR Operation';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingOvertimeHrOperation description]
     * @param Request $request [description]
     */
    public function addSettingExitHrDirector(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'exit';
            $data->user_id      = $request->id;
            $data->nama_approval= 'HR Director';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingExitHRGM description]
     * @param Request $request [description]
     */
    public function addSettingExitHRGM(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'exit';
            $data->user_id      = $request->id;
            $data->nama_approval= 'HR GM';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingExitHrManager description]
     * @param Request $request [description]
     */
    public function addSettingExitHrManager(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'exit';
            $data->user_id      = $request->id;
            $data->nama_approval= 'HR Manager';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingOvertimeManagerHR description]
     * @param Request $request [description]
     */
    public function addSettingOvertimeManagerHR(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'overtime';
            $data->user_id      = $request->id;
            $data->nama_approval= 'Manager HR';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingMedicalGMHR description]
     * @param Request $request [description]
     */
    public function addSettingMedicalGMHR(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'medical';
            $data->user_id      = $request->id;
            $data->nama_approval= 'GM HR';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingMedicalManagerHR description]
     * @param Request $request [description]
     */
    public function addSettingMedicalManagerHR(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'medical';
            $data->user_id      = $request->id;
            $data->nama_approval= 'Manager HR';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }

    /**
     * [addSettingMedicalHRBenefit description]
     * @param Request $request [description]
     */
    public function addSettingMedicalHRBenefit(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'medical';
            $data->user_id      = $request->id;
            $data->nama_approval= 'HR Benefit';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

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
     * [addtSettingPaymentRequestApproval description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function addtSettingPaymentRequestApproval(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'payment_request';
            $data->user_id      = $request->id;
            $data->nama_approval= 'Approval';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }


    /**
     * [addtSettingPaymentRequestApproval description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function addtSettingPaymentRequestVerification(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'payment_request';
            $data->user_id      = $request->id;
            $data->nama_approval= 'Verification';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

            return response()->json(['message' => 'success', 'data' => $data]);
        }

        return response()->json($this->respon);
    }


    /**
     * [addtSettingPaymentRequestApproval description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function addtSettingPaymentRequestPayment(Request $request)
    {
        if($request->ajax())
        {
            $data               = new \App\SettingApproval();
            $data->jenis_form   = 'payment_request';
            $data->user_id      = $request->id;
            $data->nama_approval= 'Payment';
            $data->save();

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

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

            Session::flash('message-success', 'User Approval berhasil di tambahkan');

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
            
            Session::flash('message-success', 'User Approval berhasil di tambahkan');

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
    // public function getStructure()
    // {
    //     $data = [];

    //     $directorate = Directorate::all();
    //     foreach($directorate as $key_dir => $dir)
    //     {
    //         $data[$key_dir]['name'] = 'Directorate';
    //         $data[$key_dir]['title'] = $dir->name;
    //         $data[$key_dir]['children'] = [];

    //         $num_key_div = 0;
    //         foreach(get_division_by_directorate_id($dir->id) as $key_div => $div)
    //         {
    //             $data[$key_dir]['children'][$key_div]['name'] = 'Division';
    //             $data[$key_dir]['children'][$key_div]['title'] = $div->name;

    //             foreach(get_department_by_division_id($div->id) as $key_dept => $dept)
    //             {
    //                 $data[$key_dir]['children'][$key_div]['children'][$key_dept]['name'] = 'Division';
    //                 $data[$key_dir]['children'][$key_div]['children'][$key_dept]['title'] = $div->name;

    //                 foreach(get_section_by_department_id($dept->id) as $key_sec => $sec)
    //                 {
    //                     $data[$key_dir]['children'][$key_div]['children'][$key_dept]['children'][$key_sec]['name'] = 'Section';
    //                     $data[$key_dir]['children'][$key_div]['children'][$key_dept]['children'][$key_sec]['title'] = $sec->name;
    //                 } 
    //             }
    //             $num_key_div++;
    //         }
    //     }

    //     return response()->json($data);
    // } 


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
            $data['name'] = 'Direktur';
            $data['title'] = $dir->name;
            $data['children'] = [];

            $num_key_div = 0;
            foreach(\App\EmporeOrganisasiManager::where('empore_organisasi_direktur_id', $dir->id)->get() as $key_div => $div)
            {
                $data['children'][$key_div]['name'] = 'Manager';
                $data['children'][$key_div]['title'] = $div->name;

                foreach(\App\EmporeOrganisasiStaff::where('empore_organisasi_manager_id', $div->id)->get() as $key_dept => $dept)
                {
                    $data['children'][$key_div]['children'][$key_dept]['name'] = 'Staff';
                    $data['children'][$key_div]['children'][$key_dept]['title'] = $dept->name;
                }
                
                $num_key_div++;
            }
        }

        return response()->json($data);
    } 

}