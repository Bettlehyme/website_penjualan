<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Settings;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::with('images')->paginate(10);
        return view('admin.site-setting', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method', 'site_logo', 'sales_photo', 'price_list']);

        // ✅ Save text-based settings
        foreach ($data as $key => $value) {
            Settings::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // ✅ Handle Logo Upload
        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('logos', 'public');
            Settings::updateOrCreate(['key' => 'logo'], ['value' => $path]);
        }

        // ✅ Handle Sales Photo Upload
        if ($request->hasFile('sales_photo')) {
            $path = $request->file('sales_photo')->store('sales', 'public');
            Settings::updateOrCreate(['key' => 'sales_photo'], ['value' => $path]);
        }

        // ✅ Handle Price List Image Upload
        if ($request->hasFile('price_list')) {
            $path = $request->file('price_list')->store('price_lists', 'public');
            Settings::updateOrCreate(['key' => 'price_list'], ['value' => $path]);
        }

        return back()->with('success', 'Settings updated successfully!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
