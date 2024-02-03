<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\Test;
use App\Models\User;
use App\Models\Result;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Test\ISTController;
use App\Http\Controllers\Test\SDIController;
use App\Http\Controllers\Test\MBTIController;
use App\Http\Controllers\Test\MSDTController;
use App\Http\Controllers\Test\RMIBController;
use App\Http\Controllers\Test\DISC1Controller;
use App\Http\Controllers\Test\DISC2Controller;
use App\Http\Controllers\Assesment10Controller;
use App\Http\Controllers\Test\AssesmentController;
use App\Http\Controllers\Test\Assesment11Controller;
use App\Http\Controllers\Test\Assesment20Controller;
use App\Http\Controllers\Test\PapikostickController;

class ResultController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Check the access
        has_access(method(__METHOD__), Auth::user()->role_id);

        if($request->ajax()) {
            // Get employee, applicant, student or internship results
            if(in_array($request->query('role'), [role('employee'), role('applicant'), role('internship'), role('student')])) {
                // Get the company
                $company_cek = $request->company_select; //get dari request filter
                $company_id = Company::find(Auth::user()->attribute->company_id); //get dari user company id
                $company = Auth::user()->role->is_global === 1 ? $company_cek : $company_id->id;

                // get test, role
                $test = $request->test_select;
                $role = $request->query('role');

                if($company && $test)
                    $results = Result::with(['user', 'company', 'test'])
                                    ->whereHas('user', function($query) use ($role){
                                        return $query->where('role_id','=', $role);
                                    })
                                    ->whereHas('company', function($query2) use ($company){
                                        return $query2->where('company_id','=',$company);
                                    })
                                    ->whereHas('test', function($query3) use ($test){
                                        return $query3->where('test_id','=',$test);
                                    });

                elseif($company && !$test)
                    $results = Result::with(['user', 'company', 'test'])
                                    ->whereHas('user', function($query) use ($role){
                                        return $query->where('role_id','=', $role);
                                    })
                                    ->whereHas('company', function($query2) use($company){
                                        return $query2->where('company_id','=',$company);
                                    })
                                    ->has('test');


                elseif(!$company && $test)
                    $results = Result::with(['user', 'company', 'test'])
                                    ->whereHas('user', function($query) use ($role){
                                        return $query->where('role_id','=', $role);
                                    })
                                    ->whereHas('test', function($query3) use ($test){
                                        return $query3->where('test_id','=',$test);
                                    })
                                    ->has('company');
                else
                    $results = Result::with(['user', 'company', 'test'])
                                    ->whereHas('user', function($query) use ($role){
                                        return $query->where('role_id','=', $role);
                                    })
                                    ->has('company')
                                    ->has('test');           
            }

            // Set
            // if(count($results) > 0) {
            //     foreach($results as $key=>$result) {
            //         $results[$key]->position_name = $user->attribute->position ? $user->attribute->position->name : '-';

            //     }
            // }

            // Return
            return DataTables::of($results)
                ->addColumn('checkbox', '<input type="checkbox" class="form-check-input checkbox-one">')

                ->editColumn('user.name', function($query){
                    $user_link = route('admin.result.detail', ['id' => $query->id]);
                    $user_html = 
                    '<span class="d-none">'.$query->user->name.'</span>
                        <a href="'.$user_link.'">'.ucwords($query->user->name).'</a>
                        <br>
                        <small class="text-muted">'.$query->user->username.'</small>
                    ';
                    return $user_html;
                })
                ->editColumn('company.name', function($query){
                    return $query->company->name;
                })
                // ->editColumn('position.name', function($query){
                //     return $query->user->attribute->position->name;
                // })
                ->editColumn('test.name', function($query){
                    return $query->test->name;
                })
                
                ->editColumn('created_at', function($query){
                    $created_at = $query->created_at;
                    $if1= $created_at != null ? $created_at : "";
                    $if2= $created_at != null ? date("d/m/Y", strtotime($created_at)) : "-";

                    $test_datetime = 
                    '
                        <span class="d-none">'.$if1.'</span>'.$if2.'
                        <br>
                        <small class="text-muted">'.date("H:i", strtotime($created_at))." WIB".'</small>
                    ';

                    return $test_datetime;
                })
                ->addColumn('options', function($query){
                    $user_id = $query->id;
                    $route_detail = route('admin.result.detail', ['id' => $user_id]);
                    $html_option = 
                    '
                        <div class="btn-group">
                            <a href="'.$route_detail.'" class="btn btn-sm btn-info" data-id="'.$user_id.'" data-bs-toggle="tooltip" title="Lihat Detail"><i class="bi-eye"></i></a>
                            <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="'.$user_id.'" data-bs-toggle="tooltip" title="Hapus"><i class="bi-trash"></i></a>
                        </div>
                    ';

                    return $html_option;
                })
                
                ->rawColumns(['user.name','checkbox','company.name','test.name','created_at','options'])
                ->make(true);
        }

        // Auto redirect to employee results
        if(!in_array($request->query('role'), [role('employee'), role('applicant'), role('internship'), role('student')])) {
            return redirect()->route('admin.result.index', ['role' => role('employee')]);
        }

        // Get tests
        $tests = Test::orderBy('name','asc')->get();

        // Get companies
        $companies = Company::orderBy('name','asc')->get();

        // $cek = Company::find(Auth::user()->attribute->company_id);
       
        // View
        return view('admin/result/index', [
            'tests' => $tests,
            'companies' => $companies,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        // Check the access
        has_access(method(__METHOD__), Auth::user()->role_id);

    	// Get the result
    	if(Auth::user()->role->is_global === 1) {
            $result = Result::has('user')->has('company')->has('test')->findOrFail($id);
        }
        elseif(Auth::user()->role->is_global === 0) {
            $company = Company::find(Auth::user()->attribute->company_id);
            $result = Result::has('user')->has('company')->has('test')->where('company_id','=',$company->id)->findOrFail($id);
        }

        // JSON decode
        $result->result = json_decode($result->result, true);

        // DISC 1.0
        if($result->test->code == 'disc-40-soal')
            return DISC1Controller::detail($result);
        // DISC 2.0
        elseif($result->test->code == 'disc-24-soal' || $result->test->code == 'disc-24-soal-1')
            return DISC2Controller::detail($result);
        // IST
        elseif($result->test->code == 'ist')
            return ISTController::detail($result);
        // MSDT
        elseif($result->test->code == 'msdt' || $result->test->code == 'msdt-1')
            return MSDtController::detail($result);
		// Assesment
        elseif($result->test->code == 'assesment' || $result->test->code == 'assesment-01')
            return AssesmentController::detail($result);
		// Assesment 1.0
        elseif($result->test->code == 'assesment-10' || $result->test->code == 'assesment-11')
            return Assesment10Controller::detail($result);
		// Assesment 2.0
        elseif($result->test->code == 'assesment-20' || $result->test->code == 'assesment-21')
            return Assesment20Controller::detail($result);
        // Papikostick
        elseif($result->test->code == 'papikostick' || $result->test->code == 'papikostick-1')
            return PapikostickController::detail($result);
        // SDI
        elseif($result->test->code == 'sdi')
            return SDIController::detail($result);
        // RMIB 1.0
        elseif($result->test->code == 'rmib')
            return RMIBController::detail($result);
        // RMIB 2.0
        elseif($result->test->code == 'rmib-2')
            return RMIBController::detail($result);
        elseif($result->test->code == 'mbti')
            return MBTIController::detail($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check the access
        has_access(method(__METHOD__), Auth::user()->role_id);
        
        // Get the result
        $result = Result::findOrFail($request->id);

        // Delete the result
        $result->delete();

        // Redirect
        return redirect()->route('admin.result.index', ['role' => $request->role])->with(['message' => 'Berhasil menghapus data.']);
    }

    /**
     * Print to PDF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function print(Request $request)
    {
        // Check the access
        has_access(method(__METHOD__), Auth::user()->role_id);
		
        ini_set('max_execution_time', '300');
		
        // DISC 1.0
        if($request->path == 'disc-40-soal')
            return DISC1Controller::print($request);
        // DISC 2.0
        elseif($request->path == 'disc-24-soal')
            return DISC2Controller::print($request);
        //--
        elseif($request->path == 'disc-24-soal-1')
            return DISC2Controller::cetak($request);
        // IST
        elseif($request->path == 'ist')
            // abort(404);
            return ISTController::print($request);
        // MSDT
        elseif($request->path == 'msdt')
            return MSDtController::print($request);
        //--
        elseif($request->path == 'msdt-1')
            return MSDtController::cetak($request);
		 // Assesment
        elseif($request->path == 'assesment')
            return AssesmentController::print($request);
        //--
        elseif($request->path == 'assesment-01')
            return AssesmentController::cetak($request);
		// Assesment 1.0
        elseif($request->path == 'assesment-10')
            return Assesment10Controller::print($request);
        //--
        elseif($request->path == 'assesment-11')
            return Assesment11Controller::cetak($request);
		// Assesment 2.0
        elseif($request->path == 'assesment-20')
            return Assesment20Controller::print($request);
        //--
        elseif($request->path == 'assesment-21')
            return Assesment20Controller::cetak($request);
        // Papikostick
        elseif($request->path == 'papikostick')
            return PapikostickController::print($request);
        //--
        elseif($request->path == 'papikostick-1')
            return PapikostickController::cetak($request);
        // SDI
        elseif($request->path == 'sdi')
            return SDIController::print($request);
        // RMIB 1.0
        elseif($request->path == 'rmib')
            return RMIBController::print($request);
        // RMIB 2.0
        elseif($request->path == 'rmib-2')
            return RMIBController::print($request);
        elseif($request->path == 'mbti')
            return MBTIController::print($request);
    }
}