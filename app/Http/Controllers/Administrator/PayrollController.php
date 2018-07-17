<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PayrollController extends Controller
{   

	public function __construct(\Maatwebsite\Excel\Excel $excel)
	{
	    $this->excel = $excel;
	}

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        $params['data'] = \App\Payroll::orderBy('id', 'DESC')->get();
        
        if(isset($_GET['is_calculate']))
        {
            $params['data'] = \App\Payroll::where('is_calculate', $_GET['is_calculate'])->orderBy('id', 'DESC')->get();
        }   

        return view('administrator.payroll.index')->with($params);
    }

    /**
     * [import description]
     * @return [type] [description]
     */
    public function import()
    {	
    	return view('administrator.payroll.import');
    }

    /**
     * [create description]
     * @return [type] [description]
     */
    public function create()
    {
        return view('administrator.payroll.create');
    }

    /**
     * [store description]
     * @return [type] [description]
     */
    public function store(Request $request)
    {
        $temp = new \App\Payroll();

        $temp->user_id              = $request->user_id;
        $temp->salary               = str_replace(',', '', $request->salary);
        $temp->jkk                  = $request->jkk;
        $temp->call_allow           = $request->call_allow;
        $temp->bonus                = str_replace(',', '', $request->bonus);
        $temp->jkk_result           = str_replace(',', '', $request->jkk_result);
        $temp->gross_income         = str_replace(',', '', $request->gross_income); 
        $temp->burden_allow         = str_replace(',', '', $request->burden_allow);
        $temp->jamsostek_result     = str_replace(',', '', $request->jamsostek);
        $temp->total_deduction      = str_replace(',', '', $request->total_deduction);
        $temp->net_yearly_income    = str_replace(',', '', $request->net_yearly_income);
        $temp->untaxable_income     = str_replace(',', '', $request->untaxable_income);
        $temp->taxable_yearly_income        = str_replace(',', '', $request->taxable_yearly_income);
        $temp->income_tax_calculation_5     = str_replace(',', '', $request->income_tax_calculation_5); 
        $temp->income_tax_calculation_15    = str_replace(',', '', $request->income_tax_calculation_15); 
        $temp->income_tax_calculation_25    = str_replace(',', '', $request->income_tax_calculation_25); 
        $temp->income_tax_calculation_30    = str_replace(',', '', $request->income_tax_calculation_30); 
        $temp->yearly_income_tax            = str_replace(',', '', $request->yearly_income_tax);
        $temp->monthly_income_tax           = str_replace(',', '', $request->monthly_income_tax);
        $temp->basic_salary                 = str_replace(',', '', $request->basic_salary);
        $temp->less                         = str_replace(',', '', $request->less);
        $temp->thp                          = str_replace(',', '', $request->thp);
        $temp->is_calculate                 = 1;
        $temp->save();
        $payroll_id = $temp->id;


        // Insert History
        $temp = new \App\PayrollHistory();
        $temp->payroll_id            = $payroll_id;
        $temp->user_id              = $request->user_id;
        $temp->salary               = str_replace(',', '', $request->salary);
        $temp->jkk                  = $request->jkk;
        $temp->call_allow           = $request->call_allow;
        $temp->bonus                = str_replace(',', '', $request->bonus);
        $temp->jkk_result           = str_replace(',', '', $request->jkk_result);
        $temp->gross_income         = str_replace(',', '', $request->gross_income); 
        $temp->burden_allow         = str_replace(',', '', $request->burden_allow);
        $temp->jamsostek_result     = str_replace(',', '', $request->jamsostek);
        $temp->total_deduction      = str_replace(',', '', $request->total_deduction);
        $temp->net_yearly_income    = str_replace(',', '', $request->net_yearly_income);
        $temp->untaxable_income     = str_replace(',', '', $request->untaxable_income);
        $temp->taxable_yearly_income        = str_replace(',', '', $request->taxable_yearly_income);
        $temp->income_tax_calculation_5     = str_replace(',', '', $request->income_tax_calculation_5); 
        $temp->income_tax_calculation_15    = str_replace(',', '', $request->income_tax_calculation_15); 
        $temp->income_tax_calculation_25    = str_replace(',', '', $request->income_tax_calculation_25); 
        $temp->income_tax_calculation_30    = str_replace(',', '', $request->income_tax_calculation_30); 
        $temp->yearly_income_tax            = str_replace(',', '', $request->yearly_income_tax);
        $temp->monthly_income_tax           = str_replace(',', '', $request->monthly_income_tax);
        $temp->basic_salary                 = str_replace(',', '', $request->basic_salary);
        $temp->less                         = str_replace(',', '', $request->less);
        $temp->thp                          = str_replace(',', '', $request->thp);
        $temp->save();

        return redirect()->route('administrator.payroll.index')->with('message-success', 'Data berhasil disimpan');
    }

    /**
     * [update description]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function update(Request $request, $id)
    {
        $temp = \App\Payroll::where('id', $id)->first();

        $temp->salary               = str_replace(',', '', $request->salary);
        $temp->jkk                  = $request->jkk;
        $temp->call_allow           = $request->call_allow;
        $temp->bonus                = str_replace(',', '', $request->bonus);
        $temp->jkk_result           = str_replace(',', '', $request->jkk_result);
        $temp->gross_income         = str_replace(',', '', $request->gross_income); 
        $temp->burden_allow         = str_replace(',', '', $request->burden_allow);
        $temp->jamsostek_result     = str_replace(',', '', $request->jamsostek);
        $temp->total_deduction      = str_replace(',', '', $request->total_deduction);
        $temp->net_yearly_income    = str_replace(',', '', $request->net_yearly_income);
        $temp->untaxable_income     = str_replace(',', '', $request->untaxable_income);
        $temp->taxable_yearly_income        = str_replace(',', '', $request->taxable_yearly_income);
        $temp->income_tax_calculation_5     = str_replace(',', '', $request->income_tax_calculation_5); 
        $temp->income_tax_calculation_15    = str_replace(',', '', $request->income_tax_calculation_15); 
        $temp->income_tax_calculation_25    = str_replace(',', '', $request->income_tax_calculation_25); 
        $temp->income_tax_calculation_30    = str_replace(',', '', $request->income_tax_calculation_30); 
        $temp->yearly_income_tax            = str_replace(',', '', $request->yearly_income_tax);
        $temp->monthly_income_tax           = str_replace(',', '', $request->monthly_income_tax);
        $temp->basic_salary                 = str_replace(',', '', $request->basic_salary);
        $temp->less                         = str_replace(',', '', $request->less);
        $temp->thp                          = str_replace(',', '', $request->thp);
        $temp->save();

        $temp = new \App\PayrollHistory();
        $temp->payroll_id            = $id;
        $temp->user_id              = $request->user_id;
        $temp->salary               = str_replace(',', '', $request->salary);
        $temp->jkk                  = $request->jkk;
        $temp->call_allow           = $request->call_allow;
        $temp->bonus                = str_replace(',', '', $request->bonus);
        $temp->jkk_result           = str_replace(',', '', $request->jkk_result);
        $temp->gross_income         = str_replace(',', '', $request->gross_income); 
        $temp->burden_allow         = str_replace(',', '', $request->burden_allow);
        $temp->jamsostek_result     = str_replace(',', '', $request->jamsostek);
        $temp->total_deduction      = str_replace(',', '', $request->total_deduction);
        $temp->net_yearly_income    = str_replace(',', '', $request->net_yearly_income);
        $temp->untaxable_income     = str_replace(',', '', $request->untaxable_income);
        $temp->taxable_yearly_income        = str_replace(',', '', $request->taxable_yearly_income);
        $temp->income_tax_calculation_5     = str_replace(',', '', $request->income_tax_calculation_5); 
        $temp->income_tax_calculation_15    = str_replace(',', '', $request->income_tax_calculation_15); 
        $temp->income_tax_calculation_25    = str_replace(',', '', $request->income_tax_calculation_25); 
        $temp->income_tax_calculation_30    = str_replace(',', '', $request->income_tax_calculation_30); 
        $temp->yearly_income_tax            = str_replace(',', '', $request->yearly_income_tax);
        $temp->monthly_income_tax           = str_replace(',', '', $request->monthly_income_tax);
        $temp->basic_salary                 = str_replace(',', '', $request->basic_salary);
        $temp->less                         = str_replace(',', '', $request->less);
        $temp->thp                          = str_replace(',', '', $request->thp);
        $temp->save();

        return redirect()->route('administrator.payroll.index')->with('message-success', 'Data berhasil disimpan');
    }

    /**
     * [download description]
     * @return [type] [description]
     */
    public function download()
    {
        $users = \App\User::where('access_id', 2)->get();

        $params = [];

        foreach($users as $k =>  $i)
        {
            // cek data payroll
            $payroll = \App\Payroll::where('user_id', $i->id)->first();

            $params[$k]['NO']           = $k+1;
            $params[$k]['NIK']          = $i->nik;
            $params[$k]['Nama']         = $i->name;

            if($payroll)
            {
                $params[$k]['Salary']                           = $payroll->salary;
                $params[$k]['% JKK (Accident) + JK (Death)']    = $payroll->jkk;
                $params[$k]['Call Allowance']                   = $payroll->call_allow;
                $params[$k]['Yearly Bonus, THR or others']      = $payroll->bonus;
            }
            else
            {
                $params[$k]['Salary']                           = 0;
                $params[$k]['% JKK (Accident) + JK (Death)']    = 0;
                $params[$k]['Call Allowance']                   = 0;
                $params[$k]['Yearly Bonus, THR or others']      = 0;
            }
        }

        return \Excel::create('datapayroll',  function($excel) use($params){
              $excel->sheet('mysheet',  function($sheet) use($params){
                $sheet->fromArray($params);
              });
        })->download('xls');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {
        $params['data'] = \App\Payroll::where('id', $id)->first();

        return view('administrator.payroll.detail')->with($params);
    }

    /**
     * [calculate description]
     * @return [type] [description]
     */
    public function calculate()
    {
        $data = \App\Payroll::all();

        $biaya_jabatan = \App\PayrollOthers::where('id', 1)->first()->value;
        $upah_minimum = \App\PayrollOthers::where('id', 2)->first()->value;

        foreach($data as $item)
        {
           // if($item->is_calculate == 1) continue;

            $temp = \App\Payroll::where('id', $item->id)->first();

            $jkk_result = 0;
            if(!empty($item->jkk))
            {
                $jkk_result             = ($item->salary * $item->jkk / 100);                
            }

            $gross_income = (($item->salary + $item->call_allow + $jkk_result)* 12) + $item->bonus;
            // burdern allowance
            $burden_allow = 5 * $gross_income / 100;
            if($burden_allow > $biaya_jabatan)
            {
                $burden_allow = $biaya_jabatan;
            }

            // Jamsostek Premium
            $jamsostek = 0;
            $jamsostek_persen = 3;
            if($item->salary > $upah_minimum)
            {
                $jamsostek = ($item->salary * $jamsostek_persen / 100) * 12;
            }
            else
            {
                $jamsostek = ($upah_minimum * $jamsostek_persen / 100) * 12;

            }

            $total_deduction = $jamsostek + $burden_allow;

            $net_yearly_income          = $gross_income - $total_deduction;

            $untaxable_income = 0;

            $ptkp = \App\PayrollPtkp::where('id', 1)->first();
            
            if(empty($item->user)) continue;
            if(empty($item->salary))continue;


            if($item->user->marital_status == 'Bujangan/Wanita')
            {
                $untaxable_income = $ptkp->bujangan_wanita;
            }
            if($item->user->marital_status == 'Menikah')
            {
                $untaxable_income = $ptkp->menikan;
            }
            if($item->user->marital_status == 'Menikah Anak 1')
            {
                $untaxable_income = $ptkp->menikah_anak_1;
            }
            if($item->user->marital_status == 'Menikah Anak 2')
            {
                $untaxable_income = $ptkp->menikah_anak_2;
            }
            if($item->user->marital_status == 'Menikah Anak 3')
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

            $temp->jkk_result           = $jkk_result;
            $temp->gross_income         = $gross_income; 
            $temp->burden_allow         = $burden_allow;
            $temp->jamsostek_result     = $jamsostek;
            $temp->total_deduction      = $total_deduction;
            $temp->net_yearly_income    = $net_yearly_income;
            $temp->untaxable_income     = $untaxable_income;
            $temp->taxable_yearly_income        = $taxable_yearly_income;
            $temp->income_tax_calculation_5     = $income_tax_calculation_5; 
            $temp->income_tax_calculation_15    = $income_tax_calculation_15; 
            $temp->income_tax_calculation_25    = $income_tax_calculation_25; 
            $temp->income_tax_calculation_30    = $income_tax_calculation_30; 
            $temp->yearly_income_tax            = $yearly_income_tax;
            $temp->monthly_income_tax           = $monthly_income_tax;
            $temp->basic_salary                 = $basic_salary;
            $temp->less                         = $less;
            $temp->thp                          = $thp;
            $temp->is_calculate                 = 1;
            $temp->save();

            $user_id        = $temp->user_id;
            $payroll_id     = $temp->id;

            $temp = new \App\PayrollHistory();
            $temp->payroll_id            = $payroll_id;
            $temp->user_id              = $user_id;
            $temp->salary               = str_replace(',', '', $item->salary);
            $temp->jkk                  = $item->jkk;
            $temp->call_allow           = $item->call_allow;
            $temp->bonus                = str_replace(',', '', $item->bonus);
            $temp->jkk_result           = str_replace(',', '', $jkk_result);
            $temp->gross_income         = str_replace(',', '', $gross_income); 
            $temp->burden_allow         = str_replace(',', '', $burden_allow);
            $temp->jamsostek_result     = str_replace(',', '', $jamsostek);
            $temp->total_deduction      = str_replace(',', '', $total_deduction);
            $temp->net_yearly_income    = str_replace(',', '', $net_yearly_income);
            $temp->untaxable_income     = str_replace(',', '', $untaxable_income);
            $temp->taxable_yearly_income        = str_replace(',', '', $taxable_yearly_income);
            $temp->income_tax_calculation_5     = str_replace(',', '', $income_tax_calculation_5); 
            $temp->income_tax_calculation_15    = str_replace(',', '', $income_tax_calculation_15); 
            $temp->income_tax_calculation_25    = str_replace(',', '', $income_tax_calculation_25); 
            $temp->income_tax_calculation_30    = str_replace(',', '', $income_tax_calculation_30); 
            $temp->yearly_income_tax            = str_replace(',', '', $yearly_income_tax);
            $temp->monthly_income_tax           = str_replace(',', '', $monthly_income_tax);
            $temp->basic_salary                 = str_replace(',', '', $basic_salary);
            $temp->less                         = str_replace(',', '', $less);
            $temp->thp                          = str_replace(',', '', $thp);
            $temp->save();
        }

        return redirect()->route('administrator.payroll.index')->with('messages-success', 'Data Payroll berhasil di calculate !');
    }

    /**
     * [import description]
     * @return [type] [description]
     */
    public function tempImport(Request $request)
    {	
    	$this->validate($request, [
	        'file' => 'required',
	    ]);

    	if($request->hasFile('file'))
        {
            //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = [];
            foreach ($worksheet->getRowIterator() AS $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                $cells = [];
                foreach ($cellIterator as $cell) {
                    $cells[] = $cell->getValue();
                }
                $rows[] = $cells;
            }

            // delete all table temp
            foreach($rows as $key => $row)
            {
            	if($key ==0) continue;

                $nik        = $row[1];
                $salary     = $row[3]; 
                $jkk        = $row[4];
                $call_allow = $row[5];
                $bonus      = $row[6];

                // cek user 
                $user = \App\User::where('nik', $nik)->first();
                if($user)
                {   
                    // cek exit payrol user
                    $payroll = \App\Payroll::where('user_id', $user->id)->first();
                    if(!$payroll)
                    {
                        $payroll            = new \App\Payroll();
                        $payroll->user_id   = $user->id;
                        $payroll->is_calculate  = 0;
                    } 
                    else
                    {
                        $is_calculate = 1;
                        if($payroll->salary != $salary) 
                        {
                            $is_calculate   = 0;
                            $payroll->salary= $salary;
                        }

                        if($payroll->jkk != $jkk) 
                        {
                            $is_calculate = 0;
                            $payroll->jkk = $jkk;
                        }

                        if($payroll->call_allow != $call_allow) 
                        {
                            $is_calculate       = 0;
                            $payroll->call_allow= $call_allow;
                        }

                        if($payroll->bonus != $bonus) 
                        {
                            $is_calculate   = 0;
                            $payroll->bonus = $bonus;
                        }

                        $payroll->is_calculate  = $is_calculate;
                    }
                    
                    $payroll->save();
                }
	        }

            return redirect()->route('administrator.payroll.index')->with('messages-success', 'Data Payroll berhasil di import');
        }
    }
}
