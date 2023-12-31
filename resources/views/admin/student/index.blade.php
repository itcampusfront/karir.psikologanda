@extends('layouts/admin/main')

@section('title', 'Kelola Siswa')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-2 mb-sm-0">Kelola Siswa</h1>
    <div class="btn-group">
        <a href="{{ route('admin.student.create') }}" class="btn btn-sm btn-primary"><i class="bi-plus me-1"></i> Tambah Siswa</a>
        <a id="expo" class="btn btn-sm btn-success"><i class="bi-file-excel me-1"></i> Ekspor Data</a>
        @if((Auth::user()->role->is_global == 1 && Request::query('company') != null) || Auth::user()->role->is_global == 0)
        <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modal-import"><i class="bi-upload me-1"></i> Impor Data</a>
        @endif
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

<!-- Modal -->
<div class="modal fade" id="modal-import" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Impor Data</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('admin.student.import') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="company_id" value="{{ Auth::user()->role->is_global == 0 ? Auth::user()->attribute->company_id : Request::query('company') }}">
                <div class="modal-body">
                    <p>
                        Tata cara mengimport data Siswa:
                        <ol>
                            <li>Ekspor terlebih dahulu data <strong><a href="{{ route('admin.student.export') }}">Disini</a></strong>.</li>
                            <li>Jika ingin menambah data baru, tambahkan data di bawah baris data terakhir dari file yang sudah diekspor tadi.</li>
                            <li>Pastikan semua kolom tidak boleh kosong.</li>
                            <li>Impor data dari file excel yang sudah diubah tadi di bawah ini:</li>
                        </ol>
                    </p>
                    @if($errors->has('file'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="alert-message">File {{ $errors->first('file') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <input type="file" name="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
					<div class="small mt-2 text-muted">Hanya mendukung format: .XLS, .XLSX, dan .CSV</div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="bi-save me-1"></i> Submit</button>
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal"><i class="bi-x-circle me-1"></i> Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form class="form-delete d-none" method="post" action="{{ route('admin.student.delete') }}">
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
            pageLength: 25,
            ajax: {
                'url' : '{{ route('admin.student.index') }}',
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

    function reloadTable(idtable){
        var table = $(idtable).DataTable();
        table.cleanData;
        table.ajax.reload();
    }  
    //link export excel
    $('#expo').click(function(){
        var company_id = $('#company').val();
        if(company_id  != null){
            window.location.href = "{{ url('/admin/student/export?comp_id=') }}"+company_id;
        }
        else{
            window.location.href = "{{ url('/admin/student/export') }}";
        }
    })

    // Button Delete
    Spandiv.ButtonDelete(".btn-delete", ".form-delete");
  
    // Change the company
    // $(document).on("change", ".card-header select[name=company]", function() {
	// 	var company = $(this).val();
	// 	if(company === "0") window.location.href = Spandiv.URL("{{ route('admin.student.index') }}");
	// 	else window.location.href = Spandiv.URL("{{ route('admin.student.index') }}", {company: company});
    // });
</script>

@if(count($errors) > 0)

<script>
    Spandiv.Modal("#modal-import").show();
</script>

@endif

@endsection
