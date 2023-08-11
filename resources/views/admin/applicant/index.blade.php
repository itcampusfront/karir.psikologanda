@extends('layouts/admin/main')

@section('title', 'Kelola Pelamar')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Kelola Pelamar</h1>
    <div class="btn-group">
        <a href="{{ route('admin.applicant.create') }}" class="btn btn-sm btn-primary"><i class="bi-plus me-1"></i> Tambah Pelamar</a>
        <a href="{{ route('admin.applicant.export') }}" class="btn btn-sm btn-success"><i class="bi-file-excel me-1"></i> Ekspor Data</a>
    </div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
            @if(Auth::user()->role->is_global === 1)
            <div class="card-header d-sm-flex justify-content-end align-items-center">
                <div></div>
                <div class="ms-sm-2 ms-0">
                    <select id="company" name="company" class="form-select form-select-sm">
                        <option value="0">Semua Perusahaan</option>
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ Request::query('company') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <hr class="my-0">
            @endif
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
                                <th width="100">Username</th>
                                <th width="100">Jabatan</th>
                                <th width="80">Status</th>
                                <th width="80">Waktu</th>
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

<form class="form-delete d-none" method="post" action="{{ route('admin.applicant.delete') }}">
    @csrf
    <input type="hidden" name="id">
</form>

@endsection

@section('js')

<script type="text/javascript">
    // DataTable
    $(document).ready(function(){
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'url' : '{{ route('admin.applicant.index') }}',
                'data' : function(d){
                    d.company_select = $('#company').val();
                }

            },
            order: [5,'desc'],
            columns: [
                {data: 'checkbox', name: 'checkbox', className: 'text-center', orderable: false},
                {data: 'user.name', name: 'user.name'},
                {data: 'user.username', name: 'user.username'},
                {data: 'position.name', name: 'position.name', orderable: false},
                {data: 'user.status', name: 'user.status'},
                {data: 'user.created_at', name: 'user.created_at'},
                {data: 'company.name', name: 'company.name',orderable: false, visible: {{ Auth::user()->role->is_global === 1 && Request::query('company') == null ? 'true' : 'false' }}},
                {data: 'options', name: 'options', className: 'text-center', orderable: false},
            ]
        });

        $('#company').change(function(){
            reloadTable('#datatable');
        });
    })

    // url: Spandiv.URL("{{ route('admin.applicant.index') }}", {company: "{{ Request::query('company') }}"}),


    function reloadTable(idtable){
        var table = $(idtable).DataTable();
        table.cleanData;
        table.ajax.reload();
    }  
    // Button Delete
    Spandiv.ButtonDelete(".btn-delete", ".form-delete");
  
    // Change the company
    // $(document).on("change", ".card-header select[name=company]", function() {
    //     var company = $(this).val();
    //     if(company === "0") window.location.href = Spandiv.URL("{{ route('admin.applicant.index') }}");
    //     else window.location.href = Spandiv.URL("{{ route('admin.applicant.index') }}", {company: company});
    // });
</script>

@endsection
