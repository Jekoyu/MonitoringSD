<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemsController extends Controller
{
    public function index()
    {
        return view('systems');
    }
}
