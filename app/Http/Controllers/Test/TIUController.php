<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TIUController extends Controller
{
    public static function detail($result)
    {
        // dd($result);
        return view('admin.result.tiu.detail',[
            'result' => $result
        ]);
    }
}
