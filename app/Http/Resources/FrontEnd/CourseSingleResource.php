<?php

namespace App\Http\Resources\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class CourseSingleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $course = array_slice(parent::toArray($request),0,21);
        // dd($course);
        return [
            'name'=>$this->course_name,
            'course_name_slug'=>$this->course_name_slug,
            'category_id'=>DB::table('course_categories')->where('id',$this->category_id)->first(),
        ];
    }
}
