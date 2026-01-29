<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Http\Request;

class PublicInstructorController extends Controller
{
    public function index()
    {
        $instructores = Instructor::all();
        return view('public.instructores.index', compact('instructores'));
    }
}
