<?php

namespace App\Http\Controllers\Test;

use PDF;
use App\Models\Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EPPSController extends Controller
{
    public static function detail($result)
    {
       
        $converts = convertEPPS($result->result['T']);
        $konsistensi = $result->result['konsistensi'];
        $raw = $result->result['raw'];
        $t = $result->result['T'];
        $code = $result->result['code'];
        return view('admin.result.epps.detail',[
            'result' => $result,
            'konsistensi' => $konsistensi,
            'raw' => $raw,
            't' => $t,
            'code' => $code,
            'converts' => $converts
        ]);
    }

    public static function print(Request $request)
    {

        $result = Result::where('id', $request->id)->first();
        $result_decode = json_decode($result->result, true);
        $converts = convertEPPS($result_decode['T']);

        $pdf = PDF::loadview('admin/result/epps/pdf', [
            'age'=>$request->age,
            'gender'=>$request->gender,
            'position'=>$request->position,
            'test' => 'EPPS',
            'name'=> $request->name,
            'konsistensi' => $result_decode['konsistensi'],
            'raw' => $result_decode['raw'],
            't' => $result_decode['T'],
            'code' => $result_decode['code'],
            'converts' => $converts
        ]);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream('EPPS.pdf');
    }
}
