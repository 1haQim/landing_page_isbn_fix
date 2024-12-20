<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PanduanLayananController extends Controller
{
    function index() {
        return view('content.panduan_layanan');
    }
}
