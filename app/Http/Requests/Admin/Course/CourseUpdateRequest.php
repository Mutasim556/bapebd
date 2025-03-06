<?php

namespace App\Http\Requests\Admin\Course;

use App\Models\Admin\Course\Course;
use App\Models\Admin\Course\CourseBatch;
use App\Models\Admin\Course\CourseInstructor;
use App\Models\Admin\Course\CourseVideo;
use App\Models\Admin\Language;
use App\Models\Admin\Translation;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class CourseUpdateRequest extends FormRequest
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
            'course_name' => 'required',
            'course_name_slug' => 'required|unique:courses,course_name_slug,'.$this->course_id,
            'course_headline' => 'required',
            'course_details' => 'required',
            'course_category' => 'required',
            'course_sub_category' => 'required',
            'no_of_videos' => 'required',
            'course_duration' => 'required',
            'course_duration_type' => 'required',
            'course_price' => 'required',
            'course_price_type' => 'required',
            'course_discount' => 'lte:course_price',
            'course_instructor'=>['required_if:course_type,Pre-recorded'],
            'video_group.*'=>['required_if:course_type,Pre-recorded'],
            'video_file.*'=>['mimes:pdf,xlsx,doc'],
            'video_no.*'=>['required_if:course_type,Pre-recorded'],
            'video_link.*'=>['required_if:course_type,Pre-recorded'],
            'video_title.*'=>['required_if:course_type,Pre-recorded'],
            'video_duration.*'=>['required_if:course_type,Pre-recorded'],
            'video_type.*'=>['required_if:course_type,Pre-recorded'],
            'batch_name'=>['required_if:course_type,Live'],
            'batch_code'=>['required_if:course_type,Live','unique:course_batches,batch_code'],
            'batch_start_date'=>['required_if:course_type,Live'],
            'batch_end_date'=>['required_if:course_type,Live'],
            'batch_time'=>['required_if:course_type,Live'],
            'batch_instructor'=>['required_if:course_type,Live'],
            'live_in'=>['required_if:course_type,Live'],
            'link_or_address'=>['required_if:course_type,Live'],
            'enroll_limit'=>['required_if:has_enroll_limit,1'],
        ];
    }

    public function messages()
    {
        return [
            'course_name.required' => __('admin_local.Course default name is required'),
            'course_name_slug.required' => __('admin_local.Course name slug is required'),
            'course_name_slug.unique' => __('admin_local.Course name slug already exists'),
            'course_headline.required' => __('admin_local.Course default headline is required'),
            'course_details.required' => __('admin_local.Course details is required'),
            'course_type.required' => __('admin_local.Course type is required'),
            'no_of_videos.required' => __('admin_local.No of videoes/class is required'),
            'course_duration.required' => __('admin_local.Course duration is required'),
            'course_duration_type.required' => __('admin_local.Course duration type is required'),
            'course_price.required' => __('admin_local.Course price is required'),
            'course_price_type.required' => __('admin_local.Course price type is required'),
            'image.required' => __('admin_local.At least one image is required'),
            'course_instructor.required_if' => __('admin_local.At least one instructor is required'),
            'video_group.*.required_if' => __('admin_local.Video group is required'),
            'video_file.*.mimes' => __('admin_local.Pdf,Excel and Doc format required'),
            'video_no.*.required_if' => __('admin_local.Video no required'),
            'video_link.*.required_if' => __('admin_local.Video link is required'),
            'video_title.*.required_if' => __('admin_local.Video title is required'),
            'video_duration.*.required_if' => __('admin_local.Video duration is required'),
            'video_type.*.required_if' => __('admin_local.Video type is required'),
            'batch_name.required_if' => __('admin_local.Batch name is required'),
            'batch_code.required_if' => __('admin_local.Batch code is required'),
            'batch_code.unique' => __('admin_local.This batch code already used'),
            'batch_start_date.required_if' => __('admin_local.Start date is required'),
            'batch_end_date.required_if' => __('admin_local.End date is required'),
            'batch_time.required_if' => __('admin_local.Batch time is required'),
            'batch_instructor.required_if' => __('admin_local.Batch instructor is required'),
            'live_in.required_if' => __('admin_local.Live in is required'),
            'link_or_address.required_if' => __('admin_local.Link/address is required'),
            'enroll_limit.required_if' => __('admin_local.Enroll Limit is required'),
            'course_discount.lte' => __('admin_local.Discount can not be greater then price'),
        ];
    }

    public function update($id)
    {
         /** Course store start */
         $course = Course::findOrFail($id);
         $course->course_name = $this->course_name;
         $course->course_name_slug = $this->course_name_slug;
         $course->course_name_metaphone = metaphone($this->course_name);
         $course->course_headline = $this->course_headline;
         $course->course_details = $this->course_details;
         $course->category_id = $this->course_category;
         $course->sub_category_id = $this->course_sub_category;
         $course->no_of_videos = $this->no_of_videos;
         $course->course_duration = $this->course_duration;
         $course->course_duration_type = $this->course_duration_type;
         $course->course_price = $this->course_price;
         $course->course_price_currency = $this->course_price_type;
         $course->course_discount = $this->course_discount;
         $course->course_level = $this->course_level;
         $course->course_discount_type = $this->course_discount_type;
         if ($this->course_discount_type == 'Percent') {
             $course->course_discount_price = ceil($this->course_price - (($this->course_price * $this->course_discount) / 100));
         } elseif ($this->course_discount_type == 'Flat') {
             $course->course_discount_price = ceil($this->course_price - $this->course_discount);
         } else {
             $course->course_discount_price = $this->course_price;
         }

         $course->course_cupon_status = $this->course_cupon_status ? 1 : 0;
         $course->course_multiple_cupon_status = $this->course_multiple_cupon_status ? 1 : 0;

         $dir = getDirectoryLink('course/course-images');
         $makeDir = createDirectory($dir);
         if ($this->image) {
             $images = $this->image;
             $image_names = [];

             foreach ($images as $key => $image) {
                 $imageName = $image->getClientOriginalName();
                 $manager = new ImageManager(new Driver());
                 $imageName  =  $dir . '/' . $imageName;
                 $manager->read($image)->resize(300, 300)->save($imageName);
                 $image_names[] = $imageName;
             }
             $course_images = implode(",", $image_names);
         } else {
             $course_images = $course->course_images;
         }

         $course->course_images = $course_images;
        //  $course->course_added_by = LoggedAdmin()->id;
         $course->course_updated_by = LoggedAdmin()->id;

         $course->save();
         /** Course store end */
        //  $course_instructor = CourseInstructor::findOrFail($course->id);
        //  $course_instructor->instructor_id = $this->course_instructor;
        //  $course_instructor->file_link = $this->file_link;
        //  $course_instructor->save();
         

         
         /** Localization store start */
         $languages =  Language::where([['status', 1], ['delete', 0]])->get();
         foreach ($languages as $lang) {
             $course_name = $lang->lang != 'en' ? 'course_name_' . $lang->lang : 'course_name';
             $course_headline = $lang->lang != 'en' ? 'course_headline_' . $lang->lang : 'course_headline';
             $course_details = $lang->lang != 'en' ? 'course_details_' . $lang->lang : 'course_details';
             if ($this->$course_name != null) {
                Translation::updateOrInsert([
                    'translationable_type'  => 'App\Models\Admin\Course\Course',
                     'translationable_id'    => $course->id,
                     'locale'                => $lang->lang,
                     'key'                   => 'course_name',
                ],[
                    'value'                 => $this->$course_name,
                    'updated_at'            => Carbon::now(),
                ]);
             }
             if ($this->$course_headline != null) {
                Translation::updateOrInsert([
                    'translationable_type'  => 'App\Models\Admin\Course\Course',
                     'translationable_id'    => $course->id,
                     'locale'                => $lang->lang,
                     'key'                   => 'course_headline',
                ],[
                    'value'                 => $this->$course_headline,
                    'updated_at'            => Carbon::now(),
                ]);
             }
             if ($this->$course_details != null) {
                Translation::updateOrInsert([
                    'translationable_type'  => 'App\Models\Admin\Course\Course',
                     'translationable_id'    => $course->id,
                     'locale'                => $lang->lang,
                     'key'                   => 'course_details',
                ],[
                   'value'                 => $this->$course_details,
                    'updated_at'            => Carbon::now(),
                ]);
             }
             
         }
         /** Localization store end */
         return $course->id;
    }
}
