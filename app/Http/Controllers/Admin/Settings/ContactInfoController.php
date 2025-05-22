<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Admin\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
     public function __construct()
    {
        $this->middleware('permission:contact-info-index,admin');
        $this->middleware('permission:contact-info-update,admin')->only(['edit','update','updateStatus']);
    }

    public function index(){
        $contactinfo = ContactInfo::first();
        return view('backend.blade.settings.contactinfo.index',compact('contactinfo'));
    }

    public function update(Request $data){
        // dd($data->all());
        $contactinfo = ContactInfo::findOrFail(1);
        $contactinfo->phone = $data->phone;
        $contactinfo->email = $data->email;
        $contactinfo->address = $data->address;
        $contactinfo->location = $data->location;
        $contactinfo->facebook = $data->facebook;
        $contactinfo->twitter = $data->twitter;
        $contactinfo->youtube = $data->youtube;
        $contactinfo->linkedin = $data->linkedin;

        $contactinfo->save();
        return back();
    }
}
