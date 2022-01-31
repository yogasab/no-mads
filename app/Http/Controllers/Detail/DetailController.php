<?php

namespace App\Http\Controllers\Detail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index()
    {
        return view('pages.details');
    }
}
