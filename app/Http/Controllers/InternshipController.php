<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Company;
use App\Models\Vacancy;
use App\Models\Selection;
use App\Models\UserSocmed;
use App\Models\UserGuardian;
use Illuminate\Http\Request;
use App\Models\UserAttribute;
use App\Exports\ApplicantExport;
use Yajra\DataTables\DataTables;
use Ajifatur\Helpers\DateTimeExt;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class InternshipController extends Controller
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

        if ($request->ajax()) {
            // Get internships
            if (Auth::user()->role->is_global === 1) {
                $company_selected = $request->company_select;

                if ($company_selected) {
                    $internships = UserAttribute::with(['user', 'company', 'position'])
                        ->whereHas('user', function ($query) {
                            return $query->where('role_id', '=', role('employee'));
                        })
                        ->whereHas('company', function ($query2) use ($company_selected) {
                            return $query2->where('company_id', '=', $company_selected);
                        });
                } else {
                    $internships = UserAttribute::with(['user', 'company', 'position'])
                        ->whereHas('user', function ($query) {
                            return $query->where('role_id', '=', role('internship'));
                        })
                        ->whereHas('company');
                }
            } elseif (Auth::user()->role->is_global === 0) {
                //get user id yang login
                $user_id = Auth::id();

                $internships = UserAttribute::with(['user', 'company', 'position'])
                    ->whereHas('user', function ($query) {
                        return $query->where('role_id', '=', role('internship'));
                    })
                    ->whereHas('company', function ($query) use ($user_id) {
                        return $query->where('user_id', '=', $user_id);
                    });
            }

            // Return
            return DataTables::of($internships)
                ->addColumn('checkbox', '<input type="checkbox" class="form-check-input checkbox-one">')
                ->editColumn('user.username', function ($query) {
                    return $query->user->username;
                })
                ->editColumn('company.name', function ($query) {
                    return $query->company->name;
                })

                ->editColumn('user.name', function ($query) {
                    $target_id = $query->user->id;
                    $route_detail = route('admin.internship.detail', ['id' => $target_id]);


                    $html_name = '<span class="d-none">' . $query->user->name . '</span>
                    <a href="' . $route_detail . '">' . ucwords($query->user->name) . '</a>
                    <br>
                    <small class="text-muted"><i class="bi-envelope me-2"></i>' . $query->user->email . '</small>
                    <br>
                    <small class="text-muted"><i class="bi-phone me-2"></i>' . $query->phone_number . '</small>';

                    return $html_name;
                })
                ->editColumn('position.name', function ($query) {
                    if ($query->position != null) {
                        return $query->position->name;
                    } else {
                        return '-';
                    }
                })
                ->editColumn('user.status', function ($query) {
                    $if_status = $query->user->status == 1 ? 'bg-success' : 'bg-danger';
                    $status = '<span class="badge ' . $if_status . '">' . status($query->user->status) . '</span>';

                    return $status;
                })
                ->addColumn('options', function ($query) {
                    $target_id = $query->user->id;
                    $route_detail = route('admin.internship.detail', ['id' => $target_id]);
                    $route_edit = route('admin.internship.edit', ['id' => $target_id]);


                    $option_html = '
                    <div class="btn-group">
                        <a href="' . $route_detail . '" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Lihat Detail"><i class="bi-eye"></i></a>
                        <a href="' . $route_edit . '" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit"><i class="bi-pencil"></i></a>
                        <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="' . $target_id . '" data-bs-toggle="tooltip" title="Hapus"><i class="bi-trash"></i></a>
                    </div>
                    ';

                    return $option_html;
                })

                ->editColumn('user.created_at', function ($query) {
                    $cek_if = $query->user->created_at != null ? $query->user->created_at : "";
                    $cek_if_2 = $query->user->created_at != null ? date("d/m/Y", strtotime($query->user->created_at)) : "-";

                    $html_date = '
                    <span class="d-none">' . $cek_if . '</span>
                    ' . $cek_if_2 . '
                    <br>
                    <small class="text-muted">' . date("H:i", strtotime($query->user->created_at)) . " WIB" . '</small>
                    ';

                    return $html_date;
                })
                ->rawColumns(['checkbox', 'user.username', 'user.name', 'user.status', 'user.created_at', 'options'])
                ->make(true);
        }

        // Get companies
        $companies = Company::orderBy('name', 'asc')->get();

        // View
        return view('admin/internship/index', [
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
        $companies = Company::orderBy('name', 'asc')->get();

        // Get vacancies
        // if (Auth::user()->role->is_global === 1) {
        //     $vacancies = [];
        // } elseif (Auth::user()->role->is_global === 0) {
        //     $company = Company::find(Auth::user()->attribute->company_id);
        //     if ($company) {
        //         $vacancies = Vacancy::with('position', 'company')
        //             ->has('position')
        //             ->whereHas('company', function ($query) use ($company) {
        //                 return $query->where('company_id', $company);
        //             })
        //             ->where('status', 1)
        //             ->orderBy('name', 'asc')
        //             ->get();
        //     } else {
        //         $vacancies = [];
        //     }
        //     // $vacancies = $company ? $company->vacancies()->has('position')->where('status','=',1)->orderBy('name','asc')->get() : [];
        // }

        // View
        return view('admin/internship/create', [
            'companies' => $companies,
            // 'vacancies' => $vacancies
        ]);
    }
    public function getVacan(Request $request)
    {
        if(Auth::user()->role->is_global === 1){
            if ($request->ajax()) {
                $company = $request->company;
                if ($company) {
                    $vacancies = Vacancy::with('position', 'company')
                        ->has('position')
                        ->whereHas('company', function ($query) use ($company) {
                            return $query->where('company_id', $company);
                        })
                        ->where('status', 1)
                        ->orderBy('name', 'asc')
                        ->get();
                } else {
                    $vacancies = [];
                }
                return response()->json($vacancies);
            }
        }
        if(Auth::user()->role_id === 2){
            $company_id = Auth::user()->company->id;
            $vacancies = Vacancy::with('position','company')
                        ->has('position')
                        ->whereHas('company', function($query) use ($company_id){
                            return $query->where('company_id', $company_id);
                        })
                        ->where('status',1)
                        ->orderBy('name','asc')
                        ->get();
            
            return response()->json($vacancies);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'vacancy' => 'required',
            'name' => 'required|min:3|max:255',
            'birthdate' => 'required',
            'gender' => 'required',
            'religion' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|numeric',
            'address' => 'required',
            'relationship' => 'required',
        ], validationMessages());

        // Check errors
        if ($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } else {
            // Get the vacancy and company
            $vacancy = Vacancy::has('company')->find($request->vacancy);

            // Generate username
            $data_user = User::whereHas('attribute', function (Builder $query) use ($vacancy) {
                return $query->has('company')->where('company_id', '=', $vacancy->company_id);
            })->where('username', 'like', $vacancy->company->code . '%')->latest('username')->first();
            if (!$data_user)
                $username = generate_username(null, $vacancy->company->code);
            else
                $username = generate_username($data_user->username, $vacancy->company->code);

            // Save the user
            $user = new User;
            $user->role_id = role('internship');
            $user->name = $request->name;
            $user->email = $request->email;
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
            $user_attribute->company_id = $vacancy->company->id;
            $user_attribute->office_id = 0;
            $user_attribute->position_id = $vacancy->position_id;
            $user_attribute->vacancy_id = $vacancy->id;
            $user_attribute->birthdate = DateTimeExt::change($request->birthdate);
            $user_attribute->birthplace = $request->birthplace != '' ? $request->birthplace : '';
            $user_attribute->gender = $request->gender;
            $user_attribute->country_code = 'ID';
            $user_attribute->dial_code = '+62';
            $user_attribute->phone_number = $request->phone_number;
            $user_attribute->address = $request->address;
            $user_attribute->identity_number = $request->identity_number != '' ? $request->identity_number : '';
            $user_attribute->religion = $request->religion;
            $user_attribute->relationship = $request->relationship;
            $user_attribute->latest_education = $request->latest_education != '' ? $request->latest_education : '';
            $user_attribute->job_experience = $request->job_experience != '' ? $request->job_experience : '';
            $user_attribute->inspection = $request->inspection != '' ? $request->inspection : '';
            $user_attribute->start_date = null;
            $user_attribute->end_date = null;
            $user_attribute->save();

            // Redirect
            return redirect()->route('admin.internship.index')->with(['message' => 'Berhasil menambah data.']);
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

        // Get the internship
        if (Auth::user()->role->is_global === 1) {
            $internship = User::whereHas('attribute', function (Builder $query) {
                return $query->has('company')->has('vacancy');
            })->where('role_id', '=', role('internship'))->findOrFail($id);
        } elseif (Auth::user()->role->is_global === 0) {
            $company = Company::find(Auth::user()->attribute->company_id);
            $internship = User::whereHas('attribute', function (Builder $query) use ($company) {
                return $query->has('company')->has('vacancy')->where('company_id', '=', $company->id);
            })->where('role_id', '=', role('internship'))->findOrFail($id);
        }

        // Get attachments
        $photo = $internship->attachments()->where('attachment_id', '=', 1)->first();
        $internship->photo = $photo ? $photo->file : '';
        $certificate = $internship->attachments()->where('attachment_id', '=', 2)->first();
        $internship->certificate = $certificate ? $certificate->file : '';

        // Get the selection
        $selection = Selection::has('user')->has('company')->has('vacancy')->where('user_id', '=', $internship->id)->where('vacancy_id', '=', $internship->attribute->vacancy_id)->first();

        // View
        return view('admin/internship/detail', [
            'internship' => $internship,
            'selection' => $selection
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

        // Get the internship
        if (Auth::user()->role->is_global === 1) {
            $internship = User::whereHas('attribute', function (Builder $query) {
                return $query->has('company');
            })->where('role_id', '=', role('internship'))->findOrFail($id);
        } elseif (Auth::user()->role->is_global === 0) {
            $company = Company::find(Auth::user()->attribute->company_id);
            $internship = User::whereHas('attribute', function (Builder $query) use ($company) {
                return $query->has('company')->where('company_id', '=', $company->id);
            })->where('role_id', '=', role('internship'))->findOrFail($id);
        }

        // View
        return view('admin/internship/edit', [
            'internship' => $internship
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
            'name' => 'required|min:3|max:255',
            'birthplace' => 'required',
            'birthdate' => 'required',
            'gender' => 'required',
            'religion' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|numeric',
            'address' => 'required',
            'relationship' => 'required',
            'socmed' => 'required',
            'guardian_name' => 'required',
            'guardian_address' => 'required',
            'guardian_phone_number' => 'required|numeric',
            'guardian_occupation' => 'required',
        ], validationMessages());

        // Check errors
        if ($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } else {
            // Update the user
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            // Update the user attribute
            $user->attribute->birthdate = DateTimeExt::change($request->birthdate);
            $user->attribute->gender = $request->gender;
            $user->attribute->phone_number = $request->phone_number;
            $user->attribute->address = $request->address;
            $user->attribute->religion = $request->religion;
            $user->attribute->relationship = $request->relationship;
            $user->attribute->identity_number = $request->identity_number != '' ? $request->identity_number : '';
            $user->attribute->latest_education = $request->latest_education != '' ? $request->latest_education : '';
            $user->attribute->job_experience = $request->job_experience != '' ? $request->job_experience : '';
            $user->attribute->inspection = $request->inspection != '' ? $request->inspection : '';
            $user->attribute->save();

            // Update or create the user socmed
            $user_socmed = UserSocmed::where('user_id', '=', $user->id)->first();
            if (!$user_socmed)
                $user_socmed = new UserSocmed;
            $user_socmed->user_id = $user->id;
            $user_socmed->platform = $request->platform;
            $user_socmed->account = $request->socmed;
            $user_socmed->save();

            // Update or create the user guardian
            $user_guardian = UserGuardian::where('user_id', '=', $user->id)->first();
            if (!$user_guardian)
                $user_guardian = new UserGuardian;
            $user_guardian->user_id = $user->id;
            $user_guardian->name = $request->guardian_name;
            $user_guardian->address = $request->guardian_address;
            $user_guardian->country_code = 'ID';
            $user_guardian->dial_code = '+62';
            $user_guardian->phone_number = $request->guardian_phone_number;
            $user_guardian->occupation = $request->guardian_occupation;
            $user_guardian->save();

            // Redirect
            return redirect()->route('admin.internship.index')->with(['message' => 'Berhasil mengupdate data.']);
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

        // Get the internship
        $internship = User::find($request->id);

        // Delete the internship
        $internship->delete();

        // Get the selection
        $selection = Selection::where('user_id', '=', $request->id)->first();

        // Delete the selection
        if ($selection)
            $selection->delete();

        // Redirect
        return redirect()->route('admin.internship.index')->with(['message' => 'Berhasil menghapus data.']);
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

        // Get internships
        if (Auth::user()->role->is_global === 1) {
            $company = Company::find($request->query('company'));
            if ($company) {
                $internships = User::whereHas('attribute', function (Builder $query) use ($company) {
                    return $query->has('company')->where('company_id', '=', $company->id);
                })->where('role_id', '=', role('internship'))->get();
            } else {
                $internships = User::whereHas('attribute', function (Builder $query) {
                    return $query->has('company');
                })->where('role_id', '=', role('internship'))->get();
            }
        } elseif (Auth::user()->role->is_global === 0) {
            $company = Company::find(Auth::user()->attribute->company_id);
            $internships = User::whereHas('attribute', function (Builder $query) use ($company) {
                return $query->has('company')->where('company_id', '=', $company->id);
            })->where('role_id', '=', role('internship'))->get();
        }

        // Set filename
        $filename = $company ? 'Data Magang ' . $company->name . ' (' . date('Y-m-d-H-i-s') . ')' : 'Data Semua Magang (' . date('d-m-Y-H-i-s') . ')';

        // Return
        return Excel::download(new ApplicantExport($internships), $filename . '.xlsx');

        if (Auth::user()->role->is_global === 1) {
            // Get the HRD
            $hrd = HRD::find($request->query('hrd'));

            // Get internships
            $internships = $hrd ? Pelamar::join('agama', 'pelamar.agama', '=', 'agama.id_agama')->where('id_hrd', '=', $hrd->id_hrd)->get() : Pelamar::join('agama', 'pelamar.agama', '=', 'agama.id_agama')->get();

            // File name
            $filename = $hrd ? 'Data Magang ' . $hrd->perusahaan . ' (' . date('Y-m-d-H-i-s') . ')' : 'Data Semua Magang (' . date('d-m-Y-H-i-s') . ')';

            return Excel::download(new PelamarExport($internships), $filename . '.xlsx');
        } elseif (Auth::user()->role->is_global === 0) {
            // Get the HRD
            $hrd = HRD::where('id_user', '=', Auth::user()->id)->first();

            // Get internships
            $internships = Pelamar::join('agama', 'pelamar.agama', '=', 'agama.id_agama')->where('id_hrd', '=', $hrd->id_hrd)->get();

            // File name
            $filename = 'Data Magang ' . $hrd->perusahaan . ' (' . date('Y-m-d-H-i-s') . ')';

            return Excel::download(new PelamarExport($internships), $filename . '.xlsx');
        }
    }
}