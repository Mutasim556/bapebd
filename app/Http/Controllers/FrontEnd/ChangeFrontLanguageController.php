<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ChangeFrontLanguageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $lang)
    {
        try {
            Cookie::queue('frontlanguage', $lang, 10);
            // session()->put('language',$lang);
            return back();
        } catch (\Throwable $th) {
            Cookie::queue('frontlanguage','en',10);
            // session()->put('en');
            return back();
        }
    }
}
