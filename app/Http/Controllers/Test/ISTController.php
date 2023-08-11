<?php

namespace App\Http\Controllers\Test;

use Auth;
use PDF;
use Dompdf\FontMetrics;
use Illuminate\Http\Request;
use App\Models\Description;
use App\Models\Result;
use App\Models\Packet;


class ISTController extends \App\Http\Controllers\Controller
{
    /**
     * Display the specified resource.
     *
     * @param  object  $result
     * @return \Illuminate\Http\Response
     */
    public static function detail($result)
    {
        // Check the access
        // has_access(method(__METHOD__), Auth::user()->role_id);

        // Get the result
        $resultA = $result->result;

        // IQ Category
        $kategoriIQ = '';
        if($resultA['IQ'] <= 29) $kategoriIQ = 'Hasil Nilai IQ dapat ditingkatkan, tetap berusaha lebih keras dan belajar dari kesalahan';
        elseif($resultA['IQ'] >= 30 && $resultA['IQ'] <= 69) $kategoriIQ = 'Lemah Mental atau Mental Retarded';
        elseif($resultA['IQ'] >= 70 && $resultA['IQ'] <= 79) $kategoriIQ = 'Batas Lemah atau Borderline';
        elseif($resultA['IQ'] >= 80 && $resultA['IQ'] <= 89) $kategoriIQ = 'Rata-Rata Bawah';
        elseif($resultA['IQ'] >= 90 && $resultA['IQ'] <= 109) $kategoriIQ = 'Rata-Rata';
        elseif($resultA['IQ'] >= 110 && $resultA['IQ'] <= 119) $kategoriIQ = 'Rata-Rata Atas';
        elseif($resultA['IQ'] >= 120 && $resultA['IQ'] <= 139) $kategoriIQ = 'Superior';
        elseif($resultA['IQ'] >= 140) $kategoriIQ = 'Sangat Superior';
		
        // View
        return view('admin/result/ist/detail', [
            'result' => $result,
            'resultA' => $resultA,
            'kategoriIQ' => $kategoriIQ
        ]);
    }

    /**
     * Print to PDF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function print(Request $request)
    {
        // Set the result
        $result = Result::find($request->id);
		//dd($request);
		
		// Set the resultA
        $resultA = $result->result = json_decode($result->result, true);
		//dd($resultA);
		
		// Set the index
		$index = json_decode($request->index, true);
		
		// IQ Category
        if($resultA['IQ'] <= 29) $kategoriIQ = 'Hasil Nilai IQ dapat ditingkatkan, tetap berusaha lebih keras dan belajar dari kesalahan';
        elseif($resultA['IQ'] >= 30 && $resultA['IQ'] <= 69) $kategoriIQ = 'Lemah Mental atau Mental Retarded';
        elseif($resultA['IQ'] >= 70 && $resultA['IQ'] <= 79) $kategoriIQ = 'Batas Lemah atau Borderline';
        elseif($resultA['IQ'] >= 80 && $resultA['IQ'] <= 89) $kategoriIQ = 'Rata-Rata Bawah';
        elseif($resultA['IQ'] >= 90 && $resultA['IQ'] <= 109) $kategoriIQ = 'Rata-Rata';
        elseif($resultA['IQ'] >= 110 && $resultA['IQ'] <= 119) $kategoriIQ = 'Rata-Rata Atas';
        elseif($resultA['IQ'] >= 120 && $resultA['IQ'] <= 139) $kategoriIQ = 'Superior';
        elseif($resultA['IQ'] >= 140) $kategoriIQ = 'Sangat Superior';
        
        // PDF
        $pdf = PDF::loadview('admin/result/ist/pdf', [
            'chartImage' => $request->chartImage,
			'result' => $result,
            'resultA' => $resultA,
            'kategoriIQ' => $kategoriIQ,
            'image' => $request->image,
            'name' => $request->name,
            'age' => $request->age,
            'gender' => $request->gender,
            'position' => $request->position,
            'test' => $request->test,
        ]);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream($request->name . '_' . $request->test . '.pdf');
    }
}