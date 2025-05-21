<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\HomepageSettingUpdateRequest;
use App\Http\Requests\Admin\Setting\HomepageSliderUpdateRequest;
use App\Models\Admin\HomepageSilder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class HomepageSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:homepage-slider-update,admin')->only(['mainSlider']);
    }

    public function mainSlider(){
        $sliders = HomepageSilder::where([['status',1],['delete',0]])->get();
        return view('backend.blade.settings.homepage.main_slider',compact('sliders'));
    }


    public function mainSliderStore(Request $data){
        // dd($data->all());
        $data->validate([
            'slider_title'=>'required',
            'slider_short_description'=>'required',
            'slider_button_text'=>'required',
            'slider_image'=>'required|mimes:png,jpg,jpeg',
        ]);
        $slider = new HomepageSilder();
        $slider->slider_title= $data->slider_title;
        $slider->slider_short_description= $data->slider_short_description;
        $slider->slider_link= $data->slider_link;
        $slider->slider_button_text= $data->slider_button_text;
        $slider->status= 1;
        $slider->created_by = LoggedAdmin()->id;
        $slider->updated_by = LoggedAdmin()->id;

        if($data->slider_image){
            $files = $data->slider_image;
            $file = time().'img1.'.$files->getClientOriginalExtension();
            $file_name = 'bipebd/files/settings/homepage/slider/'.$file;
            $manager = new ImageManager(new Driver);
            $manager->read($data->slider_image)->resize(1920,800)->save(env('ASSET_DIRECTORY').'/'.'bipebd/files/settings/homepage/slider/'.$file);
        }else{
            $file_name = "";
        }

        $slider->slider_image = $file_name;

        if($data->slider_image2){
            $files = $data->slider_image2;
            $file = time().'img2.'.$files->getClientOriginalExtension();
            $file_name = 'bipebd/files/settings/homepage/slider/'.$file;
            $manager = new ImageManager(new Driver);
            $manager->read($data->slider_image2)->resize(660,660)->save(env('ASSET_DIRECTORY').'/'.'bipebd/files/settings/homepage/slider/'.$file);
        }else{
            $file_name = "";
        }

        $slider->slider_image2 = $file_name;


        $slider->save();

        return response([
            'slider' => HomepageSilder::findOrFail($slider->id),
            'title' => __('admin_local.Congratulations !'),
            'text' => __('admin_local.Slider added successfully.'),
            'confirmButtonText' => __('admin_local.Ok'),
            'hasAnyPermission' => hasPermission(['homepage-slider-update', 'homepage-slider-delete']),
            'hasEditPermission' => hasPermission(['homepage-slider-update']),
            'hasDeletePermission' => hasPermission(['homepage-slider-delete']),
        ], 200);
    }

    public function destroySlider(string $id)
    {
        $slider = HomepageSilder::findOrFail($id);
        $slider->delete=1;
        $slider->save();
        return response([
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Slider deleted successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
    }

    public function updateSliderStatus(Request $data){
        // dd($data->id);
        $slider = HomepageSilder::findOrFail($data->id);
        $slider->status=$data->status;
        $slider->updated_at=Carbon::now();
        $slider->save();
        return response($slider);
    }

    public function edit(string $id)
    {
       $slider = HomepageSilder::findOrFail($id);
       return response($slider);
    }

    public function update(Request $data,string $id){
        $data->validate([
            'slider_title'=>'required',
            'slider_short_description'=>'required',
            'slider_button_text'=>'required',
            'slider_image'=>'mimes:png,jpg,jpeg|dimensions:min_width=2376,min_height=807',
        ]);

        $slider = HomepageSilder::findOrFail($id);
        $slider->slider_title= $data->slider_title;
        $slider->slider_short_description= $data->slider_short_description;
        $slider->slider_link= $data->slider_link;
        $slider->slider_button_text= $data->slider_button_text;
        $slider->status= 1;
        $slider->updated_by = LoggedAdmin()->id;

        if($data->slider_image){
            $files = $data->slider_image;
            $file = time().'img1.'.$files->getClientOriginalExtension();
            $file_name = 'bipebd/files/settings/homepage/slider/'.$file;
            $manager = new ImageManager(new Driver);
            $manager->read($data->slider_image)->resize(2376,807)->save(env('ASSET_DIRECTORY').'/'.'bipebd/files/settings/homepage/slider/'.$file);
        }else{
            $file_name = $slider->slider_image;
        }

        $slider->slider_image = $file_name;

        if($data->slider_image2){
            $files = $data->slider_image2;
            $file = time().'img2.'.$files->getClientOriginalExtension();
            $file_name = 'bipebd/files/settings/homepage/slider/'.$file;
            $manager = new ImageManager(new Driver);
            $manager->read($data->slider_image2)->resize(2376,807)->save(env('ASSET_DIRECTORY').'/'.'bipebd/files/settings/homepage/slider/'.$file);
        }else{
            $file_name = $slider->slider_image2;
        }

        $slider->slider_image2 = $file_name;

        $slider->save();

        return response([
            'slider' => HomepageSilder::findOrFail($id),
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Slider updated successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ],200);
    }
}
