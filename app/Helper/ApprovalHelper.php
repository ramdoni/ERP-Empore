<?php


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
		$data = \App\Training::where('approve_direktur_id', \Auth::user()->id)->where('status' ,'<' ,3)->whereNull('approve_direktur')->count();		
	}
	elseif($status == 'all')
	{
		$data = \App\Training::where('approve_direktur_id', \Auth::user()->id)->count();		
	}

	if($status=='approved')
	{
		$actual_bill = \App\Training::where('approve_direktur_id', \Auth::user()->id)->where('status', 2)->where('approve_direktur_actual_bill', 1)->count();		
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
		$data = \App\Training::where('approved_atasan_id', \Auth::user()->id)->where('status' ,'<' ,3)->whereNull('is_approved_atasan')->count();		
	}
	elseif($data = 'all')
	{
		$data = \App\Training::where('approved_atasan_id', \Auth::user()->id)->count();
	}

	// cek approval actual bill training
	if($status=='all')
	{
		$actual_bill = \App\Training::where('approved_atasan_id', \Auth::user()->id)->where('status', 2)->count();		
	}
	elseif($status=='approved')
	{
		$actual_bill = \App\Training::where('approved_atasan_id', \Auth::user()->id)->where('status', 2)->where('is_approve_atasan_actual_bill', 1)->count();		
	}
	elseif($status == 'null')
	{
		$actual_bill = \App\Training::where('approved_atasan_id', \Auth::user()->id)->where('status_actual_bill', 2)->where('status', 2)->whereNull('is_approve_atasan_actual_bill')->count();		
	}

	return $data + $actual_bill;
}

function cek_training_manager($status ='approved')
{
	// cek approval training
	if($status=='approved')
	{
		$data = \App\Training::where('approved_manager_id', \Auth::user()->id)->where('is_approved_manager', 1)->count();		
	}
	elseif($status == 'null')
	{
		$data = \App\Training::where('approved_manager_id', \Auth::user()->id)->where('status' ,'<' ,3)->whereNull('is_approved_manager')->count();		
	}
	elseif($data = 'all')
	{
		$data = \App\Training::where('approved_manager_id', \Auth::user()->id)->count();
	}

	// cek approval actual bill training
	if($status=='all')
	{
		$actual_bill = \App\Training::where('approved_manager_id', \Auth::user()->id)->where('status', 2)->count();		
	}
	elseif($status=='approved')
	{
		$actual_bill = \App\Training::where('approved_manager_id', \Auth::user()->id)->where('status', 2)->where('is_approve_manager_actual_bill', 1)->count();		
	}
	elseif($status == 'null')
	{
		$actual_bill = \App\Training::where('approved_manager_id', \Auth::user()->id)->where('status_actual_bill', 2)->where('status', 2)->whereNull('is_approve_manager_actual_bill')->count();		
	}

	return $data + $actual_bill;
}
