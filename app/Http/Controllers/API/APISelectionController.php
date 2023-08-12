<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class APISelectionController extends Controller
{
    public function detail(Request $request)
    {        
        if($request->ajax()) {
            // Get the selection
            $selection = Selection::find($request->id);
            $selection->test_date = date('d/m/Y', strtotime($selection->test_time));

            return response()->json($selection, 200);
        }
    }
}
