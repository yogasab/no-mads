<?php

namespace App\Http\Controllers\Admin\Travel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Travel\StoreTravelPackageRequest;
use App\Models\TravelPackage;
use Illuminate\Http\Request;

class TravelPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $travels = TravelPackage::latest()->get();
        return view('pages.admin.travel-package.index', [
            'travels' => $travels
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.travel-package.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTravelPackageRequest $request)
    {
        $validatedData = $request->all();
        TravelPackage::create($validatedData);

        return redirect()
            ->route('travel-package.index')
            ->with('success', 'Travel Package created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TravelPackage $travel_package)
    {
        return view('pages.admin.travel-package.edit', [
            'travel' => $travel_package
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TravelPackage $travel_package)
    {
        $travel_package->update($request->all());

        return redirect()
            ->route('travel-package.index')
            ->with('success', 'Travel Package updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TravelPackage $travel_package)
    {
        $travel_package->delete();

        return redirect()
            ->route('travel-package.index')
            ->with('success', 'Travel Package deleted successfully');
    }
}
