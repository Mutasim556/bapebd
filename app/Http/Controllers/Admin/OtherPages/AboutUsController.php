<?php

namespace App\Http\Controllers\Admin\OtherPages;

use App\Http\Controllers\Controller;
use App\Models\Admin\AboutUs;
use App\Models\Admin\HomeAboutus;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aboutus = HomeAboutus::withoutGlobalScope('translate')->first();
        if(!$aboutus){
            $aboutus = new HomeAboutus();
            $aboutus->headline=null;
            $aboutus->short_details=null;
            $aboutus->points=null;
            $aboutus->button_text=null;
            $aboutus->number_of_experience=null;
            $aboutus->image1=null;
            $aboutus->image2=null;
            $aboutus->save();
        }
        $aboutus = HomeAboutus::withoutGlobalScope('translate')->first();
        return view('backend.blade.about_us.index',compact('aboutus'));
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
    public function update(Request $data, string $id)
    {
        $update = AboutUs::findOrFail(1);
        $update->about_us = $data->about_us;
        $update->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
