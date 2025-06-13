<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\FrontEnd\PurchaseCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function myProfile(){
        $purchase_courses = PurchaseCourse::with('course','batch')->where('user_id',Auth::user()->id)->get();
        return view('frontend.blade.profile.index',compact('purchase_courses'));
    }
}
