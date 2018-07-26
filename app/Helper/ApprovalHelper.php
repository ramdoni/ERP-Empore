<?php

/**
 * [approval_count_exit description]
 * @param  string $status  [description]
 * @param  string $jabatan [description]
 * @return [type]          [description]
 */
function approval_count_exit($status='all', $jabatan='direktur')
{
	if($jabatan == 'direktur')
	{
		if($status =='null')
		{
			return \App\ExitInterview::where('approve_direktur_id', \Auth::user()->id)->whereNull('approve_direktur')->count();
		}
		elseif($status =='approved')
		{
			return \App\ExitInterview::where('approve_direktur_id', \Auth::user()->id)->where('approve_direktur',1)->count();
		}
		elseif($status=='reject')
		{
			return \App\ExitInterview::where('approve_direktur_id', \Auth::user()->id)->where('approve_direktur',0)->count();
		}
		elseif($status=='all')
		{
			return \App\ExitInterview::where('approve_direktur_id', \Auth::user()->id)->count();
		}
	}
	elseif($jabatan == 'atasan')
	{
		if($status =='null')
		{
			return \App\ExitInterview::where('approved_atasan_id', \Auth::user()->id)->whereNull('is_approved_atasan')->count();
		}
		elseif($status =='approved')
		{
			return \App\ExitInterview::where('approved_atasan_id', \Auth::user()->id)->where('is_approved_atasan',1)->count();
		}
		elseif($status=='reject')
		{
			return \App\ExitInterview::where('approved_atasan_id', \Auth::user()->id)->where('is_approved_atasan',0)->count();
		}
		elseif($status=='all')
		{
			return \App\ExitInterview::where('approved_atasan_id', \Auth::user()->id)->count();
		}
	}

	return $data;
}

/**
 * @param  string
 * @param  string
 * @return [type]
 */
function approval_count_overtime($status='all', $jabatan='direktur')
{
	if($jabatan == 'direktur')
	{
		if($status =='null')
		{
			return \App\OvertimeSheet::where('approve_direktur_id', \Auth::user()->id)->whereNull('approve_direktur')->count();
		}
		elseif($status =='approved')
		{
			return \App\OvertimeSheet::where('approve_direktur_id', \Auth::user()->id)->where('approve_direktur',1)->count();
		}
		elseif($status=='reject')
		{
			return \App\OvertimeSheet::where('approve_direktur_id', \Auth::user()->id)->where('approve_direktur',0)->count();
		}
		elseif($status=='all')
		{
			return \App\OvertimeSheet::where('approve_direktur_id', \Auth::user()->id)->count();
		}
	}
	elseif($jabatan == 'atasan')
	{
		if($status =='null')
		{
			return \App\OvertimeSheet::where('approved_atasan_id', \Auth::user()->id)->whereNull('is_approved_atasan')->count();
		}
		elseif($status =='approved')
		{
			return \App\OvertimeSheet::where('approved_atasan_id', \Auth::user()->id)->where('is_approved_atasan',1)->count();
		}
		elseif($status=='reject')
		{
			return \App\OvertimeSheet::where('approved_atasan_id', \Auth::user()->id)->where('is_approved_atasan',0)->count();
		}
		elseif($status=='all')
		{
			return \App\OvertimeSheet::where('approved_atasan_id', \Auth::user()->id)->count();
		}
	}

	return $data;
}

/**
 * @param  string
 * @param  string
 * @return [type]
 */
function approval_count_medical($status='all', $jabatan='direktur')
{

	if($jabatan == 'direktur')
	{
		if($status =='null')
		{
			return \App\MedicalReimbursement::where('approve_direktur_id', \Auth::user()->id)->whereNull('approve_direktur')->count();
		}
		elseif($status =='approved')
		{
			return \App\MedicalReimbursement::where('approve_direktur_id', \Auth::user()->id)->where('approve_direktur',1)->count();
		}
		elseif($status=='reject')
		{
			return \App\MedicalReimbursement::where('approve_direktur_id', \Auth::user()->id)->where('approve_direktur',0)->count();
		}
		elseif($status=='all')
		{
			return \App\MedicalReimbursement::where('approve_direktur_id', \Auth::user()->id)->count();
		}
	}
	elseif($jabatan == 'atasan')
	{
		if($status =='null')
		{
			return \App\MedicalReimbursement::where('approved_atasan_id', \Auth::user()->id)->whereNull('is_approved_atasan')->count();
		}
		elseif($status =='approved')
		{
			return \App\MedicalReimbursement::where('approved_atasan_id', \Auth::user()->id)->where('is_approved_atasan',1)->count();
		}
		elseif($status=='reject')
		{
			return \App\MedicalReimbursement::where('approved_atasan_id', \Auth::user()->id)->where('is_approved_atasan',0)->count();
		}
		elseif($status=='all')
		{
			return \App\MedicalReimbursement::where('approved_atasan_id', \Auth::user()->id)->count();
		}
	}

	return $data;
}

/**
 * @param  string
 * @return [type]
 */
function approval_count_payment_request($status='all', $jabatan='direktur')
{

	if($jabatan == 'direktur')
	{
		if($status =='null')
		{
			return \App\PaymentRequest::where('approve_direktur_id', \Auth::user()->id)->whereNull('approve_direktur')->count();
		}
		elseif($status =='approved')
		{
			return \App\PaymentRequest::where('approve_direktur_id', \Auth::user()->id)->where('approve_direktur',1)->count();
		}
		elseif($status=='reject')
		{
			return \App\PaymentRequest::where('approve_direktur_id', \Auth::user()->id)->where('approve_direktur',0)->count();
		}
		elseif($status=='all')
		{
			return \App\PaymentRequest::where('approve_direktur_id', \Auth::user()->id)->count();
		}
	}
	elseif($jabatan == 'atasan')
	{
		if($status =='null')
		{
			return \App\PaymentRequest::where('approved_atasan_id', \Auth::user()->id)->whereNull('is_approved_atasan')->count();
		}
		elseif($status =='approved')
		{
			return \App\PaymentRequest::where('approved_atasan_id', \Auth::user()->id)->where('is_approved_atasan',1)->count();
		}
		elseif($status=='reject')
		{
			return \App\PaymentRequest::where('approved_atasan_id', \Auth::user()->id)->where('is_approved_atasan',0)->count();
		}
		elseif($status=='all')
		{
			return \App\PaymentRequest::where('approved_atasan_id', \Auth::user()->id)->count();
		}
	}

	return $data;
} 