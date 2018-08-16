<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssetController extends Controller
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
        $data   = \App\Asset::orderBy('id', 'DESC');
    
        if(isset($_GET['asset_type_id']))
        {
            if(!empty($_GET['asset_type_id']))
            {
                $data = $data->where('asset_type_id', $_GET['asset_type_id']);
            }

            if(!empty($_GET['asset_condition']))
            {
                $data = $data->where('asset_condition', $_GET['asset_condition']);
            }

            if(!empty($_GET['assign_to']))
            {
                $data = $data->where('assign_to', $_GET['assign_to']);
            }
        }

        $params['data'] = $data->get();

        return view('administrator.asset.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        $params['asset_type']       = \App\AssetType::all();
        $params['asset_number']     = $this->asset_number();
        
        return view('administrator.asset.create')->with($params);
    }

    /**
     * [asset_number description]
     * @return [type] [description]
     */
    public function asset_number()
    {
        $no = 0;

        $count = \App\Asset::count()+1;

        if(strlen($count) == 1)
        {
            $no = "000". $count;
        }

        if(strlen($count) == 2)
        {
            $no = "00". $count;
        }

        if(strlen($count) == 3)
        {
            $no = "0". $count;
        }

        if(strlen($count) == 4)
        {
            $no = $count;
        }

        return $no;
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data']         = \App\Asset::where('id', $id)->first();
        $params['asset_type']       = \App\AssetType::all();
        $params['asset_number']     = $this->asset_number();

        return view('administrator.asset.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data       = \App\Asset::where('id', $id)->first();
        $data->asset_name       = $request->asset_name;
        $data->asset_type_id    = $request->asset_type_id;
        $data->asset_sn         = $request->asset_sn;
        $data->purchase_date    = date('Y-m-d', strtotime($request->purchase_date));
        $data->asset_condition  = $request->asset_condition;
        $data->assign_to        = $request->assign_to;
        $data->user_id          = $request->user_id;
        $data->save();

        return redirect()->route('administrator.asset.index')->with('message-success', 'Data berhasil disimpan');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = \App\Asset::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.asset.index')->with('message-sucess', 'Data berhasi di hapus');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data       = new \App\Asset();
        $data->asset_number     = $request->asset_number; 
        $data->asset_name       = $request->asset_name;
        $data->asset_type_id    = $request->asset_type_id;
        $data->asset_sn         = $request->asset_sn;
        $data->purchase_date    = date('Y-m-d', strtotime($request->purchase_date));
        $data->asset_condition  = $request->asset_condition;
        $data->assign_to        = $request->assign_to;
        $data->user_id          = $request->user_id;
        $data->save();

        $params['data']         = \App\Asset::where('id', $data->id)->first();

        if($data->user->email != "")
        {
            \Mail::send('administrator.asset.acceptance-email', $params,
                function($message) use($data) {
                    $message->from('emporeht@gmail.com');
                    $message->to($data->user->email);
                    $message->subject('Empore - Asset Acceptance Confirmation');
                }
            );
        }

        return redirect()->route('administrator.asset.index')->with('message-success', 'Data berhasil disimpan !');
    }
}
