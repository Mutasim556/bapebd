<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\HomepageSettingUpdateRequest;
use App\Http\Requests\Admin\Setting\HomepageSliderUpdateRequest;
use App\Models\Admin\HomeAboutus;
use App\Models\Admin\HomepageCounter;
use App\Models\Admin\HomepageSilder;
use App\Models\Admin\Language;
use App\Models\Admin\Translation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Stichoza\GoogleTranslate\GoogleTranslate;

class HomepageSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:homepage-slider-update,admin')->only(['mainSlider']);
    }

    public function mainSlider(){
        $sliders = HomepageSilder::where([['status',1],['delete',0]])->get();
        // dd($sliders);
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

        $languages =  Language::where([['status', 1], ['delete', 0]])->get();
        foreach ($languages as $lang) {
            Translation::updateOrInsert([
                'translationable_type'  => 'App\Models\Admin\HomepageSilder',
                'translationable_id'    => $slider->id,
                'locale'                => $lang->lang,
                'key'                   => 'slider_title',
            ],[
                'value'                 =>  GoogleTranslate::trans($data->slider_title, $lang->lang, 'en'),
                'updated_at'            => Carbon::now(),
            ]);

            Translation::updateOrInsert([
                'translationable_type'  => 'App\Models\Admin\HomepageSilder',
                'translationable_id'    => $slider->id,
                'locale'                => $lang->lang,
                'key'                   => 'slider_short_description',
            ],[
                'value'                 =>  GoogleTranslate::trans($data->slider_short_description, $lang->lang, 'en'),
                'updated_at'            => Carbon::now(),
            ]);

            Translation::updateOrInsert([
                'translationable_type'  => 'App\Models\Admin\HomepageSilder',
                'translationable_id'    => $slider->id,
                'locale'                => $lang->lang,
                'key'                   => 'button_text',
            ],[
                'value'                 =>  GoogleTranslate::trans($data->button_text, $lang->lang, 'en'),
                'updated_at'            => Carbon::now(),
            ]);
        }

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
            'slider_image'=>'mimes:png,jpg,jpeg',
            // 'slider_image'=>'mimes:png,jpg,jpeg|dimensions:min_width=2376,min_height=807',
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
            $manager->read($data->slider_image)->resize(1920,800)->save(env('ASSET_DIRECTORY').'/'.'bipebd/files/settings/homepage/slider/'.$file);
        }else{
            $file_name = $slider->slider_image;
        }

        $slider->slider_image = $file_name;

        if($data->slider_image2){
            $files = $data->slider_image2;
            $file = time().'img2.'.$files->getClientOriginalExtension();
            $file_name = 'bipebd/files/settings/homepage/slider/'.$file;
            $manager = new ImageManager(new Driver);
            $manager->read($data->slider_image2)->resize(660,660)->save(env('ASSET_DIRECTORY').'/'.'bipebd/files/settings/homepage/slider/'.$file);
        }else{
            $file_name = $slider->slider_image2;
        }

        $slider->slider_image2 = $file_name;

        $slider->save();

        $languages =  Language::where([['status', 1], ['delete', 0]])->get();
        foreach ($languages as $lang) {
            Translation::updateOrInsert([
                'translationable_type'  => 'App\Models\Admin\HomepageSilder',
                'translationable_id'    => $slider->id,
                'locale'                => $lang->lang,
                'key'                   => 'slider_title',
            ],[
                'value'                 =>  GoogleTranslate::trans($data->slider_title, $lang->lang, 'en'),
                'updated_at'            => Carbon::now(),
            ]);

            Translation::updateOrInsert([
                'translationable_type'  => 'App\Models\Admin\HomepageSilder',
                'translationable_id'    => $slider->id,
                'locale'                => $lang->lang,
                'key'                   => 'slider_short_description',
            ],[
                'value'                 =>  GoogleTranslate::trans($data->slider_short_description, $lang->lang, 'en'),
                'updated_at'            => Carbon::now(),
            ]);

            Translation::updateOrInsert([
                'translationable_type'  => 'App\Models\Admin\HomepageSilder',
                'translationable_id'    => $slider->id,
                'locale'                => $lang->lang,
                'key'                   => 'slider_button_text',
            ],[
                'value'                 =>  GoogleTranslate::trans($data->slider_button_text, $lang->lang, 'en'),
                'updated_at'            => Carbon::now(),
            ]);
        }

        return response([
            'slider' => HomepageSilder::findOrFail($id),
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Slider updated successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ],200);
    }

    public function otherContent(){
        $counter = HomepageCounter::first();
        if(!$counter){
            $counter = new HomepageCounter();
            $counter->successfully_completed =0;
            $counter->trainer =0;
            $counter->certification =0;
            $counter->student =0;

            $counter->save();
        }
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
        $counter = HomepageCounter::first();
        $aboutus = HomeAboutus::withoutGlobalScope('translate')->first();
        // dd($aboutus);
        return view('backend.blade.settings.others.index',compact('counter','aboutus'));
    }

    public function updateCounter(Request $data){
        // dd($data->all());
            $counter = HomepageCounter::find(1);
            $counter->successfully_completed =$data->successfully_completed;
            $counter->trainer =$data->trainer;
            $counter->certification =$data->certification;
            $counter->student =$data->student;

            $counter->save();

            return back();
    }

    public function updateAboutus(Request $data){
        // dd($data->all());
        $aboutus = HomeAboutus::findOrfail(1);

        $aboutus->headline=$data->headline;


        $aboutus->short_details=$data->short_details;
        $aboutus->points=json_encode($data->points);
        $aboutus->button_text=$data->button_text;
        $aboutus->number_of_experience=$data->number_of_experience;


        if($data->image1){
            $files = $data->image1;
            $file = time().'img1.'.$files->getClientOriginalExtension();
            $file_name = 'bipebd/files/settings/homepage/aboutus/'.$file;
            $manager = new ImageManager(new Driver);
            $manager->read($data->image1)->resize(714,447)->save(env('ASSET_DIRECTORY').'/'.'bipebd/files/settings/homepage/aboutus/'.$file);
            $aboutus->image1=$file_name;
        }

        if($data->image2){
            $files = $data->image2;
            $file = time().'img2.'.$files->getClientOriginalExtension();
            $file_name = 'bipebd/files/settings/homepage/aboutus/'.$file;
            $manager = new ImageManager(new Driver);
            $manager->read($data->image2)->resize(340,265)->save(env('ASSET_DIRECTORY').'/'.'bipebd/files/settings/homepage/aboutus/'.$file);
             $aboutus->image2=$file_name;
        }
        $aboutus->save();
        $languages =  Language::where([['status', 1], ['delete', 0]])->get();
        foreach ($languages as $lang) {
            $headline = $lang->lang != 'en' ? 'headline_' . $lang->lang : 'headline';
            if ($data->$headline == null) {
                continue;
            } else {
                Translation::updateOrInsert([
                    'translationable_type'  => 'App\Models\Admin\HomeAboutus',
                    'translationable_id'    => $aboutus->id,
                    'locale'                => $lang->lang,
                    'key'                   => 'headline',
                ],[
                    'value'                 =>  $data->$headline,
                    'updated_at'            => Carbon::now(),
                ]);
            }

            $short_details = $lang->lang != 'en' ? 'short_details_' . $lang->lang : 'short_details';
            if ($data->$short_details == null) {
                continue;
            } else {
                Translation::updateOrInsert([
                    'translationable_type'  => 'App\Models\Admin\HomeAboutus',
                    'translationable_id'    => $aboutus->id,
                    'locale'                => $lang->lang,
                    'key'                   => 'short_details',
                ],[
                    'value'                 =>  $data->$short_details,
                    'updated_at'            => Carbon::now(),
                ]);
            }

            $points = $lang->lang != 'en' ? 'points_' . $lang->lang : 'points';
            if ($data->$points == null) {
                continue;
            } else {
                Translation::updateOrInsert([
                    'translationable_type'  => 'App\Models\Admin\HomeAboutus',
                    'translationable_id'    => $aboutus->id,
                    'locale'                => $lang->lang,
                    'key'                   => 'points',
                ],[
                    'value'                 =>  json_encode($data->$points),
                    'updated_at'            => Carbon::now(),
                ]);
            }
            $button_text = $lang->lang != 'en' ? 'button_text_' . $lang->lang : 'button_text';
            if ($data->$button_text == null) {
                continue;
            } else {
                Translation::updateOrInsert([
                    'translationable_type'  => 'App\Models\Admin\HomeAboutus',
                    'translationable_id'    => $aboutus->id,
                    'locale'                => $lang->lang,
                    'key'                   => 'button_text',
                ],[
                    'value'                 =>  $data->$button_text,
                    'updated_at'            => Carbon::now(),
                ]);
            }
        }

        return back();
    }

}
