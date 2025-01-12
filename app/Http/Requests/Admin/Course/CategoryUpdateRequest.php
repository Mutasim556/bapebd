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

class CategoryUpdateRequest extends FormRequest
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
            'category_image' => 'mimes:png,jpg,jpeg|max:2000',
        ];
    }

    public function update($id)
    {
        $category = CourseCategory::findOrFail($id);
        $dir = getDirectoryLink('course/category');
        if ($this->category_image) {
            $files = $this->category_image;
            $file = $this->category_name . time() . '.' . $files->getClientOriginalExtension();
            $file_name = $dir . '/' . $file;
            // dd($file_name);
            if ($category->category_image) {
                unlink($category->category_image);
            }
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $manager = new ImageManager(new Driver());
            $manager->read($this->category_image)->resize(50, 50)->save($dir . '/' . $file);

            $category->category_name = $this->category_name;
            $category->category_image = $file_name;
        } else {
            $category->category_name = $this->category_name;
        }
        $languages =  Language::where([['status', 1], ['delete', 0]])->get();
        foreach ($languages as $lang) {
            $category_name = $lang->lang != 'en' ? 'category_name_' . $lang->lang : 'category_name';
            if ($this->$category_name == null) {
                continue;
            } else {
                Translation::updateOrInsert([
                    'translationable_type'  => 'App\Models\Admin\Course\CourseCategory',
                    'translationable_id'    => $category->id,
                    'locale'                => $lang->lang,
                    'key'                   => 'category_name',
                ],[
                    'value'                 => GoogleTranslate::trans($this->$category_name, $lang->lang, 'en'),
                    'updated_at'            => Carbon::now(),
                ]);
            }
        }
        $category->save();
        return true;
    }
}
