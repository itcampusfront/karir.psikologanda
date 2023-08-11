<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Company;
use App\Models\Vacancy;
use App\Models\Position;
use App\Models\Selection;
use Illuminate\Http\Request;
use App\Models\UserAttribute;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class VacancyController extends \App\Http\Controllers\Controller
{


    public function getData(Request $request)
    {
        $company_selected = $request->company_select;

        if(Auth::user()->role->is_global === 1) {
            $vacn = Vacancy::with(['company','position'])
                            ->has('company')
                            ->has('position')
                            ->orderBy('status','desc')
                            ->orderBy('created_at','desc')
                            ->get();
            
            if($company_selected){
                $vacn = $vacn->where('company_id', $company_selected);
            }
        }  
        
        elseif(Auth::user()->role->is_global === 0) {
            $user_id = Auth::id();
            $get_company = UserAttribute::select('company_id')
                            ->where('user_id','=',$user_id)
                            ->first();
                         
            $vacn = Vacancy::with(['company','position'])
                            ->whereHas('company', function($query) use ($get_company){
                                return $query->where('company_id','=',$get_company->company_id);
                            })
                            ->has('position')
                            ->orderBy('status','desc')
                            ->orderBy('created_at','desc')
                            ->get();
            }
           

        // datatable
            $datatable = DataTables::of($vacn)

            // -addColumn('cek', function($vacab){
            //     return $vacab->company_id;
            // })

            ->addColumn('pos_name', function($vacab){
                return $vacab->position->name;
            })
            ->addColumn('create', function($vacab) 
            {
                $create_html = '<span class="d-none">'. $vacab->created_at .'</span>'
                .date('d/m/Y', strtotime($vacab->created_at)).'
                <br>
                <small class="text-muted">'.date('H:i', strtotime($vacab->created_at)).' WIB</span>';

                return $create_html;
            })

            ->editColumn('status', function ($vacab){
                $cek_status_true = $vacab->status == 1 ? 'selected' : '';
                $cek_status_false = $vacab->status == 0 ? 'selected' : '';

                $create_status_html = '<span class="d-none">'.$vacab->status.'</span>
                <select data-id="'.$vacab->id.'" data-value="'.$vacab->status.'" class="form-select form-select-sm status">
                    <option value="1"'.$cek_status_true.'>Aktif</option>
                    <option value="0"'.$cek_status_false.'>Tidak Aktif</option>
                </select>';

                return $create_status_html;
            })

            ->addColumn('pelamar', function($vacab){
                // jumlah pelamar

                $array = UserAttribute::has('user')
                                        ->selectRaw('COUNT(user_id) as followers')
                                        ->where('user_attributes.vacancy_id','=',$vacab->id)
                                        ->get();

                return $array[0]->followers;
            })

            // ->addColumn('pelamar', function($vacab)
            // {
            //     // Set jumlah
            //     $vacancy_id = $vacab->id;
            //     $array = User::selectRaw('user_id')
            //                 ->whereHas('attribute', function (Builder $query) use ($vacancy_id) {
            //         return $query->where('vacancy_id','=',$vacancy_id);
            //     })->count();

            //     // $array = User::with(['attribute' => function ($query) {
            //     //     $query->where('vacancy_id' ,1);
            //     // }])->count();

            //     // $array = UserAttribute::select('vacancy_id')
            //     //         ->where('vacancy_id',$vacancy_id)->count();
                
                
            //     return $array; 
            // })

            ->addColumn('name_link', function($vacab){
                $link = '<a href="'.route('admin.vacancy.applicant', ['id' => $vacab->id]).'">'.$vacab->name.'</a>';
                return $link;
            })

            ->addColumn('company_name', function($vacab){
                return $vacab->company->name;
            })

            ->addColumn('action', function($vacab){
                
                $action_button = '<div class="btn-group">
                                        <a href="#" class="btn btn-sm btn-info btn-url" data-id="'.$vacab->id.'" data-url="'. $vacab->code .'" data-bs-toggle="tooltip" title="Lihat URL"><i class="bi-link"></i></a>
                                        <a href="'.route('admin.vacancy.edit', ['id' => $vacab->id]).'" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit"><i class="bi-pencil"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="'.$vacab->id.'" data-bs-toggle="tooltip" title="Hapus"><i class="bi-trash"></i></a>
                                    </div>';
                return $action_button;
            })

            ->rawColumns(['create','status','action','name_link'])
            ->make(true);
        
        return $datatable;

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


        // elseif(Auth::user()->role->is_global === 0) {
        //     $company = Company::find(Auth::user()->attribute->company_id);
        //     $vacancies = $company ? $company->vacancies()->orderBy('status','desc')->orderBy('created_at','desc')->get() : [];
        // }
        
    
        // Get companies
        $companies = Company::orderBy('name','asc')->get();

        // View
        return view('admin/vacancy/index', [
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

        // Get positions
        if(Auth::user()->role->is_global === 1) {
            $positions = Position::has('company')->orderBy('company_id','asc')->orderBy('name','asc')->get();
        }
        elseif(Auth::user()->role->is_global === 0) {
            $company = Company::find(Auth::user()->attribute->company_id);
            $positions = $company ? $company->positions()->orderBy('name','asc')->get() : [];
        }

        // View
        return view('admin/vacancy/create', [
            'positions' => $positions
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
    	// Get data company
    	if(Auth::user()->role_id == role('hrd')) {
            $company = Company::find(Auth::user()->attribute->company_id);
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'position' => 'required',
            'status' => 'required',
        ], validationMessages());
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Get the file
            $file = $request->file('file');
            $file_name = $file != null ? date('Y-m-d-H-i-s').'.'.$file->getClientOriginalExtension() : '';
    
            // Move file
            if($file != null)
                $file->move('assets/images/lowongan', $file_name);

            // Get the position
            $position = Position::find($request->position);

            // Save the vacancy
            $vacancy = new Vacancy;
            $vacancy->company_id = $position ? $position->company_id : 0;
            $vacancy->position_id = $request->position;
            $vacancy->name = $request->name;
            $vacancy->description = quill($request->description, 'assets/images/lowongan-content/');
            $vacancy->image = $file_name;
            $vacancy->code = '';
            $vacancy->status = $request->status;
            $vacancy->save();
            $vacancy->code = md5($vacancy->id);
            $vacancy->save();

            // Redirect
            return redirect()->route('admin.vacancy.index')->with(['message' => 'Berhasil menambah data.']);
        }
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

        // Get the vacancy and positions
    	if(Auth::user()->role->is_global === 1) {
            $vacancy = Vacancy::has('company')->has('position')->findOrFail($id);
            $positions = Position::has('company')->where('company_id','=',$vacancy->company_id)->orderBy('name','asc')->get();
        }
        elseif(Auth::user()->role->is_global === 0) {
            $company = Company::find(Auth::user()->attribute->company_id);
            $vacancy = Vacancy::has('position')->where('company_id','=',$company->id)->findOrFail($id);
            $positions = $company ? $company->positions()->orderBy('name','asc')->get() : [];
        }

        // View
        return view('admin/vacancy/edit', [
            'vacancy' => $vacancy,
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
            'position' => 'required',
            'status' => 'required',
        ], validationMessages());
        
        // Check errors
        if($validator->fails()) {
            // Back to form page with validation error messages
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        else {
            // Get the file
            $file = $request->file('file');
            $file_name = $file != null ? date('Y-m-d-H-i-s').'.'.$file->getClientOriginalExtension() : '';
    
            // Move file
            if($file != null)
                $file->move('assets/images/lowongan', $file_name);

            // Update the vacancy
            $vacancy = Vacancy::find($request->id);
            $vacancy->position_id = $request->position;
            $vacancy->name = $request->name;
            $vacancy->description = quill($request->description, 'assets/images/lowongan-content/');
            $vacancy->image = $file_name != '' ? $file_name : $vacancy->image;
            $vacancy->status = $request->status;
            $vacancy->save();

            // Redirect
            return redirect()->route('admin.vacancy.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        
        // Get the vacancy
        $vacancy = Vacancy::find($request->id);

        // Delete the vacancy
        $vacancy->delete();

        // Redirect
        return redirect()->route('admin.vacancy.index')->with(['message' => 'Berhasil menghapus data.']);
    }

    /**
     * Display applicants.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function applicant($id)
    {
        // Get the vacancy and positions
    	if(Auth::user()->role->is_global === 1) {
            $vacancy = Vacancy::with(['position','company'])
                            ->has('company')
                            ->has('position')
                            ->findOrFail($id);
        }
        elseif(Auth::user()->role->is_global === 0) {
            $company = Company::find(Auth::user()->attribute->company_id);
            $vacancy = Vacancy::with(['position','company'])
                                ->has('position')
                                ->where('company_id','=',$company->id)
                                ->findOrFail($id);
        }

        // Get applicants
        $applicants = User::with('attribute')
                        ->whereHas('attribute', function (Builder $query) use ($id) {
                            return $query->where('vacancy_id','=',$id);
                        })
                        ->orderBy('created_at','desc')
                        ->get();
        foreach($applicants as $key=>$applicant) {
            // Get the selection
            $selection = Selection::with(['user','vacancy'])
                                    ->whereHas('user', function($query) use ($applicant){
                                        return $query->where('user_id','=',$applicant->id);
                                    })
                                    ->whereHas('vacancy', function($query) use ($vacancy){
                                        return $query->where('vacancy_id','=',$vacancy->id);
                                    })
                                    ->first();

            if($selection) {
                if($selection->status == 0) {
                    $applicants[$key]->badge_color = 'danger';
                    $applicants[$key]->status = 'Tidak Direkomendasikan';
                }
                elseif($selection->status == 1) {
                    $applicants[$key]->badge_color = 'success';
                    $applicants[$key]->status = 'Direkomendasikan';
                }
                elseif($selection->status == 2) {
                    $applicants[$key]->badge_color = 'info';
                    $applicants[$key]->status = 'Dipertimbangkan';
                }
                elseif($selection->status == 99) {
                    $applicants[$key]->badge_color = 'warning';
                    $applicants[$key]->status = 'Belum Dites';
                }
            }
            else {
                $applicants[$key]->badge_color = 'secondary';
                $applicants[$key]->status = 'Belum Diseleksi';
            }

            // $applicants[$key]->isEmployee = $applicant->role_id == role('employee') ? true : false;
        }

        // View
        return view('admin/vacancy/applicant', [
            'vacancy' => $vacancy,
            'applicants' => $applicants,
        ]);
    }

    /**
     * Update status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        // Update status
        $vacancy = Vacancy::find($request->id);
        $vacancy->status = $request->status;
        if($vacancy->save()){
            echo "Berhasil mengupdate status!";
        }
    }

    /**
     * Visit.
     *
     * @param  string  $url
     * @return \Illuminate\Http\Response
     */
    public function visit($url)
    {
        // Get the vacancy
        $vacancy = Vacancy::where('code','=',$url)->where('status','=',1)->firstOrFail();

        // Redirect
        return redirect('/lowongan/'.$url.'/daftar/step-1')->with(['posisi' => $vacancy->position_id]);
    }
}