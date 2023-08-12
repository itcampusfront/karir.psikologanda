@extends('layouts/admin/main')

@section('title', 'Detail Magang: '.$internship->name)

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-2 mb-sm-0">Detail Magang</h1>
    @if(!$selection)
    <a href="#" class="btn btn-sm btn-primary btn-set-test"><i class="bi-clock me-1"></i> Atur Waktu Tes</a>
    @endif
</div>
<div class="row">
    <div class="col-md-4 col-xl-3">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ asset('assets/images/pas-foto/'.$internship->photo) }}" class="rounded-circle" height="150" width="150" alt="Foto">
            </div>
            <hr class="my-0">
            <div class="card-body">
                <h5 class="h6 card-title">Info Magang</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-1"><i class="bi-calendar me-1"></i> Magang tanggal {{ date('d/m/Y', strtotime($internship->created_at)) }}</li>
                    <li class="mb-1"><i class="bi-clock me-1"></i> Magang pukul {{ date('H:i', strtotime($internship->created_at)) }} WIB</li>
                    <li class="mb-1"><i class="bi-shuffle me-1"></i> Jabatan <a href="#">{{ $internship->attribute->position ? $internship->attribute->position->name : '-' }}</a></li>
                    <li class="mb-1"><i class="bi-building me-1"></i> Perusahaan <a href="#">{{ $internship->attribute->company ? $internship->attribute->company->name : '-' }}</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-xl-9">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">Identitas Magang</h5></div>
            <div class="card-body">
                @if(Session::get('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="alert-message">{{ Session::get('message') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="identity-tab" data-bs-toggle="tab" data-bs-target="#identity" type="button" role="tab" aria-controls="identity" aria-selected="true">Identitas</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="attachment-tab" data-bs-toggle="tab" data-bs-target="#attachment" type="button" role="tab" aria-controls="attachment" aria-selected="false">Lampiran</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="socmed-tab" data-bs-toggle="tab" data-bs-target="#socmed" type="button" role="tab" aria-controls="socmed" aria-selected="false">Media Sosial</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="guardian-tab" data-bs-toggle="tab" data-bs-target="#guardian" type="button" role="tab" aria-controls="guardian" aria-selected="false">Data Darurat</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="skill-tab" data-bs-toggle="tab" data-bs-target="#skill" type="button" role="tab" aria-controls="skill" aria-selected="false">Keahlian</button>
                    </li>
                </ul>
                <div class="tab-content p-2" id="myTabContent">
                    <div class="tab-pane fade show active" id="identity" role="tabpanel" aria-labelledby="identity-tab">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                                <div class="fw-bold">Nama:</div>
                                <div>{{ $internship->name }}</div>
                            </li>
                            <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                                <div class="fw-bold">Tempat Lahir:</div>
                                <div>{{ $internship->attribute->birthplace }}</div>
                            </li>
                            <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                                <div class="fw-bold">Tanggal Lahir:</div>
                                <div>{{ date('d/m/Y', strtotime($internship->attribute->birthdate)) }}</div>
                            </li>
                            <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                                <div class="fw-bold">Agama:</div>
                                <div>{{ religion($internship->attribute->religion) }}</div>
                            </li>
                            <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                                <div class="fw-bold">Email:</div>
                                <div>{{ $internship->email }}</div>
                            </li>
                            <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                                <div class="fw-bold">Nomor HP:</div>
                                <div>{{ $internship->attribute->phone_number }}</div>
                            </li>
                            <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                                <div class="fw-bold">NIK:</div>
                                <div>{{ $internship->attribute->identity_number }}</div>
                            </li>
                            <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                                <div class="fw-bold">Alamat:</div>
                                <div>{{ $internship->attribute->address }}</div>
                            </li>
							<li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                                <div class="fw-bold">Tujuan Pemeriksaan:</div>
                                <div>{{ $internship->attribute->inspection }}</div>
                            </li>
                            <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                                <div class="fw-bold">Status Hubungan:</div>
                                <div>{{ relationship($internship->attribute->relationship) }}</div>
                            </li>
                        </ul>
                        <br>
                        <p class="fw-bold text-dark mb-0">Pendidikan Terakhir:</p>
                        <p class="mb-0">{{ $internship->attribute->latest_education }}</p>
                        <hr class="my-1">
                        <p class="fw-bold text-dark mb-0">Riwayat Pekerjaan:</p>
                        <p class="mb-0">{!! $internship->attribute->job_experience != '' ? nl2br($internship->attribute->job_experience) : '-' !!}</p>
                    </div>
                    <div class="tab-pane fade" id="attachment" role="tabpanel" aria-labelledby="attachment-tab">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                                <div class="fw-bold">Pas Foto:</div>
                                <div>
                                    @if($internship->photo != '')
                                        <a href="{{ asset('assets/images/pas-foto/'.$internship->photo) }}" class="btn btn-sm btn-primary" target="_blank"><i class="bi-camera me-1"></i> Lihat Foto</a>
                                    @else
                                        -
                                    @endif
                                </div>
                            </li>
                            <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                                <div class="fw-bold">Ijazah:</div>
                                <div>
                                    @if($internship->certificate != '')
                                        <a href="{{ asset('assets/images/foto-ijazah/'.$internship->certificate) }}" class="btn btn-sm btn-primary" target="_blank"><i class="bi-camera me-1"></i> Lihat Foto</a>
                                    @else
                                        -
                                    @endif
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="socmed" role="tabpanel" aria-labelledby="socmed-tab">
                        @if($internship->socmed)
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                                    <div class="fw-bold">{{ platform($internship->socmed->platform) }}:</div>
                                    <div>{{ $internship->socmed->account }}</div>
                                </li>
                            </ul>
                        @else
                            <div class="alert alert-danger" role="alert">
                                <div class="alert-message">Tidak ada data.</div>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="guardian" role="tabpanel" aria-labelledby="guardian-tab">
                        @if($internship->guardian)
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                                    <div class="fw-bold">Nama Orang Tua / Wali:</div>
                                    <div>{{ $internship->guardian->name }}</div>
                                </li>
                                <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                                    <div class="fw-bold">Nomor HP Orang Tua / Wali:</div>
                                    <div>{{ $internship->guardian->phone_number }}</div>
                                </li>
                                <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                                    <div class="fw-bold">Alamat Orang Tua / Wali:</div>
                                    <div>{{ $internship->guardian->address }}</div>
                                </li>
                                <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                                    <div class="fw-bold">Pekerjaan Orang Tua / Wali:</div>
                                    <div>{{ $internship->guardian->occupation }}</div>
                                </li>
                            </ul>
                        @else
                            <div class="alert alert-danger" role="alert">
                                <div class="alert-message">Tidak ada data.</div>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="skill" role="tabpanel" aria-labelledby="skill-tab">
                        @if(count($internship->skills) > 0)
                            <ul class="list-group list-group-flush">
                                @foreach($internship->skills as $skill)
                                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                                        <div class="fw-bold">{{ $skill->skill->name }}:</div>
                                        <div>
                                            {{ $skill->score }}
                                            @php
                                                switch($skill->score) {
                                                    case 3: echo '(Baik)'; break;
                                                    case 2: echo '(Cukup)'; break;
                                                    case 1: echo '(Kurang)'; break;
                                                }
                                            @endphp
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-danger" role="alert">
                                <div class="alert-message">Tidak ada data.</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-set-test" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Atur Tes</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('admin.selection.store') }}">
                @csrf
                <input type="hidden" name="user_id" value="{{ $internship->id }}">
                <input type="hidden" name="vacancy_id" value="{{ $internship->attribute->vacancy_id }}">
                <div class="modal-body">
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Tanggal <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <div class="input-group input-group-sm">
                                <input type="text" name="date" class="form-control form-control-sm {{ $errors->has('date') ? 'border-danger' : '' }}" value="{{ old('date') }}" autocomplete="off">
                                <span class="input-group-text {{ $errors->has('date') ? 'border-danger' : '' }}"><i class="bi-calendar2"></i></span>
                            </div>
                            @if($errors->has('date'))
                            <div class="small text-danger">{{ $errors->first('date') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Jam <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <div class="input-group input-group-sm">
                                <input type="text" name="time" class="form-control form-control-sm {{ $errors->has('time') ? 'border-danger' : '' }}" value="{{ old('time') }}" autocomplete="off">
                                <span class="input-group-text {{ $errors->has('time') ? 'border-danger' : '' }}"><i class="bi-clock"></i></span>
                            </div>
                            @if($errors->has('time'))
                            <div class="small text-danger">{{ $errors->first('time') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-lg-2 col-md-3 col-form-label">Tempat <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="place" class="form-control form-control-sm {{ $errors->has('place') ? 'border-danger' : '' }}" value="{{ old('place') }}">
                            @if($errors->has('place'))
                            <div class="small text-danger">{{ $errors->first('place') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="bi-save me-1"></i> Submit</button>
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal"><i class="bi-x-circle me-1"></i> Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')

<script type="text/javascript">
    // DatePicker
    Spandiv.DatePicker("input[name=date]");

    // ClockPicker
    Spandiv.ClockPicker("input[name=time]");

    // Button Set Test
    $(document).on("click", ".btn-set-test", function(e) {
        e.preventDefault();
        Spandiv.Modal("#modal-set-test").show();
    });
</script>

@if(count($errors) > 0)
<script type="text/javascript">
    // Show Modal
        Spandiv.Modal("#modal-set-test").show();
</script>
@endif

@endsection