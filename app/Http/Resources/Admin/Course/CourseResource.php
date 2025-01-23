<?php

namespace App\Http\Resources\Admin\Course;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($request);
        return [
            'course_name'=>$this->course_name,
            'course_headline'=>$this->course_headline,
            'course_details'=>$this->course_details,
            'no_of_videos'=>$this->no_of_videos,
            'course_name'=>$this->course_name,
            'course_name'=>$this->course_name,
            'course_name'=>$this->course_name,
            'course_name'=>$this->course_name,
            'course_name'=>$this->course_name,
            'course_name'=>$this->course_name,
            'course_name'=>$this->course_name,
            'course_name'=>$this->course_name,
        ];
    }
}
