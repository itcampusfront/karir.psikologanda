@extends('layouts/admin/main')

@section('title', 'Data Hasil Tes: '.$result->user->name)

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-2 mb-sm-0">Data Hasil Tes</h1>
    <a href="#" class="btn btn-sm btn-primary btn-print"><i class="bi-printer me-1"></i> Cetak</a>
</div>
<div class="row">
    <div class="col-md-4 col-xl-3">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">Profil</h5></div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0 py-1">
                        <span class="d-block fw-bold">Nama:</span>
                        <span class="d-block">{{ $result->user->name }}</span>
                    </li>
                    <li class="list-group-item px-0 py-1">
                        <span class="d-block fw-bold">Usia:</span>
                        <span class="d-block">{{ generate_age($result->user->attribute->birthdate, $result->created_at).' tahun' }}</span>
                    </li>
                    <li class="list-group-item px-0 py-1">
                        <span class="d-block fw-bold">Jenis Kelamin:</span>
                        <span class="d-block">{{ gender($result->user->attribute->gender) }}</span>
                    </li>
                    <li class="list-group-item px-0 py-1">
                        <span class="d-block fw-bold">Jabatan:</span>
                        <span class="d-block">{{ $result->user->attribute->position->name }}</span>
                    </li>
                    <li class="list-group-item px-0 py-1">
                        <span class="d-block fw-bold">Role:</span>
                        <span class="d-block">{{ $result->user->role->name }}</span>
                    </li>
                    <li class="list-group-item px-0 py-1">
                        <span class="d-block fw-bold">Tes:</span>
                        <span class="d-block">{{ $result->test->name }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-xl-9">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">Hasil Tes</h5></div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="false">Deskripsi</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="answer-tab" data-bs-toggle="tab" data-bs-target="#answer" type="button" role="tab" aria-controls="answer" aria-selected="false">Jawaban</button>
                    </li>
                    
                </ul>
                <div class="tab-content p-2" id="myTabContent">
                    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <p class="h4 text-center fw-bold mb-5">Nama Tes: {{ $result->test->name }}</p>
                        <table class="table table-responsive" style="max-width: 50%">
                            <tbody>
                                <tr>
                                    <td style="text-align: left"><b>Test</b></td>                                 
                                    <td style="text-align: left"></td>                                 
                                    <td style="text-align: left"></td>                                 
                                </tr>
                                <tr>
                                    <td style="text-align: left">Score Benar</td>
                                    <td style="text-align: left">:</td>
                                    <td style="text-align: left"><b>{{ $jawaban['benar'] }}</b></td>

                                </tr>
                                <tr>
                                    <td style="text-align: left">Score Penilaian</td>
                                    <td style="text-align: left">:</td>
                                    <td style="text-align: left"><b>{{ $jawaban['score'] }}</b></td>

                                </tr>
                            </tbody>
                        </table>
                        <br>


                    </div>
                    <div class="tab-pane fade" id="answer" role="tabpanel" aria-labelledby="answer-tab">
                        <div class="row">

                                    @if($result->test_id == 24)
                                        @include('admin.result.tikit.table',['j_parameter'=> 5, 'k_parameter'=>8])
                                    @elseif ($result->test_id == 25)
                                        @include('admin.result.tikit.table',['j_parameter'=> 2, 'k_parameter'=>13])
                                    @elseif ($result->test_id == 26)
                                        @include('admin.result.tikit.table',['j_parameter'=> 5, 'k_parameter'=>8])
                                    @elseif ($result->test_id == 27)
                                        @include('admin.result.tikit.table',['j_parameter'=> 5, 'k_parameter'=>6])
                                    @elseif ($result->test_id == 28)
                                        @include('admin.result.tikit.table',['j_parameter'=> 5, 'k_parameter'=>4])
                                    @elseif ($result->test_id == 29)
                                        @include('admin.result.tikit.table',['j_parameter'=> 20, 'k_parameter'=>5])
                                    @elseif ($result->test_id == 30)
                                        @include('admin.result.tikit.table',['j_parameter'=> 5, 'k_parameter'=>6])
                                    @elseif ($result->test_id == 31)
                                        @include('admin.result.tikit.table',['j_parameter'=> 5, 'k_parameter'=>8])
                                    @elseif ($result->test_id == 32)
                                        @include('admin.result.tikit.table',['j_parameter'=> 3, 'k_parameter'=>6])
                                    @elseif ($result->test_id == 33)
                                        @include('admin.result.tikit.table',['j_parameter'=> 4, 'k_parameter'=>5])
                                    @elseif ($result->test_id == 34)
                                        @include('admin.result.tikit.table',['j_parameter'=> 6, 'k_parameter'=>10])
                                    @else
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>Kosong</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @endif
                        </div>
                    </div>
                 
                </div>
            </div>
        </div>
    </div>
</div>

<form id="form-print" class="d-none" method="post" action="{{ route('admin.result.print') }}" target="_blank">
    @csrf
    <input type="hidden" name="id" value="{{ $result->id }}">
    <input type="hidden" name="name" value="{{ $result->user->name }}">
    <input type="hidden" name="age" value="{{ generate_age($result->user->attribute->birthdate, $result->created_at).' tahun' }}">
    <input type="hidden" name="gender" value="{{ gender($result->user->attribute->gender) }}">
    <input type="hidden" name="position" value="{{ $result->user->attribute->position->name }}">
    <input type="hidden" name="test" value="{{ $result->test->name }}">
    <input type="hidden" name="path" value="{{ $result->test->code }}">
</form>

@endsection

@section('js')

<script type="text/javascript">
    $(document).on("click", ".btn-print", function(e) {
        e.preventDefault();
        $("#form-print").submit();
    });
</script>

@endsection

@section('css')

<style type="text/css">
    table tr th, table tr td {padding: .25rem .5rem;}
</style>

@endsection