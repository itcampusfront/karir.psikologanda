@extends('layouts/admin/main')

@section('title', 'Kelola Hasil Tes '.role((int)Request::query('role')))

@section('content')
<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Kelola Hasil Tes {{ role((int)Request::query('role')) }}</h1>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
            <div class="card-header d-sm-flex justify-content-end align-items-center">
                <div class="mb-sm-0 mb-2">
                    <select id="test" name="test" class="form-select form-select-sm">
                        <option value="0">Semua Tes</option>
                        @foreach($tests as $test)
                        <option value="{{ $test->id }}" {{ Request::query('test') == $test->id ? 'selected' : '' }}>{{ $test->name }}</option>
                        @endforeach
                    </select>
                </div>
                @if(Auth::user()->role->is_global === 1)
                    <div class="ms-sm-2 ms-0">
                        <select id="company" name="company" class="form-select form-select-sm">
                            <option value="0">Semua Perusahaan</option>
                            @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ Request::query('company') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
            <hr class="my-0">
            <div class="card-body">
                @if(Session::get('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="alert-message">{{ Session::get('message') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered" id="datatable">
                        <thead class="bg-light">
                            <tr>
                                <th width="30"><input type="checkbox" class="form-check-input checkbox-all"></th>
                                <th>Identitas</th>
                                {{-- <th width="100">Jabatan</th> --}}
                                <th width="80">Waktu</th>
                                <th width="100">Tes</th>
                                <th width="200">Perusahaan</th>
                                <th width="60">Opsi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
		</div>
	</div>
</div>

<form class="form-delete d-none" method="post" action="{{ route('admin.result.delete') }}">
    @csrf
    <input type="hidden" name="id">
    <input type="hidden" name="role" value="{{ Request::query('role') }}">
</form>

@endsection

@section('js')

<script type="text/javascript">
   //Datatable
    $(document).ready(function(){
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 25,
            ajax: {
                'url' : '{{ route('admin.result.index', ['role' => Request::query('role') ]) }}',
                'data' : function(d){
                    d.company_select = $('#company').val();
                    d.test_select = $('#test').val();
                }

            },
            order: [2,'desc'],
            columns: [
                {data: 'checkbox', name: 'checkbox', className: 'text-center', orderable: false},
                {data: 'user.name', name: 'user.name'},
                // {data: 'position.name', name: 'position.name', orderable: false},
                {data: 'created_at', name: 'created_at'},
                {data: 'test.name', name: 'test.name', visible: {{ Request::query('test') == null ? 'true' : 'false' }}},
                {data: 'company.name', name: 'company.name', visible: {{ Auth::user()->role->is_global === 1 && Request::query('company') == null ? 'true' : 'false' }}},
                {data: 'options', name: 'options', className: 'text-center', orderable: false},
            ]
        });
        
        $('#company').change(function(){
            reloadTable('#datatable');
        });

        $('#test').change(function(){
            reloadTable('#datatable');
        });
    })
    
    function reloadTable(idtable){
        var table = $(idtable).DataTable();
        table.cleanData;
        table.ajax.reload();
    }  

    // Button Delete
    Spandiv.ButtonDelete(".btn-delete", ".form-delete");

</script>

@endsection
