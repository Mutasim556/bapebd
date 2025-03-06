<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Resources\FrontEnd\CourseSingleResource;
use App\Models\Admin\Course\Course;
use App\Models\Admin\Course\CourseCategory;
use App\Models\Admin\Course\CourseVideo;
use Illuminate\Http\Request;
use App\Models\Admin as Instructor;
use App\Models\Admin\Course\CourseSubCategory;

class CourseController extends Controller
{
    public function viewCourse(string $slug=NULL){
        if($slug ){
            $course = Course::with('category','subCategory')->where([['course_status',1],['course_delete',0],['course_name_slug',$slug]])->first();
            return view('frontend.blade.courses.course_details',compact('course'));
        }
    }

    public function getVideoDetails(string $video){
        if(request()->ajax()){
            $video_id = decrypt($video);
            $video = CourseVideo::where([['id',$video_id]])->select('video_link')->first();
            // $youtube_link = '<iframe width="757" id="youtube_player" height="426" src="'.$video->video_link.'" title="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
            // dd($youtube_link);
            return $video;
        }
    }

    public function getAllCourses(Request $data){
        // dd($data->all());
        $courses = null;
        $url_slug = [];
        $instructors = Instructor::where([['status',1],['delete',0]])->get();
        $instructors = $instructors->reject(function ($instructor, $key) {
            return $instructor->getRoleNames()->first()!='Instructor';
        });
        if($data->type && $data->type=='category'){
            $category = CourseCategory::where([['category_slug',$data->slug]])->select('id')->first();
            $url_slug = [
                'category_slug'=>$data->slug,
                'sub_category_slug'=>'',
                'type'=>'',
                'instructor'=>'',
                'categories'=>'',
            ];
            $courses = Course::where([['course_status',1],['course_delete',0],['category_id',$category->id]])->get();
        }elseif($data->type && $data->type=='sub-category'){
            $sub_category = CourseSubCategory::with('category')->where([['sub_category_slug',$data->slug]])->first();
            $url_slug = [
                'category_slug'=>$sub_category->category->category_slug,
                'sub_category_slug'=>$data->slug,
                'type'=>'',
                'instructor'=>'',
                'categories'=>'',
            ];
            $courses = Course::where([['course_status',1],['course_delete',0],['sub_category_id',$sub_category->id]])->get();
        }else if(($data->type && $data->type=='view')){
            $url_slug = [
                'category_slug'=>'',
                'sub_category_slug'=>'',
                'type'=>'',
                'instructor'=>'',
                'categories'=>CourseCategory::where([['category_status',1],['category_delete',0]])->get(),
            ];
            $courses = Course::where([['course_status',1],['course_delete',0]])->get();
        }else if(($data->type && $data->type=='live')){
            $url_slug = [
                'category_slug'=>'',
                'sub_category_slug'=>'',
                'type'=>'live',
                'instructor'=>'',
                'categories'=>'',
            ];
            $courses = Course::where([['course_status',1],['course_delete',0],['course_type','Live']])->get();
        }else if(($data->type && $data->type=='pre-recorded')){
            $url_slug = [
                'category_slug'=>'',
                'sub_category_slug'=>'',
                'type'=>'pre-recorded',
                'instructor'=>'',
                'categories'=>'',
            ];
            $courses = Course::where([['course_status',1],['course_delete',0],['course_type','Pre-recorded']])->get();
        }
        // dd($courses);
        return view('frontend.blade.courses.courses',compact('courses','url_slug','instructors'));
    }
}
