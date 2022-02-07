<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\TravelGallery;
use App\Models\TravelPackage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $travels = TravelPackage::with(['travel_galleries'])->get();

        return view('pages.home', [
            'travels' => $travels
        ]);
    }
}
