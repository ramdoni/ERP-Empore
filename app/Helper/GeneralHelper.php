<?php


/**
 * [format_tanggal description]
 * @param  [type] $date [description]
 * @return [type]       [description]
 */
function format_tanggal($date, $format='tanggal')
{
	if($format=='tanggal')
	{
		return date('d F Y', strtotime($date));		
	}

	if($format=='tanggal_jam')
	{
		return date('d F Y H:i:s', strtotime($date));		
	}
	
}


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

        if(empty($user->empore_organisasi_staff_id) and !empty($user->empore_organisasi_supervisor_id)):
            return 'Supervisor';
        endif;

        if(empty($user->empore_organisasi_staff_id) and empty($user->empore_organisasi_supervisor_id) and !empty($user->empore_organisasi_manager_id)):
            return 'Manager';
        endif;

        if(empty($user->empore_organisasi_staff_id) and empty($user->empore_organisasi_supervisor_id) and empty($user->empore_organisasi_manager_id) and !empty($user->empore_organisasi_direktur)):
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
	$organisasi = ['Staff','Supervisor', 'Manager', 'Direktur'];
	
	return $organisasi;
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
	if($status =='null')
	{
		return \App\CutiKaryawan::where('approve_direktur_id', \Auth::user()->id)->where('status' ,'<' ,3)->whereNull('approve_direktur')->count();
	}
	elseif($status =='approved')
	{
		return \App\CutiKaryawan::where('approve_direktur_id', \Auth::user()->id)->where('approve_direktur',1)->count();
	}
	elseif($status=='reject')
	{
		return \App\CutiKaryawan::where('approve_direktur_id', \Auth::user()->id)->where('approve_direktur',0)->count();
	}
	elseif($status=='all')
	{
		return \App\CutiKaryawan::where('approve_direktur_id', \Auth::user()->id)->count();
	}
	
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
		return \App\CutiKaryawan::where('approved_atasan_id', \Auth::user()->id)->where('status' ,'<' ,3)->whereNull('is_approved_atasan')->count();
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

function cek_cuti_manager($status='approved')
{
	if($status =='null')
	{
		return \App\CutiKaryawan::where('approved_manager_id', \Auth::user()->id)->where('status' ,'<' ,3)->whereNull('is_approved_manager')->count();
	}
	elseif($status =='approved')
	{
		return \App\CutiKaryawan::where('approved_manager_id', \Auth::user()->id)->where('is_approved_manager',1)->count();
	}
	elseif($status=='reject')
	{
		return \App\CutiKaryawan::where('approved_manager_id', \Auth::user()->id)->where('is_approved_manager',0)->count();
	}
	elseif($status=='all')
	{
		return \App\CutiKaryawan::where('approved_manager_id', \Auth::user()->id)->count();
	}
}