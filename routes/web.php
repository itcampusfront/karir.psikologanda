<?php

use App\Http\Controllers\HRDController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\StifinController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\SelectionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\PositionTestController;
use App\Http\Controllers\ApplicantRegisterController;
use Ajifatur\FaturHelper\Http\Controllers\Auth\LoginController as LGController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// \Ajifatur\Helpers\RouteExt::auth();
\Ajifatur\Helpers\RouteExt::admin();

// Guest Capabilities
Route::group(['middleware' => ['guest']], function() {

	// Home
	Route::get('/', function () {
	   return redirect()->route('auth.login');
	})->name('home');

	// Login
	Route::get('/login',[LoginController::class,'show'])->name('auth.login');
	Route::post('/login',[LGController::class, 'authenticate']);

	// Applicant Register
	Route::get('/lowongan/{code}/daftar/step-1', [ApplicantRegisterController::class,'showRegistrationFormStep1']);
	Route::post('/lowongan/{code}/daftar/step-1', [ApplicantRegisterController::class,'submitRegistrationFormStep1']);
	Route::get('/lowongan/{code}/daftar/step-2', [ApplicantRegisterController::class,'showRegistrationFormStep2']);
	Route::post('/lowongan/{code}/daftar/step-2', [ApplicantRegisterController::class,'submitRegistrationFormStep2']);
	Route::get('/lowongan/{code}/daftar/step-3', [ApplicantRegisterController::class,'showRegistrationFormStep3']);
	Route::post('/lowongan/{code}/daftar/step-3', [ApplicantRegisterController::class,'submitRegistrationFormStep3']);
	Route::get('/lowongan/{code}/daftar/step-4', [ApplicantRegisterController::class,'showRegistrationFormStep4']);
	Route::post('/lowongan/{code}/daftar/step-4', [ApplicantRegisterController::class,'submitRegistrationFormStep4']);
	Route::get('/lowongan/{code}/daftar/step-5', [ApplicantRegisterController::class,'showRegistrationFormStep5']);
	Route::post('/lowongan/{code}/daftar/step-5', [ApplicantRegisterController::class,'submitRegistrationFormStep5']);

	// URL Form
	Route::get('/lowongan/{url}', [VacancyController::class,'visit']);

	// Register as Applicant
	// Route::post('/register', 'RegisterController@store')->name('auth.register');

	// Register as General Member
	// Route::get('/register', 'Auth\RegisterController@showRegistrationForm');
	// Route::post('/register', 'Auth\RegisterController@submitRegistrationForm');
});
    
// Admin Capabilities
Route::group(['middleware' => ['admin']], function() {

	// Logout
	Route::post('/admin/logout',[LoginController::class,'logout'])->name('admin.logout');

	// Dashboard
	Route::get('/admin', function() {
		return view('admin/dashboard/index');
	})->name('admin.dashboard');

	// Profile
	Route::get('/admin/profile', [ProfileController::class, 'detail'])->name('admin.profile');
	Route::get('/admin/profile/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
	Route::post('/admin/profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');
	Route::get('/admin/profile/edit-password', [ProfileController::class, 'editPassword'])->name('admin.profile.edit-password');
	Route::post('/admin/profile/update-password', [ProfileController::class, 'updatePassword'])->name('admin.profile.update-password');

	// Office
	Route::get('/admin/office', [OfficeController::class,'index'])->name('admin.office.index');
	Route::get('/admin/office/create', [OfficeController::class,'create'])->name('admin.office.create');
	Route::post('/admin/office/store', [OfficeController::class,'store'])->name('admin.office.store');
	Route::get('/admin/office/edit/{id}', [OfficeController::class,'edit'])->name('admin.office.edit');
	Route::post('/admin/office/update', [OfficeController::class,'update'])->name('admin.office.update');
	Route::post('/admin/office/delete', [OfficeController::class,'delete'])->name('admin.office.delete');

	// Position
	Route::get('/admin/position', [PositionController::class,'index'])->name('admin.position.index');
	Route::get('/admin/position/create', [PositionController::class,'create'])->name('admin.position.create');
	Route::post('/admin/position/store', [PositionController::class,'store'])->name('admin.position.store');
	Route::get('/admin/position/edit/{id}', [PositionController::class,'edit'])->name('admin.position.edit');
	Route::post('/admin/position/update', [PositionController::class,'update'])->name('admin.position.update');
	Route::post('/admin/position/delete', [PositionController::class,'delete'])->name('admin.position.delete');

	// Vacancy
	
	
	Route::get('/admin/vacancy/data', [VacancyController::class,'getData'])->name('admin.vacancy.getData');
	Route::get('/admin/vacancy', [VacancyController::class,'index'])->name('admin.vacancy.index');
	Route::get('/admin/vacancy/create', [VacancyController::class,'create'])->name('admin.vacancy.create');
	Route::post('/admin/vacancy/store', [VacancyController::class,'store'])->name('admin.vacancy.store');
	Route::get('/admin/vacancy/edit/{id}',[VacancyController::class,'edit'] )->name('admin.vacancy.edit');
	Route::post('/admin/vacancy/update', [VacancyController::class,'update'])->name('admin.vacancy.update');
	Route::post('/admin/vacancy/delete', [VacancyController::class,'delete'])->name('admin.vacancy.delete');
	Route::get('/admin/vacancy/applicant/{id}',[VacancyController::class,'applicant'] )->name('admin.vacancy.applicant');
	Route::post('/admin/vacancy/update-status', [VacancyController::class,'updateStatus'])->name('admin.vacancy.update-status');

	// Selection
	Route::get('/admin/selection/getData', [SelectionController::class, 'getData'])->name('admin.selection.getData');
	Route::get('/admin/selection', [SelectionController::class, 'index'])->name('admin.selection.index');
	Route::post('/admin/selection/store', [SelectionController::class, 'store'])->name('admin.selection.store');
	Route::post('/admin/selection/update', [SelectionController::class, 'update'])->name('admin.selection.update');
	Route::post('/admin/selection/convert', [SelectionController::class, 'convert'])->name('admin.selection.convert');
	Route::post('/admin/selection/delete', [SelectionController::class, 'delete'])->name('admin.selection.delete');

	// Test
	Route::get('/admin/test', [TestController::class, 'index'])->name('admin.test.index');
	Route::get('/admin/test/create', [TestController::class, 'create'])->name('admin.test.create');
	Route::post('/admin/test/store', [TestController::class, 'store'])->name('admin.test.store');
	Route::get('/admin/test/edit/{id}', [TestController::class, 'edit'])->name('admin.test.edit');
	Route::post('/admin/test/update', [TestController::class, 'update'])->name('admin.test.update');
	Route::post('/admin/test/delete', [TestController::class, 'delete'])->name('admin.test.delete');
	// Route::post('/admin/test/generate-path', 'TesController@generatePath');
	// Route::get('/admin/test/settings/{path}', 'TesController@settings');
	// Route::get('/admin/test/settings/{path}/{paket}', 'TesController@editSettings');
	// Route::post('/admin/test/settings/{path}/{paket}/update', 'TesController@updateSettings');

	// Position Test
	Route::get('/admin/position-test', [PositionTestController::class,'index'])->name('admin.position-test.index');
	Route::post('/admin/position-test/change', [PositionTestController::class,'change'])->name('admin.position-test.change');

	// STIFIn
	Route::get('/admin/stifin', [StifinController::class, 'index'])->name('admin.stifin.index');
	Route::get('/admin/stifin/create', [StifinController::class, 'create'])->name('admin.stifin.create');
	Route::post('/admin/stifin/store', [StifinController::class, 'store'])->name('admin.stifin.store');
	Route::get('/admin/stifin/edit/{id}',[StifinController::class, 'edit'] )->name('admin.stifin.edit');
	Route::post('/admin/stifin/update',[StifinController::class, 'update'] )->name('admin.stifin.update');
	Route::post('/admin/stifin/delete', [StifinController::class, 'delete'])->name('admin.stifin.delete');
	Route::get('/admin/stifin/print/{id}', [StifinController::class, 'print'])->name('admin.stifin.print');

	// Result
	Route::get('/admin/result', [ResultController::class,'index'])->name('admin.result.index');
	Route::get('/admin/result/detail/{id}', [ResultController::class,'detail'])->name('admin.result.detail');
	Route::post('/admin/result/delete', [ResultController::class,'delete'])->name('admin.result.delete');
	Route::post('/admin/result/print', [ResultController::class,'print'])->name('admin.result.print'); // TBC

	// HRD
	Route::get('/admin/hrd', [HRDController::class,'index'])->name('admin.hrd.index');
	Route::get('/admin/hrd/create', [HRDController::class,'create'])->name('admin.hrd.create');
	Route::post('/admin/hrd/store', [HRDController::class,'store'])->name('admin.hrd.store');
	Route::get('/admin/hrd/detail/{id}', [HRDController::class,'detail'])->name('admin.hrd.detail');
	Route::get('/admin/hrd/edit/{id}', [HRDController::class,'edit'])->name('admin.hrd.edit');
	Route::post('/admin/hrd/update', [HRDController::class,'update'])->name('admin.hrd.update');
	Route::post('/admin/hrd/delete', [HRDController::class,'delete'])->name('admin.hrd.delete');

	// Employee
	Route::get('/admin/employee', [EmployeeController::class,'index'])->name('admin.employee.index');
	Route::get('/admin/employee/create', [EmployeeController::class,'create'])->name('admin.employee.create');
	Route::post('/admin/employee/store', [EmployeeController::class,'store'])->name('admin.employee.store');
	Route::get('/admin/employee/detail/{id}', [EmployeeController::class,'detail'])->name('admin.employee.detail');
	Route::get('/admin/employee/edit/{id}', [EmployeeController::class,'edit'])->name('admin.employee.edit');
	Route::post('/admin/employee/update', [EmployeeController::class,'update'])->name('admin.employee.update');
	Route::post('/admin/employee/delete', [EmployeeController::class,'delete'])->name('admin.employee.delete');
	Route::get('/admin/employee/export', [EmployeeController::class,'export'])->name('admin.employee.export');
	Route::post('/admin/employee/import', [EmployeeController::class,'import'])->name('admin.employee.import');

	// Applicant
	Route::get('/admin/applicant', [ApplicantController::class, 'index'])->name('admin.applicant.index');
	Route::get('/admin/applicant/create',[ApplicantController::class, 'create'] )->name('admin.applicant.create');
	Route::post('/admin/applicant/store', [ApplicantController::class, 'store'])->name('admin.applicant.store');
	Route::get('/admin/applicant/detail/{id}',[ApplicantController::class, 'detail'] )->name('admin.applicant.detail');
	Route::get('/admin/applicant/edit/{id}', [ApplicantController::class, 'edit'])->name('admin.applicant.edit');
	Route::post('/admin/applicant/update', [ApplicantController::class, 'update'])->name('admin.applicant.update');
	Route::post('/admin/applicant/delete', [ApplicantController::class, 'delete'])->name('admin.applicant.delete');
	Route::get('/admin/applicant/export', [ApplicantController::class, 'export'])->name('admin.applicant.export');
	
	// Internship
	Route::get('/admin/internship/getVacan', [InternshipController::class,'getVacan'])->name('admin.internship.getVacan');
	Route::get('/admin/internship', [InternshipController::class, 'index'])->name('admin.internship.index');
	Route::get('/admin/internship/create', [InternshipController::class, 'create'])->name('admin.internship.create');
	Route::post('/admin/internship/store', [InternshipController::class, 'store'])->name('admin.internship.store');
	Route::get('/admin/internship/detail/{id}', [InternshipController::class, 'detail'])->name('admin.internship.detail');
	Route::get('/admin/internship/edit/{id}', [InternshipController::class, 'edit'])->name('admin.internship.edit');
	Route::post('/admin/internship/update', [InternshipController::class, 'update'])->name('admin.internship.update');
	Route::post('/admin/internship/delete', [InternshipController::class, 'delete'])->name('admin.internship.delete');
	Route::get('/admin/internship/export', [InternshipController::class, 'export'])->name('admin.internship.export');
	Route::post('/admin/internship/import', [InternshipController::class, 'import'])->name('admin.internship.import');
	
	// Student
	Route::get('/admin/student', [StudentController::class,'index'])->name('admin.student.index');
	Route::get('/admin/student/create', [StudentController::class,'create'])->name('admin.student.create');
	Route::post('/admin/student/store', [StudentController::class,'store'])->name('admin.student.store');
	Route::get('/admin/student/detail/{id}', [StudentController::class,'detail'])->name('admin.student.detail');
	Route::get('/admin/student/edit/{id}', [StudentController::class,'edit'])->name('admin.student.edit');
	Route::post('/admin/student/update', [StudentController::class,'update'])->name('admin.student.update');
	Route::post('/admin/student/delete', [StudentController::class,'delete'])->name('admin.student.delete');
	Route::post('/admin/student/deleteAll', [StudentController::class,'deleteAll'])->name('admin.student.deleteAll');
	Route::get('/admin/student/export', [StudentController::class,'export'])->name('admin.student.export');
	Route::post('/admin/student/import', [StudentController::class,'import'])->name('admin.student.import');

	/******************************** */

	// Sync
	/*
	Route::get('/admin/sync/user', 'SyncController@user');
	Route::get('/admin/sync/applicant', 'SyncController@applicant');
	Route::get('/admin/sync/applicant/attachment', 'SyncController@applicantAttachment');
	Route::get('/admin/sync/applicant/socmed', 'SyncController@applicantSocmed');
	Route::get('/admin/sync/applicant/guardian', 'SyncController@applicantGuardian');
	Route::get('/admin/sync/applicant/skill', 'SyncController@applicantSkill');
	Route::get('/admin/sync/employee', 'SyncController@employee');
	Route::get('/admin/sync/internship', 'SyncController@internship');
	Route::get('/admin/sync/hrd', 'SyncController@hrd');

	Route::get('/admin/sync/company-test', 'SyncController@companyTest');
	Route::get('/admin/sync/position-test', 'SyncController@positionTest');
	Route::get('/admin/sync/position-skill', 'SyncController@positionSkill');
	Route::get('/admin/sync/selection', 'SyncController@selection');

	Route::get('/admin/sync/internship-result', 'SyncController@internshipResult');
	*/
});