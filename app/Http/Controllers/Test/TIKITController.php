<?php

namespace App\Http\Controllers\Test;

use PDF;
use App\Models\Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TIKITController extends Controller
{
    public static function detail($result)
    {
        // dd($result);
        if($result->test_id == 23){
            $jawabsan = $result->result;
            $jawabsan_tikit = array();
            for($i = 0; $i < 11; $i++){
                $jawabsan_tikit[$i] = json_decode($jawabsan['tikit-'.$i+1], true);
            }
            // dd(array_reverse($$jawabsan_tikit));
            $reverse_array = array_reverse($jawabsan_tikit);
            return view('admin.result.tikit.detail-tikit-all', [
                'jawaban' => $reverse_array,
                'result' => $result
            ]);
        }
        else{
            $jawabsan = $result->result;
            return view('admin.result.tikit.detail-tikit-part', [
                'jawaban' => $jawabsan,
                'result' => $result
            ]);
        }
    }

    public static function print(Request $request)
    {

        $result = Result::where('id', $request->id)->first();
        $jawabans =json_decode($result->result, true); 
        $jawabsan_tikit = array();
        for($i = 0; $i < 11; $i++){
            $jawabsan_tikit[$i] = json_decode($jawabans['tikit-'.$i+1], true);
        }
        $reverse_array = array_reverse($jawabsan_tikit);
        // dd($reverse_array);
        $pdf = PDF::loadview('admin/result/tikit/pdf', [
            'age'=>$request->age,
            'gender'=>$request->gender,
            'position'=>$request->position,
            'test' => 'TIKI-T',
            'name'=> $request->name,
            'jawaban' => $reverse_array,
        ]);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream('tikit.pdf');
    }

}
