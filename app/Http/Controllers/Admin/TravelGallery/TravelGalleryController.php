<?php

namespace App\Http\Controllers\Admin\TravelGallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Travel\StoreTravelGalleryRequest;
use App\Models\TravelGallery;
use App\Models\TravelPackage;
use Illuminate\Http\Request;
use Laravel\Sail\Console\PublishCommand;

class TravelGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $travel_galleries = TravelGallery::with(['travel_package'])->latest()->get();

        return view('pages.admin.travel-gallery.index', [
            'travel_galleries' => $travel_galleries
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $travel_packages = TravelPackage::latest()->get();

        return view('pages.admin.travel-gallery.create', [
            'travel_packages' => $travel_packages
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTravelGalleryRequest $request)
    {
        $validatedData = $request->all();
        $validatedData['image'] = $request
            ->file('image')
            ->store('assets/gallery', 'public');

        TravelGallery::create($validatedData);

        return redirect()
            ->route('travel-gallery.index')
            ->with('success', 'Travel Gallery added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TravelGallery $travel_gallery)
    {
        $travel_packages = TravelPackage::all();

        return view('pages.admin.travel-gallery.edit', [
            'travel_gallery' => $travel_gallery,
            'travel_packages' => $travel_packages
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TravelGallery $travel_gallery)
    {
        $validatedData = $request->all();
        if ($request->file('image')) {
            $validatedData['image'] = $request
                ->file('image')
                ->store('assets/gallery', 'public');
        } else {
            unset($validatedData['image']);
        }

        $travel_gallery->update($validatedData);

        return redirect()
            ->route('travel-gallery.index')
            ->with('success', 'Travel Gallery updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TravelGallery $travel_gallery)
    {
        $travel_gallery->delete();

        return redirect()
            ->route('travel-gallery.index')
            ->with('success', 'Travel Gallery deleted successfully');
    }
}
