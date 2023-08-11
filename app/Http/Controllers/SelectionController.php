<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Office;
use App\Models\Company;
use App\Models\Selection;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Ajifatur\Helpers\DateTimeExt;
use Illuminate\Support\Facades\Validator;

class SelectionController extends \App\Http\Controllers\Controller
{

    public function getData(Request $request)
    {
        // Get the company and selections
        if(Auth::user()->role->is_global === 1) {
            $company_id = $request->company_select;
            $test_id = $request->test_select;

            if($company_id != null && $test_id != null) {
                $company = Company::find($company_id);

                if($company && in_array($test_id, [1,2,0,99]))
                    $selections = Selection::with(['user','company','vacancy'])
                                            ->has('user')
                                            ->whereHas('company', function($query) use ($company){
                                                return $query->where('company_id','=',$company->id);
                                            })
                                            ->has('vacancy')
                                            ->where('status','=',$test_id)
                                            
                                            ;
                elseif($company && !in_array($test_id, [1,2,0,99]))
                    $selections = Selection::with(['user','company','vacancy'])
                                        ->has('user')
                                        ->whereHas('company', function($query) use ($company){
                                            return $query->where('company_id','=',$company->id);
                                        })
                                        ->has('vacancy')         
                                        
                                        ;
                elseif(!$company && in_array($test_id, [1,2,0,99]))
                    $selections = Selection::with(['user','company','vacancy'])
                                            ->has('user')
                                            ->has('company')
                                            ->has('vacancy')
                                            ->where('status','=',$test_id)
                                            
                                            ;
                else
                    $selections = Selection::with(['user','company','vacancy'])
                                            ->has('user')
                                            ->has('company')
                                            ->has('vacancy')
                                            
                                            ;
            }
            else {
                    $selections = Selection::with(['user','company','vacancy'])
                                            ->has('user')
                                            ->has('company')
                                            ->has('vacancy')

                                            ;
            }
        }
        elseif(Auth::user()->role->is_global === 0) {
            $test_id = $request->test_select;

            $company = Company::find(Auth::user()->attribute->company_id);
   
            if($request->test_select != null && in_array($request->test_select, [1,2,0,99]))
                $selections = Selection::with(['user','company','vacancy'])
                                        ->has('user')
                                        ->whereHas('company', function($query) use ($company) {
                                            return $query->where('company_id','=',$company->id);
                                        })
                                        ->has('vacancy')
                                        ->where('status','=',$request->test_select)
                                        ;
            else
                $selections = Selection::with(['user','company','vacancy'])
                                        ->has('user')
                                        ->whereHas('company', function($query) use ($company) {
                                            return $query->where('company_id','=',$company->id);
                                        })
                                        ->has('vacancy')
                                        ;
        }

        return DataTables::of($selections)
                    ->addColumn('checkbox', '<input type="checkbox" class="form-check-input checkbox-one">')
                    ->editColumn('user.name', function($query){
                        $user_name = $query->user->name;
                        //route applicant
                        $route_applicant = route('admin.applicant.detail', ['id' => $query->user_id]);
                        $link_applicant = '<a href="'.$route_applicant.'">'.ucwords($user_name).'</a>';
                        //route internship
                        $route_internship = route('admin.internship.detail', ['id' => $query->user_id]);
                        $link_internship = '<a href="'.$route_internship.'">'.ucwords($user_name).'</a>';
                        
                        $html_user = '<small class="text-muted"><i class="bi-envelope me-2"></i>'. $query->user->email .'</small>
                        <br>
                        <small class="text-muted"><i class="bi-phone me-2"></i>'. $query->user->attribute->phone_number .'</small>
                        ';

                        if ($query->user->role_id == 4){
                            $link = $link_applicant;
                            return $link.'<br>'.$html_user;
                        }
                        elseif ($query->user->role_id == 6){
                            $link = $link_internship;
                            return $link.'<br>'.$html_user;
                        }
                        
                    })
                    ->editColumn('user.username', function($query){
                        return $query->user->username;
                    })
                    ->editColumn('test_time', function($query){
                        $time = $query->test_time;
                        $if_time1= $time != null ? $time: '';
                        $if_time2= $time != null ? date('d/m/Y', strtotime($time)) : '-';
                        $if_time3= $time != null ? date('H:i', strtotime($time)).' WIB' : '';

                        $html_time = '<span class="d-none">'.$if_time1.'</span>'.$if_time2.'<br><small class="text-muted">'.$if_time3.'</small>';

                        return $html_time;
                    })
                    ->editColumn('status', function($query){

                        if($query->status == 1)
                            return '<span class="badge bg-success">Direkomendasikan</span>';
                        elseif($query->status == 0)
                            return '<span class="badge bg-danger">Tidak Direkomendasikan</span>';
                        elseif($query->status == 2)
                            return '<span class="badge bg-info">Dipertimbangkan</span>';
                        elseif($query->status == 99)
                            return '<span class="badge bg-warning">Belum Dites</span>';
                        
                    })
                    ->addColumn('options', function($query){
                        $html_comvert = '<a href="#" class="btn btn-sm btn-success btn-convert" data-id="'.$query->id.'" data-bs-toggle="tooltip" title="Lantik Menjadi Karyawan"><i class="bi-check-circle"></i></a>';
                        $html_set = '<a href="#" class="btn btn-sm btn-warning btn-set-test" data-id="'.$query->id.'" data-bs-toggle="tooltip" title="Edit"><i class="bi-pencil"></i></a>';
                        $html_delete = '<a href="#" class="btn btn-sm btn-danger btn-delete" data-id="'.$query->id.'" data-bs-toggle="tooltip" title="Hapus"><i class="bi-trash"></i></a>';
                        
                        if($query->status == 1 && $query->user->role_id != 3)
                            return '<div class="btn-group">'.$html_comvert.''.$html_set.''.$html_delete.'</div>';
                       
                        elseif($query->user->role_id != 3)
                            return '<div class="btn-group">'.$html_set.''.$html_delete.'</div>';
                       
                        else
                            return '<div class="btn-group">'.$html_delete.'</div>';

                    })
                    ->addColumn('position_name', function($query){
                        $if_position = $query->vacancy->position ? $query->vacancy->position->name : '-';
                        return $if_position;
                        
                    })
                    ->rawColumns(['position_name','checkbox', 'user.name', 'position_name','test_time','status', 'options'])
                    ->make(true);
    }
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

        // Get companies
        $companies = Company::orderBy('name','asc')->get();

    	// View
        return view('admin/selection/index', [
            // 'selections' => $selections,
            'companies' => $companies
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	// Get the company
    	if(Auth::user()->role->is_global === 1) {
            $applicant = User::find($request->user_id);
            if($applicant) $company = $applicant->attribute->company;
        }
    	elseif(Auth::user()->role->is_global === 0) {
            $company = Company::find(Auth::user()->attribute->company_id);
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'time' => 'required',
            'place' => 'required',
        ], validationMessages());
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Check selection
            $check = Selection::where('user_id','=',$request->user_id)->where('vacancy_id','=',$request->vacancy_id)->first();

            // If check is exist
            if($check) {
                return redirect()->route('admin.applicant.detail', ['id' => $request->user_id])->with(['message' => 'Sudah masuk ke data seleksi.']);
            }

            // Save the selection
            $selection = new Selection;
            $selection->company_id = $company->id;
            $selection->user_id = $request->user_id;
            $selection->vacancy_id = $request->vacancy_id;
            $selection->status = 99;
            $selection->test_time = DateTimeExt::change($request->date)." ".$request->time.":00";
            $selection->test_place = $request->place;
            $selection->save();

            // Redirect
            return redirect()->route('admin.selection.index')->with(['message' => 'Berhasil menambah data.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {        
        if($request->ajax()) {
            // Get the selection
            $selection = Selection::find($request->id);
            $selection->test_date = date('d/m/Y', strtotime($selection->test_time));

            return response()->json($selection, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'result' => 'required',
            'date' => $request->result == 99 ? 'required' : '',
            'time' => $request->result == 99 ? 'required' : '',
            'place' => $request->result == 99 ? 'required' : '',
        ], validationMessages());
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update the selection
            $selection = Selection::find($request->id);
            $selection->test_time = $request->result == 99 ? DateTimeExt::change($request->date)." ".$request->time.":00" : $selection->test_time;
            $selection->test_place = $request->result == 99 ? $request->place : $selection->test_place;
            $selection->status = $request->result;
            $selection->save();

            // Redirect
            return redirect()->route('admin.selection.index')->with(['message' => 'Berhasil mengupdate data.']);
        }
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
        
        // Get the selection
        $selection = Selection::find($request->id);

        // Delete the selection
        $selection->delete();

        // Redirect
        return redirect()->route('admin.selection.index')->with(['message' => 'Berhasil menghapus data.']);
    }

    /**
     * Convert the applicant to employee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function convert(Request $request)
    {
        // Check the access
        has_access(method(__METHOD__), Auth::user()->role_id);
        
        // Get the selection
        $selection = Selection::has('user')->find($request->id);

        // Update the user role
        $selection->user->role_id = role('employee');
        $selection->user->save();

        // Redirect
        return redirect()->route('admin.selection.index')->with(['message' => 'Berhasil mengonversi data.']);
    }
}
