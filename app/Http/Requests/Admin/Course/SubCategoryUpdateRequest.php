<?php

namespace App\Http\Requests\Admin\Course;

use App\Models\Admin\Course\CourseSubCategory;
use App\Models\Admin\Language;
use App\Models\Admin\Translation;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Stichoza\GoogleTranslate\GoogleTranslate;

class SubCategoryUpdateRequest extends FormRequest
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
            'category' => 'required',
            'sub_category_name' => 'required',
            'sub_category_slug' => 'required|unique:course_sub_categories,sub_category_slug,'.$this->sub_category_id,
            'sub_category_image' => 'mimes:png,jpg,jpeg|max:2000',
        ];
    }


    public function update($id){
        $sub_category = CourseSubCategory::findOrFail($id);
        $dir = getDirectoryLink('course/sub-category');
        $makeDir = createDirectory($dir);
        if($this->sub_category_image){
            $files = $this->sub_category_image;
            $file = $this->sub_category_name.time().'.'.$files->getClientOriginalExtension();
            $file_name =  $dir.'/'.$file;
            if($sub_category->sub_category_image){
                unlink($sub_category->sub_category_image);
            }
            $manager = new ImageManager(new Driver());
            $manager->read($this->sub_category_image)->save($file_name);

            $sub_category->sub_category_name=$this->sub_category_name;
            $sub_category->sub_category_slug = $this->sub_category_slug;
            $sub_category->category_id=$this->category;
            $sub_category->sub_category_image=$file_name;
            $sub_category->save();
        }else{
            $sub_category->sub_category_name=$this->sub_category_name;
            $sub_category->sub_category_slug = $this->sub_category_slug;
            $sub_category->category_id=$this->category;
            $sub_category->sub_category_updated_by=LoggedAdmin()->id;
            
            $sub_category->save();
        }

        $languages =  Language::where([['status', 1], ['delete', 0]])->get();
        foreach ($languages as $lang) {
            $sub_category_name = $lang->lang != 'en' ? 'sub_category_name_' . $lang->lang : 'sub_category_name';
            if ($this->$sub_category_name == null) {
                continue;
            } else {
                Translation::updateOrInsert([
                    'translationable_type'  => 'App\Models\Admin\Course\CourseSubCategory',
                    'translationable_id'    => $sub_category->id,
                    'locale'                => $lang->lang,
                    'key'                   => 'sub_category_name',
                ],[
                    'value'                 => GoogleTranslate::trans($this->$sub_category_name, $lang->lang, 'en'),
                    'updated_at'            => Carbon::now(),
                ]);
            }
        }

        return true;
    }
}
