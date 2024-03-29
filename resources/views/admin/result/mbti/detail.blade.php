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
                    {{-- @if(array_key_exists('answers', $result->result))
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="answer-tab" data-bs-toggle="tab" data-bs-target="#answer" type="button" role="tab" aria-controls="answer" aria-selected="false">Jawaban</button>
                    </li>
                    @endif --}}
                </ul>
                <div class="tab-content p-2" id="myTabContent">
                    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <p class="h2 text-center fw-bold ">Tipe: {{ $result->result[1][2] }}</p>
                        <p class="h3 text-center fw-bold mb-5">{{ $result_mbti[0] }}</p>
                        <div class="penjelasan mb-4">
                            {{ $result_mbti[1] }}
                        </div>
                        <div class="preferensi mb-4">
                            <h3 class="fw-bold">Preferensi</h4>
                            <ul>
                                @for($i=0;$i<count($result_mbti[2]);$i++)
                                    <li>{{ $result_mbti[2][$i] }}</li>
                                @endfor
                            </ul>
                        </div>
                        <div class="lingkungan mb-4">
                            <h3 class="fw-bold">Lingkungan</h4>
                            <ul>
                                @for($i=0;$i<count($result_mbti[3]);$i++)
                                    <li>{{ $result_mbti[3][$i] }}</li>
                                @endfor
                            </ul>
                        </div>
                        <div class="keseimbangan mb-4">
                            <h3 class="fw-bold">Keseimbangan</h4>
                            <ul>
                                @for($i=0;$i<count($result_mbti[4]);$i++)
                                    <li>{{ $result_mbti[4][$i] }}</li>
                                @endfor
                            </ul>
                        </div>
                        @if(isset($result_mbti[5]) != false)
                        <div class="pendukung mb-4">
                            <h3 class="fw-bold">Pendukung</h4>
                            <ul>
                                @for($i=0;$i<count($result_mbti[5]);$i++)
                                    <li>{{ $result_mbti[5][$i] }}</li>
                                @endfor
                            </ul>
                        </div>
                        @endif
                        <div class="penilaian1 mt-5">
                            <h3 class="fw-bold">{{ $result_p1[0] }}</h3>
                            @for($i=0;$i<count($result_p1[1]);$i++)
                                <li>{{ $result_p1[1][$i] }}</li>
                             @endfor
                        </div>
                        <div class="penilaian2 mt-5">
                            <h3 class="fw-bold">{{ $result_p2[0] }}</h3>
                            @for($i=0;$i<count($result_p2[1]);$i++)
                                <li>{{ $result_p2[1][$i] }}</li>
                             @endfor
                        </div>
                    </div>
                    {{-- @if(array_key_exists('answers', $result->result)) --}}
                    <div class="tab-pane fade" id="answer" role="tabpanel" aria-labelledby="answer-tab">
                        <div class="row">
                            {{-- @for($i=1; $i<=4; $i++) --}}
                            <div class="col-md-3 col-6 mb-2 mb-md-0">
                                <table class="table-bordered">
                                    <thead bgcolor="#bebebe">
                                        <tr>
                                            <th width="40">#</th>
                                            <th width="40">Jawaban</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @for($j=(($i-1)*16)+1; $j<=$i*16; $j++)
                                        <tr>
                                            <td align="center" bgcolor="#bebebe"><strong>{{ $j }}</strong></td>
                                            <td align="center" bgcolor="#eeeeee">{{ $result->result['answers'][$j] }}</td>
                                        </tr>
                                        @endfor --}}
                                    </tbody>
                                </table>
                            </div>
                            {{-- @endfor --}}
                        </div>
                    </div>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
    </div>
</div>

<form id="form-print" class="d-none" method="post" action="{{ route('admin.result.print') }}" target="_blank">
    @csrf
    <input type="hidden" name="id" value="{{ $result->id }}">
    <input type="hidden" name="path" value="{{ $result->test->code }}">
    <input type="hidden" name="name" value="{{ $result->user->name }}">
    <input type="hidden" name="tipe" value="{{ $result->result[1][2] }}">
    <input type="hidden" name="kepanjangan" value="{{ $result_mbti[0] }}">
    <input type="hidden" name="penjelasan" value="{{ $result_mbti[1] }}">
    <input type="hidden" name="preferensi" value="{{ json_encode($result_mbti[2]) }}">
    <input type="hidden" name="lingkungan" value="{{ json_encode($result_mbti[3]) }}">
    <input type="hidden" name="keseimbangan" value="{{ json_encode($result_mbti[4]) }}">
    @if(isset($result_mbti[5]) != false)
    <input type="hidden" name="pendukung" value="{{ json_encode($result_mbti[5]) }}">
    @endif
    <input type="hidden" name="penilaian1" value="{{ json_encode($result_p1[1]) }}">
    <input type="hidden" name="penilaian10" value="{{ $result_p1[0] }}">
    <input type="hidden" name="penilaian2" value="{{ json_encode($result_p2[1]) }}">
    <input type="hidden" name="penilaian20" value="{{ $result_p2[0] }}">
    
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
    table tr th, table tr td {padding: .25rem .5rem; text-align: center;}
</style>

@endsection