<?php

namespace App\Http\Controllers;

use PDF;
use Dompdf\FontMetrics;
use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Description;

class Assesment10Controller extends \App\Http\Controllers\Controller
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

        // Set the description
        $description = Description::where('packet_id','=',$result->packet_id)->first();
        $description->description = json_decode($description->description, true);

        // View
        return view('admin/result/assesment-10/detail', [
            'result' => $result,
            'description' => $description,
        ]);
    }

    /**
     * Print to PDF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function print(Request $request)
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
