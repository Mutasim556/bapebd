<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Course\CourseStoreRequest;
use App\Http\Resources\Admin\Course\CourseResource;
use App\Models\Admin\Course\Course;
use Illuminate\Http\Request;
use App\Models\Admin as Instructor;
use App\Models\Admin\Course\CourseCategory;
use App\Models\Admin\Course\CourseSubCategory;

class CourseController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:course-index,admin');
        $this->middleware('permission:course-store,admin')->only('store');
        $this->middleware('permission:course-update,admin')->only(['edit','update','updateStatus']);
        $this->middleware('permission:course-delete,admin')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with('category','subCategory')->where([['course_status',1],['course_delete',0]])->get();
        return view('backend.blade.course.index',compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $instructors = Instructor::where([['delete','0']])->get();
        $instructors = $instructors->reject(function ($instructor, $key) {
            return $instructor->getRoleNames()->first()!='Instructor';
        });
        $categories = CourseCategory::where([['category_status',1],['category_delete',0]])->select('category_name','id')->get();
        return view('backend.blade.course.create',compact('instructors','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseStoreRequest $data)
    {
        $course = $data->store();
        if($course){
            return response([
                'title' => __('admin_local.Congratulations !'),
                'text' => __('admin_local.Course create successfully.'),
                'confirmButtonText' => __('admin_local.Ok'),
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(request()->ajax()){
            $course = Course::where([['course_status',1],['course_delete',0],['id',$id]])->select('id','course_type')->get();
            if($course->course_type=='Live'){
                $course = Course::with('batch')->where([['course_status',1],['course_delete',0],['id',$id]])->get();
            }else{
                $course = Course::with('category','subCategory')->where([['course_status',1],['course_delete',0],['id',$id]])->get();
            }
        }else{
            return redirect('admin/dashboard');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getSubCategories(){
        if(request()->ajax() && request()->category_id){
            return CourseSubCategory::where([['sub_category_status',1],['sub_category_delete',0],['category_id',request()->category_id]])->select('sub_category_name','id')->get();
        }
    }
}
