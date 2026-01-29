<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Centro;
use Illuminate\Http\Request;

class PublicCentroController extends Controller
{
    public function index()
    {
        $centros = Centro::all();
        return view('public.centros.index', compact('centros'));
    }
}
