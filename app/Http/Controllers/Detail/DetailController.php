<?php

namespace App\Http\Controllers\Detail;

use App\Http\Controllers\Controller;
use App\Models\TravelPackage;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index(TravelPackage $travel_package)
    {
        $travel_package = TravelPackage::with(['travel_galleries'])
            ->whereSlug($travel_package->slug)
            ->firstOrFail();

        return view('pages.details', [
            'travel' => $travel_package
        ]);
    }
}
