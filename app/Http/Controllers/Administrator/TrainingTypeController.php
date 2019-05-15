<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TrainingType;

class TrainingTypeController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $params['data'] = TrainingType::orderBy('id', 'DESC')->get();

        return view('administrator.trainingtype.index')->with($params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('administrator.trainingtype.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data       = new TrainingType();
        $data->name             = $request->name;
        $data->description      = $request->description;
        $data->save();

        return redirect()->route('administrator.training-type.index')->with('message-success', 'Data successfully saved !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $params['data']         = TrainingType::where('id', $id)->first();

        return view('administrator.trainingtype.edit')->with($params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data       = TrainingType::where('id', $id)->first();
        $data->name   = $request->name; 
        $data->description      = $request->description;
        $data->save();

        return redirect()->route('administrator.training-type.index')->with('message-success', 'Data Successfully saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = TrainingType::where('id', $id)->first();
        $data->delete();

        return redirect()->route('administrator.training-type.index')->with('message-sucess', 'Data successfully deleted');
    }
}
