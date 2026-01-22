<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Red;
use Illuminate\Http\Request;

class PublicRedController extends Controller
{
    public function index()
    {
        $redes = Red::all();
        return view('redes.index', compact('redes'));
    }
}
