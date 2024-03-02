<?php

namespace App\Http\Controllers\Test;

use PDF;
use App\Models\Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TIUController extends Controller
{
    public static function detail($result)
    {
        // dd($result->test->code);
        return view('admin.result.tiu.detail',[
            'result' => $result
        ]);
    }

    public static function print(Request $request)
    {
                $result = Result::find($request->id);
                $result_jawaban  = json_decode($result->result, true);
                $rs = $result_jawaban['rs'];
                $ws = $result_jawaban['ws'];

                // PDF
                $pdf = PDF::loadview('admin/result/tiu/pdf', [
                    // 'result' => $result,
                    'name' => $request->name,
                    'age' => $request->age,
                    'gender' => $request->gender,
                    'position' => $request->position,
                    'rs' => $rs,
                    'ws' => $ws
                ]);
                $pdf->setPaper('A4', 'portrait');
                
                return $pdf->stream('TIU.pdf');
    }
}
