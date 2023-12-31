@extends('layouts/admin/main')

@section('title', 'Kelola Lowongan')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-2 mb-sm-0">Kelola Lowongan</h1>
    <a href="{{ route('admin.vacancy.create') }}" class="btn btn-sm btn-primary"><i class="bi-plus me-1"></i> Tambah Lowongan</a>
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
                                {{-- <th width="30"><input type="checkbox" class="form-check-input checkbox-all"></th> --}}
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th width="100">Pelamar</th>
                                <th width="100">Status</th>
                                <th width="100">Waktu</th>
                                {{-- @if(Auth::user()->role->is_global === 1 && Request::query('company') == null) --}}
                                <th width="200">Perusahaan</th>
                                {{-- @endif --}}
                                <th width="60">Opsi</th>
                            </tr>
                        </thead>
                        
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
		</div>
	</div>
</div>

<form class="form-delete d-none" method="post" action="{{ route('admin.vacancy.delete') }}">
    @csrf
    <input type="hidden" name="id">
</form>

<!-- Modal -->
<div class="modal fade" id="modal-url" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">URL Formulir</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Berikut adalah URL yang digunakan untuk menuju ke formulir pendaftaran lowongan:</p>
                <div class="input-group">
                    <input type="text" id="url" class="form-control form-control-sm" value="{{ url('/') }}" readonly>
                    <button class="btn btn-sm btn-outline-primary btn-copy" type="button" data-bs-toggle="tooltip" title="Salin ke Clipboard"><i class="bi-clipboard"></i></button>
					<a href="" class="btn btn-sm btn-outline-primary btn-link" target="_blank" data-bs-toggle="tooltip" title="Kunjungi URL"><i class="bi-link"></i></a>
                </div>
                <input type="hidden" id="url-root" value="{{ url('/') }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script type="text/javascript">
    // DataTable
    // Spandiv.DataTable("#datatable");

    $(document).ready(function(){
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'url' : '{{ route('admin.vacancy.getData') }}',
                'data': function(d){
                    d.company_select = $('#company').val(); 
                }
            },
            order: [],
            columns: [
                {data: 'name_link', name: 'name_link'},
                {data: 'pos_name', name: 'pos_name'},
                {data: 'pelamar', name: 'pelamar'},
                {data: 'status', name: 'status'},
                {data: 'create', name: 'create'},
                {data: 'company_name', name: 'company_name'},
                {data: 'action', name: 'action'},
            ],
        });

        $('#company').change(function(){
            reloadTable('#datatable');
        });
    });

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
    //     if(company === "0") window.location.href = Spandiv.URL("{{ route('admin.vacancy.index') }}");
    //     else window.location.href = Spandiv.URL("{{ route('admin.vacancy.index') }}", {company: company});
    // });

    // Button URL
    $(document).on("click", ".btn-url", function(e) {
        e.preventDefault();
        var id = $(this).data("id");
        var url = $(this).data("url");
        var url_root = $("#url-root").val();
        $("#url").val(url_root + '/lowongan/' + url);
        $(".btn-link").attr('href', url_root + '/lowongan/' + url);
        var modal = bootstrap.Modal.getOrCreateInstance(document.querySelector("#modal-url"));
        modal.show();
    });

    // Button Copy to Clipboard
    $(document).on("click", ".btn-copy", function(e) {
        e.preventDefault();
        var url = $(this).data("url");
        document.getElementById("url").select();
        document.getElementById("url").setSelectionRange(0, 99999);
        document.execCommand("copy");
        $(this).attr("data-bs-original-title", "Tersalin!");
        $(this).tooltip("show");
        $(this).attr("data-bs-original-title", "Salin ke Clipboard");
    });

    // Change Status
    $(document).on("change", ".status", function() {
        var status_before = $(this).data("value");
        var id = $(this).data("id");
        var status = $(this).val();
        $(this).find("option[value=" + status_before + "]").prop("selected", true);
        var word = status == 1 ? "mengaktifkan" : "menonaktifkan";
        var ask = confirm("Anda yakin ingin " + word + " data ini?");
        if(ask) {
            $.ajax({
                type: "post",
                url: "{{ route('admin.vacancy.update-status') }}",
                data: {_token: "{{ csrf_token() }}", id: id, status: status},
                success: function(response) {
                    if(response == "Berhasil mengupdate status!") {
                        alert(response);
                        window.location.href = "{{ route('admin.vacancy.index') }}";
                    }
                }
            });
        }
    });
</script>

@endsection
