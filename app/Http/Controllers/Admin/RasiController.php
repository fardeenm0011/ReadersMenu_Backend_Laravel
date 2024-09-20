<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rasi;
use Illuminate\Http\Request;

class RasiController extends Controller
{
    public function getRasi()
    {
        $rasi = Rasi::all();
        return response()->json(['data' => $rasi]);
    }
}
