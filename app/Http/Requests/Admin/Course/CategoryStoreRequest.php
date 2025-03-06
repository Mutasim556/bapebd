<?php

namespace App\Http\Requests\Admin\Course;

use App\Models\Admin\Course\CourseCategory;
use App\Models\Admin\Language;
use App\Models\Admin\Translation;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Stichoza\GoogleTranslate\GoogleTranslate;

class CategoryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_name' => 'required',
            'category_slug' => 'required|unique:course_categories,category_slug',
            'category_image' => 'mimes:png,jpg,jpeg,svg|max:2000',
        ];
    }

    public function store(){
        if($this->category_image){
            $files = $this->category_image;
            $file = $this->parent_category_name.time().'.'.$files->getClientOriginalExtension();

            if (!File::isDirectory(public_path('admin/course/file/course/category'))) {
                File::makeDirectory(public_path('admin/course/file/course/category'), 0755, true);
            }

            $file_name = env('ASSET_DIRECTORY').'/admin/course/file/course/category/'.$file;
            $manager = new ImageManager(new Driver);
            $manager->read($this->category_image)->resize(50,50)->save(env('ASSET_DIRECTORY').'/admin/course/file/course/category/'.$file);
        }else{
            $file_name = "";
        }

        $category = new CourseCategory();
        $category->category_name = $this->category_name;
        $category->category_slug = $this->category_slug;
        $category->category_image = $file_name;
        $category->category_added_by = LoggedAdmin()->id;
        $category->category_status = 1;
        $category->save();

        $languages =  Language::where([['status',1],['delete',0]])->get();
        $data = [];
        foreach($languages as $lang){
            $category_name = $lang->lang!='en'?'category_name_'.$lang->lang:'category_name';
            if($this->$category_name==null){
                continue;
            }else{
                array_push($data, array(
                    'translationable_type'  => 'App\Models\Admin\Course\CourseCategory',
                    'translationable_id'    => $category->id,
                    'locale'                => $lang->lang,
                    'key'                   => 'category_name',
                    'value'                 => GoogleTranslate::trans($this->$category_name, $lang->lang, 'en'),
                    'created_at'            => Carbon::now(),
                ));
            }
            
        }
        Translation::insert($data);
        return $category->id;
    }
}
