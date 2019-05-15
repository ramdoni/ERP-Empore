<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;

class InternalMemoController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params['data'] = \App\InternalMemo::orderBy('id', 'DESC')->get();

        return view('administrator.internal-memo.index')->with($params);
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {   
        return view('administrator.internal-memo.create');
    }

    /**
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id)
    {
        $params['data'] = \App\InternalMemo::where('id', $id)->first();

        return view('administrator.internal-memo.edit')->with($params);
    }

    /**
     * [update description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function update(Request $request, $id)
    {
        $data                   = \App\InternalMemo::where('id', $id)->first();
        $data->title            = $request->title;
        
        if (request()->hasFile('file'))
        {
            $file = $request->file('file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/internal-memo/');
            $file->move($destinationPath, $fileName);

            $data->file = $fileName;
        }

        $data->save();

        return redirect()->route('administrator.internal-memo.index')->with('message-success', 'Data saved successfully');
    }   

    /**
     * [desctroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        $data = \App\InternalMemo::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.internal-memo.index')->with('message-sucess', 'Data deleted successfully');
    }
    public function broadcast($id)
    {
        $data = \App\InternalMemo::where('id', $id)->first();

        $email_id = \App\User::select('email')->get()->pluck('email')->toArray(); 
        //dd($email_id);
        $data_user =  \App\User::where('access_id','2')->orderBy('id', 'DESC')->get();
        
       // dd($email_id);
        foreach ($data_user as $key => $value) { 
            
            if($value->email == "") continue;
            //dd($value->email);
            //dd($value);
            //dd($data->file);
            
            $params['data']     = $data;
                //$params['text']     = '<p><strong>Dear Bapak/Ibu INTERNAL MEMO 2.</p>';
                $params['text']     = '<p><strong>Dear Mr/Mrs/Ms '. $value->name .'</strong>,</p> <p>INTERNAL MEMO.</p>';

           \Mail::send('email.internalmemo', $params,
                function($message) use($data, $value) {
                    $file = public_path('storage/internal-memo/'.$data->file);
                    //dd($data->file);
                    $message->from('intimakmurnew@gmail.com');
                    $message->to($value->email);
                    $message->subject('INTERNAL MEMO');
                    if($data->file != null) {
                        $message->attach($file);
                    }
            });  
            
        }

        return redirect()->route('administrator.internal-memo.index')->with('message-sucess', 'Data sent successfully');
    } 

    /**
     * [store description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $data                   = new \App\InternalMemo();
        $data->title            = $request->title;

        if (request()->hasFile('file'))
        {
            $file = $request->file('file');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

            $destinationPath = public_path('/storage/internal-memo/');
            $file->move($destinationPath, $fileName);

            $data->file = $fileName;
        }

        $data->save();

        return redirect()->route('administrator.internal-memo.index')->with('message-success', 'Data saved successfully!');
    }
}
