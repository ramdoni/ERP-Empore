<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ModelUser;
use Auth;
use Session;
use Illuminate\Support\Facades\Input;


class AjaxEmporeController extends Controller
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
     * [getManagerByDirektur description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getManagerByDirektur(Request $request)
    {   
        $params['status']   = 'success';
        $params['code']     = 202;

        if($request->ajax())
        {
            $data = \App\EmporeOrganisasiManager::where('empore_organisasi_direktur_id', $request->id)->get();
            
            $params['data'] = $data;  
        }   
        
        return response()->json($params);
    }

    /**
     * [getStaffByManager description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getSupervisorByManager(Request $request)
    {   
        $params['status']   = 'success';
        $params['code']     = 202;

        if($request->ajax())
        {
            $data = \App\EmporeOrganisasiSupervisor::where('empore_organisasi_manager_id', $request->id)->get();
            
            $params['data'] = $data;  
        }   
        
        return response()->json($params);
    }

    public function getStaffBySupervisor(Request $request)
    {   
        $params['status']   = 'success';
        $params['code']     = 202;

        if($request->ajax())
        {
            $data = \App\EmporeOrganisasiStaff::where('empore_organisasi_supervisor_id', $request->id)->get();
            
            $params['data'] = $data;  
        }   
        
        return response()->json($params);
    }
}