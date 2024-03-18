<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TIKITController extends Controller
{
    public static function detail($result)
    {
        $jawaban = $result->result;
        $jawaban_tikit = array();
        for($i = 0; $i < 11; $i++){
            $jawaban_tikit[$i] = json_decode($jawaban['tikit-'.$i+1], true);
        }
        // dd(array_reverse($jawaban_tikit));
        $reverse_array = array_reverse($jawaban_tikit);
        return view('admin.result.tikit.detail-tikit-all', [
            'jawaban' => $reverse_array,
            'result' => $result
        ]);
    }

    public static function print(Request $request)
    {
        dd($request->all());
        return view('admin.result.tikit.pdf', [
            'age'=>$request->age,
            'gender'=>$request->gender,
            'position'=>$request->position,
            'name'=> $request->name,
        ]);
    }
}
