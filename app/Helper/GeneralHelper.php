<?php

/**
 * @param  [type]
 * @return [type]
 */
function jabatan_level_user($id)
{
	$user = \App\User::where('id', $id)->first();

	if($user)
	{
		if(!empty($user->empore_organisasi_staff_id)):
            return 'Staff';
        endif;

        if(empty($user->empore_organisasi_staff_id) and !empty($user->empore_organisasi_manager_id)):
            return 'Manager';
        endif;

        if(empty($user->empore_organisasi_staff_id) and empty($user->empore_organisasi_manager_id) and !empty($user->empore_organisasi_direktur)):
            return 'Direktur';
        endif;
	}

	return;
}

/**
 * @return [type]
 */
function get_level_organisasi()
{
	$organisasi = ['Staff', 'Manager', 'Direktur'];
	
	return $organisasi;
}

/**
 * [pay_slip_tahun description]
 * @return [type] [description]
 */
function pay_slip_tahun($id)
{
	$data = \App\Payroll::select(DB::raw('year(created_at) as tahun'))->where('user_id', $id)->get();

	return $data;
}

/**
 * [pay_slip_tahun_history description]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function pay_slip_tahun_history($id)
{
	$data = \App\PayrollHistory::select(DB::raw('year(created_at) as tahun'))->where('user_id', $id)->groupBy('tahun')->get();

	return $data;
}

/**
 * [asset_type description]
 * @return [type] [description]
 */
function asset_type($id=null)
{
	if($id != null)
		return \App\AssetType::where('id', $id)->get();
	else
		return \App\AssetType::all();
}

/**
 * @param  [type]
 * @param  [type]
 * @param  [type]
 * @return [type]
 */
function get_cuti_user($cuti_id, $user_id, $field)
{
	$cuti = \App\UserCuti::where('user_id', $user_id)->where('cuti_id', $cuti_id)->first();

	if($cuti){
		if(isset($cuti->$field))
		{
			return $cuti->$field;
		}
	}
	else
		return 0;
}

/**
 * @return [type]
 */
function cek_cuti_direktur($status='approved')
{
	if($status=='approved')
	{
		$cuti = \App\CutiKaryawan::where('approve_direktur_id', \Auth::user()->id)->where('approve_direktur', 1)->count();		
	}
	elseif($status == 'null')
	{
		$cuti = \App\CutiKaryawan::where('approve_direktur_id', \Auth::user()->id)->whereNull('approve_direktur')->count();		
	}

	return $cuti;
}

/**
 * @param  string
 * @return [type] 
 */
function cek_training_direktur($status='approved')
{
	if($status=='approved')
	{
		$data = \App\Training::where('approve_direktur_id', \Auth::user()->id)->where('approve_direktur', 1)->count();		
	}
	elseif($status == 'null')
	{
		$data = \App\Training::where('approve_direktur_id', \Auth::user()->id)->whereNull('approve_direktur')->count();		
	}
	elseif($status == 'all')
	{
		$data = \App\Training::where('approve_direktur_id', \Auth::user()->id)->count();		
	}

	if($status=='approved')
	{
		$actual_bill = \App\Training::where('approve_direktur_id', \Auth::user()->id)->where('status', 2)->where('status_actual_bill', 2)->where('approve_direktur_actual_bill', 1)->count();		
	}
	elseif($status == 'null')
	{
		$actual_bill = \App\Training::where('approve_direktur_id', \Auth::user()->id)->where('status', 2)->where('status_actual_bill', 2)->whereNull('approve_direktur_actual_bill')->count();		
	}

	return $data + $actual_bill;
}

/**
 * @param  string
 * @return [type]
 */
function cek_training_atasan($status ='approved')
{
	// cek approval training
	if($status=='approved')
	{
		$data = \App\Training::where('approved_atasan_id', \Auth::user()->id)->where('is_approved_atasan', 1)->count();		
	}
	elseif($status == 'null')
	{
		$data = \App\Training::where('approved_atasan_id', \Auth::user()->id)->whereNull('is_approved_atasan')->count();		
	}
	elseif($data = 'all')
	{
		$data = \App\Training::where('approved_atasan_id', \Auth::user()->id)->count();
	}

	// cek approval actual bill training
	if($status=='approved')
	{
		$actual_bill = \App\Training::where('approved_atasan_id', \Auth::user()->id)->where('status', 2)->where('is_approve_atasan_actual_bill', 1)->count();		
	}
	elseif($status == 'null')
	{
		$actual_bill = \App\Training::where('approved_atasan_id', \Auth::user()->id)->where('status', 2)->whereNull('is_approve_atasan_actual_bill')->count();		
	}

	return $data + $actual_bill;
}

/**
 * @param  string
 * @param  integer
 * @return [type]
 */
function cek_cuti_atasan($status='approved')
{
	if($status =='null')
	{
		return \App\CutiKaryawan::where('approved_atasan_id', \Auth::user()->id)->whereNull('is_approved_atasan')->count();
	}
	elseif($status =='approved')
	{
		return \App\CutiKaryawan::where('approved_atasan_id', \Auth::user()->id)->where('is_approved_atasan',1)->count();
	}
	elseif($status=='reject')
	{
		return \App\CutiKaryawan::where('approved_atasan_id', \Auth::user()->id)->where('is_approved_atasan',0)->count();
	}
	elseif($status=='all')
	{
		return \App\CutiKaryawan::where('approved_atasan_id', \Auth::user()->id)->count();
	}
}