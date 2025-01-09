<?php

namespace App\Http\Requests\Admin\Course;

use App\Models\Admin\Course\CourseCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

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

    public function update($id) {
        $category = CourseCategory::findOrFail($id);
        $dir = getDirectoryLink('course/category');
        if($this->category_image){
            $files = $this->category_image;
            $file = $this->category_name.time().'.'.$files->getClientOriginalExtension();
            $file_name = $dir.'/'.$file;
            // dd($file_name);
            if($category->category_image){
                unlink($category->category_image);
            }
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $manager = new ImageManager(new Driver());
            $manager->read($this->category_image)->resize(50,50)->save($dir.'/'.$file);

            $category->category_name=$this->category_name;
            $category->category_image=$file_name;
            $category->save();
        }else{
            $category->category_name=$this->category_name;
            $category->save();
        }
        return true;
    }
}
