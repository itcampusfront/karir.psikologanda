<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
