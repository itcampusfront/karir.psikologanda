<?php

namespace App\Http\Controllers\Test;

use PDF;
use Dompdf\FontMetrics;
use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Description;

class Assesment11Controller extends \App\Http\Controllers\Controller
{
    public static function cetak(Request $request)
    {
        // Set the result
        $result = Result::find($request->id);
        $result->result = json_decode($result->result, true);
		
        // Set the description
        $description = Description::where('packet_id','=',$result->packet_id)->first();
        $description->description = json_decode($description->description, true);
        
        // PDF
        $pdf = PDF::loadview('admin/result/assesment-10/pdf', [
            'result' => $result,
            'image' => $request->image,
            'name' => $request->name,
            'age' => $request->age,
            'gender' => $request->gender,
            'position' => $request->position,
            'test' => $request->test,
            'description' => $description,
        ]);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream($request->name . '_' . $request->test . '.pdf');
    }
}
