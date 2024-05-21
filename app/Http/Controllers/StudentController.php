<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\User;
use App\Models\Office;
use App\Models\Company;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\UserAttribute;
use App\Exports\StudentExport;
use App\Imports\StudentsImport;
use Ajifatur\Helpers\DateTimeExt;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class StudentController extends \App\Http\Controllers\Controller
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
            // Get student
            if(Auth::user()->role->is_global === 1) {
                $company_selected = $request->company_select;

                if($company_selected) {
                    // $students = User::whereHas('attribute', function (Builder $query) use ($company) {
                    //     return $query->has('company')->where('company_id','=',$company->id);
                    // })->where('role_id','=',role('student'))->get();

                    $students = UserAttribute::with(['user', 'company', 'position'])   
                                            ->whereHas('user', function($query){
                                                return $query->where('role_id','=',role('student'));
                                            })
                                            ->whereHas('company', function($query2) use($company_selected){
                                                return $query2->where('company_id','=',$company_selected);
                                            });
                }
                else {
                    // $students = User::whereHas('attribute', function (Builder $query) {
                    //     return $query->has('company');
                    // })->where('role_id','=',role('student'))->get();

                    $students = UserAttribute::with(['user', 'company', 'position'])   
                                    ->whereHas('user', function($query){
                                        return $query->where('role_id','=',role('student'));
                                    })
                                    ->whereHas('company');
                }
            }
            elseif(Auth::user()->role->is_global === 0) {
                // $company = Company::find(Auth::user()->attribute->company_id);
                //get user id yang login
                $user_id = Auth::id();

                // $students = User::whereHas('attribute', function (Builder $query) use ($company) {
                //     return $query->has('company')->where('company_id','=',$company->id);
                // })->where('role_id','=',role('student'))->get();

                $students = UserAttribute::with(['user', 'company', 'position'])   
                                ->whereHas('user', function($query){
                                    return $query->where('role_id','=',role('student'));
                                })
                                ->whereHas('company', function($query) use ($user_id){
                                    return $query->where('user_id','=',$user_id);
                                });
            }


            // Return
            return DataTables::of($students)
                ->addColumn('checkbox', function($query){
                    $check = '<input type="checkbox" class="form-check-input checkbox1" value="'.$query->user->id.'">';
                    return $check;
                })
                ->editColumn('user.username', function($query){
                    return $query->user->username;
                })
                ->editColumn('position.name', function($query){
                    if($query->position != null){
                        return $query->position->name;
                    }
                    else{
                        return '-';
                    }
                })
                ->editColumn('company.name', function($query){
                    return $query->company->name;
                })
                ->editColumn('user.name', function($query){
                    $target_id = $query->user->id;
                    $route_detail = route('admin.student.detail', ['id' => $target_id]);


                    $html_name = '<span class="d-none">'. $query->user->name .'</span>
                    <a href="'.$route_detail.'">'. ucwords($query->user->name).'</a>
                    <br>
                    <small class="text-muted"><i class="bi-envelope me-2"></i>'.$query->user->email.'</small>
                    <br>
                    <small class="text-muted"><i class="bi-phone me-2"></i>'.$query->phone_number.'</small>';

                    return $html_name;
                })
                // ->editColumn('name', '
                //     <span class="d-none">{{ $name }}</span>
                //     <a href="{{ route(\'admin.student.detail\', [\'id\' => $id]) }}">{{ ucwords($name) }}</a>
                //     <br>
                //     <small class="text-muted"><i class="bi-envelope me-2"></i>{{ $email }}</small>
                //     <br>
                //     <small class="text-muted"><i class="bi-phone me-2"></i>{{ $phone_number }}</small>
                // ')
                // ->editColumn('status', '
                //     <span class="badge {{ $status == 1 ? "bg-success" : "bg-danger" }}">{{ status($status) }}</span>
                // ')
                ->editColumn('user.status', function($query){
                    $if_status = $query->user->status == 1 ? 'bg-success' : 'bg-danger';
                    $status = '<span class="badge ' .$if_status. '">'. status($query->user->status) .'</span>';

                    return $status;
                })
                // ->addColumn('options', '
                //     <div class="btn-group">
                //         <a href="{{ route(\'admin.student.detail\', [\'id\' => $id]) }}" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Lihat Detail"><i class="bi-eye"></i></a>
                //         <a href="{{ route(\'admin.student.edit\', [\'id\' => $id]) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit"><i class="bi-pencil"></i></a>
                //         <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $id }}" data-bs-toggle="tooltip" title="Hapus"><i class="bi-trash"></i></a>
                //     </div>
                // ')
                ->addColumn('options', function($query){
                    $target_id = $query->user->id;
                    $route_detail = route('admin.student.detail', ['id' => $target_id]);
                    $route_edit = route('admin.student.edit', ['id' => $target_id ]);
                     

                    $option_html = '
                    <div class="btn-group">
                        <a href="'.$route_detail.'" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Lihat Detail"><i class="bi-eye"></i></a>
                        <a href="'.$route_edit.'" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit"><i class="bi-pencil"></i></a>
                        <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="'.$target_id.'" data-bs-toggle="tooltip" title="Hapus"><i class="bi-trash"></i></a>
                    </div>
                    ';

                    return $option_html;
                })
                ->editColumn('user.created_at',function($query){
                    $cek_if = $query->user->created_at != null ? $query->user->created_at : "";
                    $cek_if_2 = $query->user->created_at != null ? date("d/m/Y", strtotime($query->user->created_at)) : "-";

                    $html_date = '
                    <span class="d-none">'.$cek_if.'</span>
                    '. $cek_if_2 .'
                    <br>
                    <small class="text-muted">'.date("H:i", strtotime($query->user->created_at))." WIB" .'</small>
                    ';

                    return $html_date;
                })
                // ->addColumn('datetime', '
                //     <span class="d-none">{{ $created_at != null ? $created_at : "" }}</span>
                //     {{ $created_at != null ? date("d/m/Y", strtotime($created_at)) : "-" }}
                //     <br>
                //     <small class="text-muted">{{ date("H:i", strtotime($created_at))." WIB" }}</small>
                // ')
                ->rawColumns(['checkbox','user.username', 'user.name','user.status', 'user.created_at', 'options'])
                ->make(true);
        }

        // Get companies
        $companies = Company::orderBy('name','asc')->get();

        // dd($companies);

        // View
        return view('admin/student/index', [
            'companies' => $companies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check the access
        has_access(method(__METHOD__), Auth::user()->role_id);

        // Get companies
        $companies = Company::orderBy('name','asc')->get();

        // Get offices and positions
        if(Auth::user()->role->is_global === 1) {
            $offices = [];
            $positions = Position::orderBy('name','asc')->get();
        }
        elseif(Auth::user()->role->is_global === 0) {
            $company = Company::find(Auth::user()->attribute->company_id);
            $offices = $company ? $company->offices()->orderBy('is_main','desc')->orderBy('name','asc')->get() : [];
            $positions = $company ? $company->positions()->has('role')->orderBy('name','asc')->get() : [];
        }

        // View
        return view('admin/student/create', [
            'companies' => $companies,
            'positions' => $positions,
            'offices' => $offices,
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
            $company = Company::find($request->company);
        }
    	elseif(Auth::user()->role->is_global === 0) {
            $company = Company::find(Auth::user()->attribute->company_id);
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'birthdate' => 'required',
            'gender' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|numeric',
            'status' => 'required',
            'company' => Auth::user()->role->is_global === 1 ? 'required' : '',
            'office' => Auth::user()->role->is_global === 0 ? 'required' : '',
            'position' => Auth::user()->role->is_global === 0 ? 'required' : '',
        ], validationMessages());
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Generate username
            $data_user = User::whereHas('attribute', function (Builder $query) use ($company) {
                return $query->has('company')->where('company_id','=',$company->id);
            })->where('username','like',$company->code.'%')->latest('username')->first();
            if(!$data_user)
                $username = generate_username(null, $company->code);
            else
                $username = generate_username($data_user->username, $company->code);

            // Save the user
            $user = new User;
            $user->role_id = role('student');
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $username;
            $user->password = bcrypt($username);
            $user->access_token = null;
            $user->avatar = '';
            $user->status = $request->status;
            $user->last_visit = null;
            $user->save();

            // Save the user attributes
            $user_attribute = new UserAttribute;
            $user_attribute->user_id = $user->id;
            $user_attribute->company_id = $company->id;
            $user_attribute->office_id = Auth::user()->role->is_global === 0 ? $request->office : 0;
            $user_attribute->position_id = Auth::user()->role->is_global === 0 ? $request->position : 0;
            $user_attribute->vacancy_id = 0;
            $user_attribute->birthdate = DateTimeExt::change($request->birthdate);
            $user_attribute->birthplace = '';
            $user_attribute->gender = $request->gender;
            $user_attribute->country_code = 'ID';
            $user_attribute->dial_code = '+62';
            $user_attribute->phone_number = $request->phone_number;
            $user_attribute->address = $request->address != '' ? $request->address : '';
            $user_attribute->identity_number = $request->identity_number != '' ? $request->identity_number : '';
            $user_attribute->religion = 0;
            $user_attribute->relationship = 0;
            $user_attribute->latest_education = $request->latest_education != '' ? $request->latest_education : '';
            $user_attribute->job_experience = $request->job_experience != '' ? $request->job_experience : '';
            $user_attribute->inspection = $request->inspection != '' ? $request->inspection : '';            
			$user_attribute->start_date = $request->start_date != '' ? DateTimeExt::change($request->start_date) : null;
            $user_attribute->end_date = null;
            $user_attribute->save();

            // Redirect
            return redirect()->route('admin.student.index')->with(['message' => 'Berhasil menambah data.']);
        }
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

        // Get the student
    	if(Auth::user()->role->is_global === 1) {
            $student = User::whereHas('attribute', function (Builder $query) {
                return $query->has('company');
            })->where('role_id','=',role('student'))->findOrFail($id);
        }
    	if(Auth::user()->role->is_global === 0) {
            $company = Company::find(Auth::user()->attribute->company_id);
            $student = User::whereHas('attribute', function (Builder $query) use ($company) {
                return $query->has('company')->where('company_id','=',$company->id);
            })->where('role_id','=',role('student'))->findOrFail($id);
        }

        // View
        return view('admin/student/detail', [
            'student' => $student
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check the access
        has_access(method(__METHOD__), Auth::user()->role_id);

        // Get the student
    	if(Auth::user()->role->is_global === 1) {
            $student = User::whereHas('attribute', function (Builder $query) {
                return $query->has('company');
            })->where('role_id','=',role('student'))->findOrFail($id);
        }
    	if(Auth::user()->role->is_global === 0) {
            $company = Company::find(Auth::user()->attribute->company_id);
            $student = User::whereHas('attribute', function (Builder $query) use ($company) {
                return $query->has('company')->where('company_id','=',$company->id);
            })->where('role_id','=',role('student'))->findOrFail($id);
        }

        // Get offices and positions
        $offices = Office::has('company')->where('company_id','=',$student->attribute->company_id)->orderBy('is_main','desc')->orderBy('name','asc')->get();
        $positions = Position::has('company')->has('role')->where('company_id','=',$student->attribute->company_id)->orderBy('name','asc')->get();

        // View
        return view('admin/student/edit', [
            'student' => $student,
            'offices' => $offices,
            'positions' => $positions
        ]);
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
            'name' => 'required',
            'birthdate' => 'required',
            'gender' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|numeric',
            'status' => 'required',
            'office' => 'required',
            'position' => 'required',
            'username' => 'required'
        ], validationMessages());
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Update the user
            $user = User::find($request->id);
            $password = $request->password == null ? $user->password : bcrypt($request->password);

            $user->password = $password;
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->status = $request->status;
            $user->save();

            // Update the user attribute
            $user->attribute->office_id = $request->office;
            $user->attribute->position_id = $request->position;
            $user->attribute->birthdate = DateTimeExt::change($request->birthdate);
            $user->attribute->gender = $request->gender;
            $user->attribute->phone_number = $request->phone_number;
            $user->attribute->address = $request->address != '' ? $request->address : '';
            $user->attribute->identity_number = $request->identity_number != '' ? $request->identity_number : '';
            $user->attribute->latest_education = $request->latest_education != '' ? $request->latest_education : '';
            $user->attribute->job_experience = $request->job_experience != '' ? $request->job_experience : '';
            $user->attribute->inspection = $request->inspection != '' ? $request->inspection : '';
			$user->attribute->start_date = $request->start_date != '' ? DateTimeExt::change($request->start_date) : null;
            $user->attribute->save();

            // Redirect
            return redirect()->route('admin.student.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        
        dd($request->all());

        // Get the student
        $student = User::find($request->id);

        // Delete the student
        $student->delete();

        // Redirect
        return redirect()->route('admin.student.index')->with(['message' => 'Berhasil menghapus data.']);
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->id; 
        $delete_record = explode(',', $ids[0]);

        $student = User::whereIn('id',$delete_record)->delete();
        
        return redirect()->route('admin.student.index')->with(['message' => 'Berhasil menghapus data.']);

    }

    /**
     * Export to Excel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        // Check the access
        has_access(method(__METHOD__), Auth::user()->role_id);

        // Set memory limit
        ini_set("memory_limit", "-1");

        // Get students
        if(Auth::user()->role->is_global === 1) {
            $company = Company::find($request->comp_id);
            if($company) {
                // $students = User::whereHas('attribute', function (Builder $query) use ($company) {
                //     return $query->has('company')->where('company_id','=',$company->id);
                // })->where('role_id','=',role('student'))->get();

                $students = UserAttribute::with(['user','company','position','office'])
                            ->whereHas('user', function($query){
                                return $query->where('role_id','=',8);
                            })
                            ->whereHas('company',function($query) use($company){
                                return $query->where('id','=',$company->id);
                            })
                            ->get();
            }
            else {
                // $students = User::whereHas('attribute', function (Builder $query) {
                //     return $query->has('company');
                // })->where('role_id','=',role('student'))->get();

                $students = UserAttribute::with(['user','company','position','office'])
                            ->whereHas('user', function($query){
                                return $query->where('role_id','=',8);
                            })
                            ->has('company')
                            ->get();
            }
        }
        elseif(Auth::user()->role->is_global === 0) {
            $company = Company::find(Auth::user()->attribute->company_id);

            // $students = User::whereHas('attribute', function (Builder $query) use ($company) {
            //     return $query->has('company')->where('company_id','=',$company->id);
            // })->where('role_id','=',role('student'))->get();

            $students = UserAttribute::with(['user','company','position','office'])
                        ->whereHas('user', function($query){
                            return $query->where('role_id','=',8);
                        })
                        ->whereHas('company', function($query) use ($company){
                            return $query->where('id','=', $company->id);
                        })
                        ->get();
        }

        // Set filename
        $filename = $company ? 'Data Siswa '.$company->name.' ('.date('Y-m-d-H-i-s').')' : 'Data Semua Siswa ('.date('d-m-Y-H-i-s').')';

        // Return
        return Excel::download(new StudentExport($students), $filename.'.xlsx');
    }
 
    /**
     * Import from Excel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function import(Request $request) 
	{
        // Validation
        $validator = Validator::make($request->all(), [
            'file' => 'required'
        ], validationMessages());
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Ini set
            ini_set('max_execution_time', 600);

            // Get rows from array
            $rows = Excel::toArray(new StudentsImport, $request->file('file'));

           
            // Loop students
            if(count($rows) > 0) {
                foreach($rows[0] as $cells) {
                    if($cells[2] != null){
                        // Set birthdate
                        if(is_int($cells[3])) {
                            $birthdate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($cells[3]);
                            $birthdate = (array)$birthdate;
                            $birthdate = date('d/m/Y', strtotime($birthdate['date']));
                        }
                        else {
                            $birthdate = $cells[3];
                        }

                        // Set start date
                        if(is_int($cells[3])) {
                            $startdate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($cells[9]);
                            $startdate = (array)$startdate;
                            $startdate = date('d/m/Y', strtotime($startdate['date']));
                        }
                        else {
                            $startdate = $cells[9];
                        }

                        // Get the office
                        if($cells[10] != null) {
                            $office = Office::where('company_id','=',$request->company_id)->where('name','=',$cells[10])->first();
                            if(!$office) {
                                $office = new Office;
                                $office->company_id = $request->company_id;
                                $office->name = $cells[10];
                                $office->address = '';
                                $office->phone_number = '';
                                $office->is_main = 0;
                                $office->save();
                            }
                        }

                        // Update the user position
                        if($cells[11] != null) {
                            $position = Position::where('company_id','=',$request->company_id)->where('name','=',$cells[11])->first();
                            if(!$position) {
                                $position = new Position;
                                $position->company_id = $request->company_id;
                                $position->role_id = role('student');
                                $position->name = $cells[11];
                                $position->save();
                            }
                        }

                        // Get the user
                        $user = User::find($cells[0]);

                        if($user) {
                            // Update the user
                            $user->name = $cells[2];
                            $user->email = $cells[5];
                            $user->save();

                            // Update the user attribute
                            if($cells[10] != null) $user->attribute->office_id = $office->id;
                            if($cells[11] != null) $user->attribute->position_id = $position->id;
                            $user->attribute->birthdate = DateTimeExt::change($birthdate);
                            $user->attribute->gender = $cells[4];
                            $user->attribute->phone_number = $cells[6];
                            $user->attribute->address = $cells[7] != null ? $cells[7] : '';
                            $user->attribute->latest_education = $cells[8] != null ? $cells[8] : '';
                            $user->attribute->inspection = $cells[12] != null ? $cells[12] : '';
                            $user->attribute->start_date = $startdate != null ? DateTimeExt::change($startdate) : null;
                            $user->attribute->save();
                        }
                        else {
                            // Generate username
                            $company = Company::find($request->company_id);
                            $data_user = User::whereHas('attribute', function (Builder $query) use ($company) {
                                return $query->has('company')->where('company_id','=',$company->id);
                            })->where('username','like',$company->code.'%')->latest('username')->first();
                            if(!$data_user)
                                $username = generate_username(null, $company->code);
                            else
                                $username = generate_username($data_user->username, $company->code);

                            // Save the user
                            $user = new User;
                            $user->role_id = role('student');
                            $user->name = $cells[2];
                            $user->email = $cells[5];
                            $user->username = $username;
                            $user->password = bcrypt($username);
                            $user->access_token = null;
                            $user->avatar = '';
                            $user->status = 1;
                            $user->last_visit = null;
                            $user->save();

                            // Save the user attributes
                            $user_attribute = new UserAttribute;
                            $user_attribute->user_id = $user->id;
                            $user_attribute->company_id = $company->id;
                            $user_attribute->office_id = Auth::user()->role->is_global === 0 && isset($office) && $cells[10] != null ? $office->id : 0;
                            $user_attribute->position_id = Auth::user()->role->is_global === 0 && isset($position) && $cells[11] != null ? $position->id : 0;
                            $user_attribute->vacancy_id = 0;
                            $user_attribute->birthdate = DateTimeExt::change($birthdate);
                            $user_attribute->birthplace = '';
                            $user_attribute->gender = $cells[4];
                            $user_attribute->country_code = 'ID';
                            $user_attribute->dial_code = '+62';
                            $user_attribute->phone_number = $cells[6];
                            $user_attribute->address = $cells[7] != null ? $cells[7] : '';
                            $user_attribute->identity_number = '';
                            $user_attribute->religion = 0;
                            $user_attribute->relationship = 0;
                            $user_attribute->latest_education = $cells[8] != null ? $cells[8] : '';
                            $user_attribute->inspection = $cells[12] != null ? $cells[12] : '';
                            $user_attribute->job_experience = '';
                            $user_attribute->start_date = $startdate != null ? DateTimeExt::change($startdate) : null;
                            $user_attribute->end_date = null;
                            $user_attribute->save();
                        }
                    }
                    else{
                        return redirect()->route('admin.student.index')->with(['message' => 'Ada data kosong.']);
                    }
                }

            }

            // Redirect
            return redirect()->route('admin.student.index')->with(['message' => 'Berhasil mengimpor data.']);
        }
    }
}
