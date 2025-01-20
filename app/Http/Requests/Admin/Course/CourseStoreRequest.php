<?php

namespace App\Http\Requests\Admin\Course;

use Illuminate\Foundation\Http\FormRequest;

class CourseStoreRequest extends FormRequest
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
            'course_headline' => 'required',
            'course_details' => 'required',
            'course_type' => 'required',
            'no_of_videos' => 'required',
            'course_duration' => 'required',
            'course_duration_type' => 'required',
            'course_price' => 'required',
            'course_price_type' => 'required',
            'image' => 'required',
            'course_instructor'=>['required_if:course_type,Pre-recorded'],
            'video_group.*'=>['required_if:course_type,Pre-recorded'],
            'video_link.*'=>['required_if:course_type,Pre-recorded'],
            'video_title.*'=>['required_if:course_type,Pre-recorded'],
            'video_duration.*'=>['required_if:course_type,Pre-recorded'],
            'video_type.*'=>['required_if:course_type,Pre-recorded'],
        ];
    }

    public function messages(){
        return [
            'course_name.required' => __('admin_local.Course default name is required'),
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
            'video_link.*.required_if' => __('admin_local.Video link is required'),
            'video_title.*.required_if' => __('admin_local.Video title is required'),
            'video_duration.*.required_if' => __('admin_local.Video duration is required'),
            'video_type.*.required_if' => __('admin_local.Video type is required'),
        ];
    }
}
