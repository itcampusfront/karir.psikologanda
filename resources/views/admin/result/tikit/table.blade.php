@if($result->test_id == 23)
    @for($j=1; $j<= $j_parameter ; $j++)
        <div class=" col-6 col-md-4 mb-2 mb-md-0">
            <table class="table table-responsive">
                <thead bgcolor="#bebebe">
                    <tr>
                        <th width="40">#</th>
                        <th width="40">Jawaban</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($k = (($j-1)*$k_parameter)+1; $k <= $j*$k_parameter; $k++)
                        <tr>
                            <td>{{ $k }}</td>
                            @if($i == 1 || $i == 3 || $i == 7 || $i == 2)
                                <td>{{ convertOption($i+1,$jawaban[$i]['opsi_jawaban'][$k]) }}</td>
                            @else
                                <td>{{ $jawaban[$i]['opsi_jawaban'][$k] }}</td>
                            @endif
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    @endfor
@else
    @for($j=1; $j<= $j_parameter ; $j++)
        <div class=" col-6 col-md-4 mb-2 mb-md-0">
            <table class="table table-responsive">
                <thead bgcolor="#bebebe">
                    <tr>
                        <th width="40">#</th>
                        <th width="40">Jawaban</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($k = (($j-1)*$k_parameter)+1; $k <= $j*$k_parameter; $k++)
                        <tr>
                            <td>{{ $k }}</td>
                               
                            @if($result->test_id == 25 || $result->test_id == 26 || $result->test_id == 27 || $result->test_id == 31)
                                <td>{{ convertOption($result->test_id,$jawaban['opsi_jawaban'][$k]) }}</td>
                            @else
                                <td>{{ $jawaban['opsi_jawaban'][$k] }}</td>
                            @endif
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    @endfor
@endif

