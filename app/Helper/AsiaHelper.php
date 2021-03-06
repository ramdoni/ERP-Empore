<?php


/**
 * [cek_count_exit_admin description]
 * @return [type] [description]
 */
function cek_count_training_admin()
{
	$total = \App\Training::where('status', 1)->orWhere('status_actual_bill', 2)->count();

	return $total;
}

/**
 * [cek_count_exit_admin description]
 * @return [type] [description]
 */
function cek_count_exit_admin()
{
	$total = \App\ExitInterview::where('status', 1)->count();

	return $total;
}

/**
 * [hari_libur description]
 * @return [type] [description]
 */
function hari_libur()
{
	return \App\LiburNasional::get();
}

/**
 * [cek_count_cuti_admin description]
 * @return [type] [description]
 */
function cek_count_cuti_admin()
{
	$total = \App\CutiKaryawan::where('status', 1)->count();

	return $total;
}


/**
 * [get_kuota_cuti description]
 * @param  [type] $cuti_id [description]
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
function get_cuti_terpakai($cuti_id, $user_id)
{
	$cuti = \App\UserCuti::where('user_id', $user_id)->where('cuti_id', $cuti_id)->first();

	if($cuti)
		return $cuti->cuti_terpakai;
	else
		return 0;
} 

/**
 * [get_cuti_terpakai description]
 * @param  [type] $cuti_id [description]
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
function get_kuota_cuti($cuti_id, $user_id)
{ 
	$cuti = \App\UserCuti::where('user_id', $user_id)->where('cuti_id', $cuti_id)->first();

	if($cuti)
		return $cuti->kuota;
	else
	{
		$cuti = \App\Cuti::where('id', $cuti_id)->first();

		return $cuti->kuota;
	}
}

/**
 * [plafond_perjalanan_dinas description]
 * @return [type] [description]
 */
function plafond_perjalanan_dinas($A, $name)
{
	

	return \App\PlafondDinas::where('organisasi_position_text', 'LIKE', '%'. strtoupper($name) .'%')->where('type',$A)->first();
	/*
	if($jenis =='Dalam Negeri')
	{
		return \App\PlafondDinas::where('organisasi_position_text', 'LIKE', '%'. strtoupper($name) .'%')->first();
	}
	elseif($jenis =='Luar Negeri')
	{
		return \App\PlafondDinasLuarNegeri::where('organisasi_position_text', 'LIKE', '%'. strtoupper($name) .'%')->first();
	}
	*/
	
}

/**
 * [get_backup_cuti description]
 * @return [type] [description]
 */
function get_backup_cuti()
{
	$user = \Auth::user();

	if($user->branch_type == 'BRANCH')
	{
		$karyawan = \App\User::where('cabang_id', $user->cabang_id)->where('id', '<>', $user->id)->get();
	}
	else
	{
		$karyawan = \App\User::where('division_id', $user->division_id)->where('id', '<>', $user->id)->get();
	}

	$karyawan = \App\User::where('id', '<>', $user->id)->where('access_id', '2')->get();

	return $karyawan;
}

/**
 * [list_user_cuti description]
 * @return [type] [description]
 */
function list_user_cuti()
{
	return \App\Cuti::orderBy('jenis_cuti','ASC')->get();
}

/**
 * [jenis_perjalanan_dinas description]
 * @return [type] [description]
 */
function jenis_perjalanan_dinas()
{
	return ['Training', 'Management Meeting','Hearing Meeting','Regional/Division Meeting','Assessment','Branch Visit', 'Others'];
}

/**
 * [cek_training_approval_user description]
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
function cek_training_approval_user($user_id)
{
	$count =  \App\Training::where('approved_atasan_id', $user_id)->count();

	return $count;
}

/**
 * [cek_training_approval_user description]
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
function count_training_approval_atasan($user_id)
{
	$count =  \App\Training::where('approved_atasan_id', $user_id)->where('is_approved_atasan', 0)->count();
	$count +=  \App\Training::where('approved_atasan_id', $user_id)->where('status_actual_bill', 2)->where('is_approve_atasan_actual_bill', 0)->count();

	return $count;
}

/**
 * [cek_cuti_approval_user description]
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
function cek_cuti_approval_user($user_id)
{
	return \App\CutiKaryawan::where('approved_atasan_id', $user_id)->count();
}


/**
 * [get_atasan description]
 * @return [type] [description]
 */
function get_atasan_langsung()
{
	// cek sebagai branch / tidak
	$user = \Auth::user();
	$karyawan = [];

	if($user->branch_type == 'BRANCH')
	{
		if(isset($user->organisasiposition->name))
		{
			if($user->organisasiposition->name == 'Staff')
			{
				$res = \App\User::where('department_id', $user->department_id)
								->join('organisasi_position', function($join){
									$join->on('organisasi_position.id', '=', 'users.organisasi_position');
								})
								->where('cabang_id', $user->cabang_id)
								->where('users.id', '<>', $user->id)
								->where(function($query){
									$query->where('organisasi_position.name', 'Head')
										->orWhere('organisasi_position.name', 'Branch Manager');
								})
								->select('users.*', 'organisasi_position.name as job_rule')
								->get();
				$karyawan = new stdClass; $no=0;
				foreach($res as $k => $item)
				{
					$karyawan->$k = $item;
					$no++;
				}

				if($no==0)
				{
					$res = \App\User::join('organisasi_position', function($join){
									$join->on('organisasi_position.id', '=', 'users.organisasi_position');
								})
								->where('cabang_id', $user->cabang_id)
								->where('users.id', '<>', $user->id)
								->where(function($query){
									$query->where('organisasi_position.name', 'Head')
										->orWhere('organisasi_position.name', 'Branch Manager');
								})
								->select('users.*', 'organisasi_position.name as job_rule')
								->get();
					$karyawan = new stdClass;
					foreach($res as $k => $item)
					{
						$karyawan->$k = $item;
					}
				}
			}
			// jika sabagai Head
			if($user->organisasiposition->name  == 'Head')
			{
				$karyawan = \App\User::join('organisasi_position', function($join){
									$join->on('organisasi_position.id', '=', 'users.organisasi_position');
								})
								->where('cabang_id', $user->cabang_id)
								->where('users.id', '<>', $user->id)
								->where('organisasi_position.name', 'Branch Manager')
								->select('users.nik', 'users.id', 'users.name','organisasi_position.name as job_rule')
								->get();
			}
			// jika yang mengajukan Branch Manager
			if($user->organisasiposition->name  == 'Branch Manager')
			{
				$karyawan = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
								//->where('users.division_id', $user->division_id)
								->where('users.id', '<>', $user->id)
								->where(function($query){
									$query->where('organisasi_position.name', 'General Manager')
											->orWhere('organisasi_position.name', 'Area Manager');
								})
								->select('users.*', 'organisasi_position.name as job_rule')
								->get();
			}

			// jika yang mengajukan Branch Manager
			if($user->organisasiposition->name  == 'Head' and $user->organisasi_job_role == 'Manager Outlet')
			{
				$karyawan = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
								//->where('users.division_id', $user->division_id)
								->where('users.id', '<>', $user->id)
								->where(function($query){
									$query->where('organisasi_position.name', 'General Manager')
											->orWhere('organisasi_position.name', 'Area Manager');
								})
								->select('users.*', 'organisasi_position.name as job_rule')
								->get();
			}

			// jika yang mengajukan Branch Manager
			if($user->organisasiposition->name  == 'General Manager')
			{
				$karyawan = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
								//->where('users.division_id', $user->division_id)
								->where('users.id', '<>', $user->id)
								->where(function($query){
									$query->where('organisasi_position.name', 'Director')
											->orWhere('organisasi_position.name', 'Expatriat');
								})
								->select('users.*', 'organisasi_position.name as job_rule')
								->get()
								;
			}
		}
	}
	else
	{
		if(isset($user->organisasiposition->name))
		{
			if($user->organisasiposition->name == 'Staff')
			{
				// mencari di department
				$res = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
								->where('users.id', '<>', $user->id)
								->where(function($query){
									$query->where('organisasi_position.name', 'Supervisor')
											->orWhere('organisasi_position.name', 'Manager')
											->orWhere('organisasi_position.name', 'Senior Manager');
								})
								->where('users.department_id', $user->department_id)
								->select('users.*', 'organisasi_position.name as job_rule')
								->get();

				$karyawan = new stdClass; $no=0;
				foreach($res as $k => $item)
				{
					$karyawan->$k = $item; $no++;
				}

				if($no == 0)
				{
					// mencari di division
					$res = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
								->where('users.id', '<>', $user->id)
								->where(function($query){
									$query->where('organisasi_position.name', 'Supervisor')
											->orWhere('organisasi_position.name', 'Manager')
											->orWhere('organisasi_position.name', 'Senior Manager');
								})
								->where('users.division_id', $user->division_id)
								->select('users.*', 'organisasi_position.name as job_rule')
								->get();

					$karyawan = new stdClass; $no=0;
					foreach($res as $k => $item)
					{
						$karyawan->$k = $item; $no++;
					}
				}

				// mencari bukan berdasarkan divisi atau department
				if($no == 0)
				{
					// mencari di division
					$res = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
								->where('users.id', '<>', $user->id)
								->where('organisasi_position.name', '<>', 'Staff')
								->select('users.*', 'organisasi_position.name as job_rule')
								->get();

					$karyawan = new stdClass; $no=0;
					foreach($res as $k => $item)
					{
						$karyawan->$k = $item; $no++;
					}

				}
			}

			// Supervisor / Head
			if($user->organisasiposition->name == 'Supervisor' || $user->organisasiposition->name == 'Head')
			{
				// mencari di division
				$res = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
							->where('users.id', '<>', $user->id)
							->where(function($query){
								$query->orWhere('organisasi_position.name', 'Manager')
										->orWhere('organisasi_position.name', 'Senior Manager');
							})
							->where('users.division_id', $user->division_id)
							->select('users.*', 'organisasi_position.name as job_rule')
							->get();

				$karyawan = new stdClass; $no=0;
				foreach($res as $k => $item)
				{
					$karyawan->$k = $item; $no++;
				}
			}

			// Jika manager
			if($user->organisasiposition->name == 'Manager')
			{
				$res = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
							->where('users.id', '<>', $user->id)
							->where(function($query){
								$query->orWhere('organisasi_position.name', 'Director')
										->orWhere('organisasi_position.name', 'Expatriat')
										->orWhere('organisasi_position.name', 'General Manager')
										->orWhere('organisasi_position.name', 'Senior Manager')
										;
							})
							->select('users.*', 'organisasi_position.name as job_rule')
							->get();

				$karyawan = new stdClass; $no=0;
				foreach($res as $k => $item)
				{
					$karyawan->$k = $item; $no++;
				}
			}

			// Manager, Sales Manager, Area Manager
			if($user->organisasiposition->name == 'Area Manager' || $user->organisasiposition->name == 'Sales Manager' )
			{
				
				$res = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
								->where('users.id', '<>', $user->id)
								->where('users.department_id', $user->department_id)
								->where('organisasi_position.name', 'Senior Manager')
								->select('users.*', 'organisasi_position.name as job_rule')
								->get();
								
				$karyawan = new stdClass;$no=0;
				foreach($res as $k => $item)
				{
					$no++;
					$karyawan->$k = $item;
				}

				if($no ==0)
				{
					$res = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
									->where('users.id', '<>', $user->id)
									->where('users.division_id', $user->division_id)
									->where(function($query){
											$query->orWhere('organisasi_position.name', 'General Manager')
													->orWhere('organisasi_position.name', 'Senior Manager');
										})
									->select('users.*', 'organisasi_position.name as job_rule')
									->get();
									
					$karyawan = new stdClass;$no=0;
					foreach($res as $k => $item)
					{
						$no++;
						$karyawan->$k = $item;
					}
				}
			}

			// General Manager / Senior Manager
			if($user->organisasiposition->name =='Senior Manager')
			{
				$res = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
								->where(function($query){
									$query->orWhere('organisasi_position.name', 'General Manager')
											->orWhere('organisasi_position.name', 'Director')
											->orWhere('organisasi_position.name', 'Expatriat');
								})
								->select('users.*', 'organisasi_position.name as job_rule')
								->get();
				$karyawan = new stdClass; $no=0;

				foreach($res as $k => $item)
				{
					$karyawan->$k = $item;
					$no++;
				}
			}

			// General Manager / Senior Manager
			if($user->organisasiposition->name == 'General Manager')
			{
				$res = \App\User::join('organisasi_position', 'organisasi_position.id', '=', 'users.organisasi_position')
								->where(function($query){
									$query->orWhere('organisasi_position.name', 'Director')
											->orWhere('organisasi_position.name', 'Expatriat');
								})
								->select('users.*', 'organisasi_position.name as job_rule')
								->get();
				$karyawan = new stdClass; $no=0;

				foreach($res as $k => $item)
				{
					$karyawan->$k = $item;
					$no++;
				}
			}
		}
	}

	return $karyawan;
}

/**
 * [tree_organisasi description]
 * @return [type] [description]
 */
function tree_atasan_organisasi()
{
	return ['Head', 'Supervisor','Manager', 'Branch Manager', 'Senior Advisor', 'Senior Manager', 'General Manager', 'Director'];
}


/**
 * [get_organisasi_position_group description]
 * @return [type] [description]
 */
function get_organisasi_position_group()
{
	return \App\OrganisasiPosition::groupBy('name')->get();
}

/**
 * [get_organisasi_position description]
 * @param  string $unit_id [description]
 * @return [type]          [description]
 */
function get_organisasi_position($unit_id = "")
{
	if($unit_id != "")
		return \App\OrganisasiPosition::where('organisasi_unit_id', $unit_id)->get();
	else
		return \App\OrganisasiPosition::all();

}
/**
 * [get_organisasi_unit description]
 * @param  string $department_id [description]
 * @return [type]                [description]
 */
function get_organisasi_unit($department_id = "")
{
	if(!empty($department_id))
		return \App\OrganisasiUnit::where('organisasi_department_id', $department_id)->get();
	else
		return \App\OrganisasiUnit::all();
}

/**
 * [get_organisasi_division description]
 * @return [type] [description]
 */
function get_organisasi_department($division_id = 0)
{
	if(!empty($division_id))
		return \App\OrganisasiDepartment::orderBy('name', 'ASC')->get();
	else
		return \App\OrganisasiDepartment::where('organisasi_division_id', $division_id)->orderBy('name', 'ASC')->get();
}

/**
 * [get_organisasi_division description]
 * @return [type] [description]
 */
function get_organisasi_division()
{
	return \App\OrganisasiDivision::orderBy('name', 'ASC')->get();
}

/**
 * [list_hari_libur description]
 * @return [type] [description]
 */
function list_hari_libur()
{
	return \App\LiburNasional::all();
}

/**
 * [get_head_branch description]
 * @return [type] [description]
 */
function get_head_branch()
{
	return \App\BranchHead::all();
}

/**
 * [get_head_branch description]
 * @return [type] [description]
 */
function get_staff_branch()
{
	return \App\BranchStaff::all();
}

/**
 * [cek_approval description]
 * @param  [type] $table [description]
 * @return [type]        [description]
 */
function cek_approval($table)
{
	$cek = DB::table($table)->where('status', 1)->where('user_id', \Auth::user()->id)->count();

	if($cek >= 1)
		return false;
	else
		return true;
}

/**
 * [get_master_cuti description]
 * @return [type] [description]
 */
function get_master_cuti()
{
	return \App\Cuti::all();
}

/**
 * [position_karyawan description]
 * @return [type] [description]
 */
function position_structure()
{
	return ['Staff', 'SPV', 'Head', 'General Manager', 'Manager'];
}

if (! function_exists('d')) {
    /**
     * Dump the passed variables.
     *
     * @param  mixed
     * @return void
     */
    function d($var)
    {
		return yii\helpers\VarDumper::dump($var);
    }
}

/**
 * [total_training description]
 * @return [type] [description]
 */
function total_training()
{
	return \App\Training::join('users', 'users.id', '=', 'training.user_id')->count();
}


/**
 * [total_karyawan description]
 * @return [type] [description]
 */
function total_karyawan()
{
	return \App\User::where('access_id', 2)->count();
}

/**
 * [total_cuti_karyawan description]
 * @return [type] [description]
 */
function total_cuti_karyawan()
{
	return \App\CutiKaryawan::join('users', 'users.id', '=', 'cuti_karyawan.user_id')->count();
}

/**
 * [list_cuti_user description]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function list_cuti_user($id)
{
	return \App\CutiKaryawan::where('user_id', $id)->get();
}


/**
 * [get_airports description]
 * @return [type] [description]
 */
function get_airports()
{
	return \App\Airports::orderBy('code', 'ASC')->get();
}

/**
 * [cek_status_approval_user description]
 * @param  [type] $id         [description]
 * @param  [type] $jenis_form [description]
 * @param  [type] $foreign_id [description]
 * @return [type]             [description]
 */
function cek_status_approval_user($user_id, $jenis_form, $foreign_id)
{
	// cek approval
	$approval = \App\StatusApproval::where('approval_user_id', $user_id)->where('jenis_form', $jenis_form)->where('foreign_id', $foreign_id)->first();

	if($approval)
		return true;
	else
		return false;
}

/**
 * [cek_approval_user description]
 * @return [type] [description]
 */
function cek_approval_user()
{
	$user = \Auth::user();

	// cek approval
	$approval = \App\SettingApproval::where('user_id', $user->id)->first();

	if($approval)
		return true;
	else
		return false;
}

/**
 * [cek_approval_user description]
 * @return [type] [description]
 */
function list_approval_user()
{
	$user = \Auth::user();

	// cek approval
	$approval = \App\SettingApproval::where('user_id', $user->id)->groupBy('jenis_form')->get();

	$list = [];
	foreach($approval as $k => $item)
	{
		$list[$k]['name'] = $item->nama_approval;
		$list[$k]['link'] = $item->jenis_form;

		switch($item->jenis_form)
		{
			case 'cuti':
				$list[$k]['nama_menu'] = 'Leave / Permit Employee (Assign HRD)';
			break;
			case 'payment_request':
				$list[$k]['nama_menu'] = 'Payment Request';
			break;
			case 'medical':
				$list[$k]['nama_menu'] = 'Medical Reimbursement';
			break;
			case 'exit_clearance':
				$list[$k]['nama_menu'] = 'Exit Interview & Clearance';
			break;
			case 'exit':
				$list[$k]['nama_menu'] = 'Exit Interview & Clearance';
			break;
			case 'training':
				$list[$k]['nama_menu'] = 'Training & Perjalanan Dinas';
			break;
			case 'overtime':
				$list[$k]['nama_menu'] = 'Overtime Sheet';
			break;
			default:
				$list[$k]['nama_menu'] = '';
			break;
		}
	}	

	return $list;
}

/**
 * [get_karyawan description]
 * @return [type] [description]
 */
function get_karyawan()
{
	return \App\User::where('access_id', 2)->get();
}


/**
 * [get_bank description]
 * @return [type] [description]
 */
function get_bank()
{
	return \App\Bank::all();
}

/**
 * [get_department_name description]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function get_department_name($id)
{
	$data = \App\Department::where('id', $id)->first();

	if($data)
		return $data->name;
	else
		return '';
}

/**
 * [get_kabupten description]
 * @param  integer $id_prov [description]
 * @return [type]           [description]
 */
function get_kabupaten($id_prov = 0)
{
	if($id_prov == 0)
	{
		$data = \App\Kabupaten::orderBy('nama','asc')->get();
	}
	else
	{
		$data = \App\Kabupaten::where('id_prov', $id_prov)->orderBy('nama','asc')->get();
	}

	return $data;
}

/**
 * [get_provinsi description]
 * @return [type] [description]
 */
function get_provinsi()
{
	return \App\Provinsi::orderBy('nama', 'ASC')->get();;
}

/**
 * [get_sekolah description]
 * @return [type] [description]
 */
function get_sekolah()
{
	return \App\Sekolah::orderBy('name', 'ASC')->get();
}

/**
 * [get_cabang description]
 * @return [type] [description]
 */
function get_cabang()
{
	return \App\Cabang::orderBy('name', 'ASC')->get();
}

/**
 * [get_program_studi description]
 * @return [type] [description]
 */
function get_program_studi()
{
	return \App\ProgramStudi::orderBy('name', 'ASC')->get();
}

/**
 * [get_universitas description]
 * @return [type] [description]
 */
function get_jurusan()
{
	return \App\Jurusan::orderBy('name', 'ASC')->get();
}

/**
 * [get_universitas description]
 * @return [type] [description]
 */
function get_universitas()
{
	return \App\Universitas::orderBy('name', 'ASC')->get();
}

/**
 * [lama_hari description]
 * @param  [type] $start [description]
 * @param  [type] $end   [description]
 * @return [type]        [description]
 */
function lama_hari($start, $end)
{
	$start_date = new DateTime($start);
	$end_date = new DateTime($end);
	$interval = $start_date->diff($end_date);
		
	// jika hari sama maka dihitung 1 hari
	if($start_date == $end_date)  return "1";

	$hari = $interval->days + 1;

	return "$hari "; // hasil : 217 hari

}

/**
 * [status_cuti description]
 * @param  [type] $status [description]
 * @return [type]         [description]
 */
function status_cuti($status)
{
	$html = '';
	switch ($status) {
		case 1:
			$html = '<label class="btn btn-warning btn-xs">Waiting Approval</label>';
			break;
		case 2:
			$html = '<label class="btn btn-success btn-xs"><i class="fa fa-chceck"></i>Approved</label>';
		break;
		case 3:
			$html = '<label class="btn btn-danger btn-xs"><i class="fa fa-close"></i>Rejected</label>';
		break;
		case 4:
			$html = '<label class="btn btn-danger btn-xs"><i class="fa fa-close"></i>Cancelled</label>';
		break;
		default:
			break;
	}

	return $html;
}


/**
 * [get_department_by_section_id description]
 * @param  [type] $department_id [description]
 * @param  string $type          [description]
 * @return [type]                [description]
 */
function get_section_by_department_id($department_id, $type='array')
{
	if($type == 'array')
		$data = \App\Section::where('department_id', $department_id)->get();
	else
		$data = \App\Section::where('department_id', $department_id)->first();
	
	return $data;	
}

/**
 * [get_department_by_division_id description]
 * @param  [type] $division_id [description]
 * @return [type]              [description]
 */
function get_department_by_division_id($division_id, $type='array')
{
	if($type == 'array')
		$data = \App\Department::where('division_id', $division_id)->get();
	else
		$data = \App\Department::where('division_id', $division_id)->first();
	
	return $data;	
}
/**
 * [get_division_by_directorate_id description]
 * @param  [type] $directorate_id [description]
 * @return [type]                 [description]
 */
function get_division_by_directorate_id($directorate_id, $type = 'array')
{
	if($type == 'array')
		$data = \App\Division::where('directorate_id', $directorate_id)->get();
	else
		$data = \App\Division::where('directorate_id', $directorate_id)->first();
	
	return $data;		
}

/**
 * [agama description]
 * @return [type] [description]
 */
function agama()
{
	return ['Muslim', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
}
?>