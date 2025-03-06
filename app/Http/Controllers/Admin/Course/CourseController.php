<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Course\CourseStoreRequest;
use App\Http\Requests\Admin\Course\CourseUpdateRequest;
use App\Http\Resources\Admin\Course\CourseResource;
use App\Models\Admin\Course\Course;
use Illuminate\Http\Request;
use App\Models\Admin as Instructor;
use App\Models\Admin\Course\CourseBatch;
use App\Models\Admin\Course\CourseCategory;
use App\Models\Admin\Course\CourseInstructor;
use App\Models\Admin\Course\CourseSubCategory;
use App\Models\Admin\Course\CourseVideo;
use Carbon\Carbon;

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
        $courses = Course::with('category','subCategory')->where([['course_delete',0]])->get();
        $instructors = Instructor::where([['delete','0']])->get();
        $instructors = $instructors->reject(function ($instructor, $key) {
            return $instructor->getRoleNames()->first()!='Instructor';
        });
        return view('backend.blade.course.index',compact('courses','instructors'));
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
            $course = Course::where([['course_delete',0],['id',$id]])->select('id','course_type')->first();
            if($course->course_type=='Live'){
                $batches = CourseBatch::with('instructor')->where([['batch_delete',0],['course_id',$id]])->get();
                // dd($batches);
                foreach($batches as $key=>$batch){
                    $batches[$key]->batch_start_date = date('d-M-Y',strtotime($batch->batch_start_date));
                    $batches[$key]->batch_end_date = date('d-M-Y',strtotime($batch->batch_end_date));
                    $batches[$key]->batch_time = date('h:i a',strtotime($batch->batch_time));
                }
                // dd($batches);
                return [
                    'batches'=>$batches,
                    'type'=>'Live',
                    'hasAnyPermission' => hasPermission(['course-batch-update', 'course-batch-delete']),
                    'hasEditPermission' => hasPermission(['course-batch-update']),
                    'hasDeletePermission' => hasPermission(['course-batch-delete']),
                ];
            }else{
                $videos = CourseVideo::with('instructor')->where([['video_delete',0],['course_id',$id]])->orderBy('video_no')->get();
                foreach($videos as $key=>$video){
                    $videos[$key]->created_at = date('d-M-Y',strtotime($video->created_at));
                    $videos[$key]->updated_at = date('d-M-Y',strtotime($video->updated_at));
                }
                return [
                    'videos'=>$videos,
                    'type'=>'Pre-recorded',
                    'hasAnyPermission' => hasPermission(['course-batch-update', 'course-batch-delete']),
                    'hasEditPermission' => hasPermission(['course-batch-update']),
                    'hasDeletePermission' => hasPermission(['course-batch-delete']),
                ];
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
        $instructors = Instructor::where([['delete','0']])->get();
        $instructors = $instructors->reject(function ($instructor, $key) {
            return $instructor->getRoleNames()->first()!='Instructor';
        });
        $categories = CourseCategory::where([['category_status',1],['category_delete',0]])->select('category_name','id')->get();
        $course = Course::withoutGlobalScope('translate')
        ->where('id',$id)
        ->with('courseInstructor')
        ->first();
        // dd($course);
        $sub_categories = CourseSubCategory::where([['sub_category_status',1],['sub_category_delete',0]])->select('sub_category_name','id')->get();
        return view('backend.blade.course.edit',compact('instructors','categories','course','sub_categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseUpdateRequest $data, string $id)
    {
        $course = $data->update($id);
        if($course){
            return response([
                'title' => __('admin_local.Congratulations !'),
                'text' => __('admin_local.Course updated successfully.'),
                'confirmButtonText' => __('admin_local.Ok'),
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->course_delete=1;
        $course->updated_at=Carbon::now();
        $course->save();
        return response([
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Course deleted successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
    }

    public function liveDestroy(string $id)
    {
        $course_batch = CourseBatch::findOrFail($id);
        $course_batch->batch_delete=1;
        $course_batch->updated_at=Carbon::now();
        $course_batch->save();
        return response([
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Batch deleted successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
    }

    public function recordedDestroy(string $id){
        $course_video = CourseVideo::findOrFail($id);
        $course_video->video_delete=1;
        $course_video->updated_at=Carbon::now();
        $course_video->save();
        return response([
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Video deleted successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
    }

    public function getSubCategories(){
        if(request()->ajax() && request()->category_id){
            return CourseSubCategory::where([['sub_category_status',1],['sub_category_delete',0],['category_id',request()->category_id]])->select('sub_category_name','id')->get();
        }
    }

    public function updateStatus(Request $data){
        $course = Course::findOrFail($data->id);
        $course->course_status=$data->status;
        $course->updated_at=Carbon::now();
        $course->save();
        return response($course);
    }

    public function liveBatchStatus(Request $data){
        $course_batch = CourseBatch::findOrFail($data->id);
        $course_batch->batch_status=$data->status;
        $course_batch->updated_at=Carbon::now();
        $course_batch->save();
        return response($course_batch);
    }

    public function recordedStatus(Request $data){
        $course_video = CourseVideo::findOrFail($data->id);
        $course_video->video_status=$data->status;
        $course_video->updated_at=Carbon::now();
        $course_video->save();
        return response($course_video);
    }

    public function recordedEdit(string $id){
        $course_video = CourseVideo::where([['id',$id]])->first();
        return $course_video;
    }


    public function recordedUpdate(Request $data,string $id) {
        $data->validate([
            'video_no'=>'required',
            'video_group'=>'required',
            'video_title'=>'required',
            'video_link'=>'required',
            'video_duration'=>'required',
            'video_type'=>'required',
        ],[
            'video_no.required'=>__('admin_local.Video no is required'),
            'video_group.required'=>__('admin_local.Video group is required'),
            'video_title.required'=>__('admin_local.Video title is required'),
            'video_link.required'=>__('admin_local.Video link is required'),
            'video_duration.required'=>__('admin_local.Video duration is required'),
            'video_type.required'=>__('admin_local.Video type is required'),
        ]);
        $update = CourseVideo::findOrFail($id);
        $update->video_no = $data->video_no;
        $update->video_group = $data->video_group;
        $update->video_title = $data->video_title;
        $update->video_link = $data->video_link;
        $update->video_duration = $data->video_duration;
        $update->video_type = $data->video_type;

        $dir = getDirectoryLink('course/course-files');
        $makeDir = createDirectory($dir);
        if($data->video_file){
            $file = $data->video_file;
            $fileName = "COURSE_VIDEO_FILE_".$id.'_UPDATED_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($dir,$fileName);
            $fileName = $dir.'/'.$fileName;
        }else{
            $fileName = $update->videos_file;
        }

        $update->videos_file = $fileName;

        $update->save();

       return response([
            'course'=>$update,
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Video updated successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
    }

    public function liveEdit(string $id){
        $course_batch = CourseBatch::where([['id',$id]])->first();
        return $course_batch;
    }

    public function liveUpdate(Request $data,string $id){
        $data->validate([
            'batch_name'=>'required',
            'batch_code'=>'required|unique:course_batches,batch_code,'.$id,
            'batch_instructor'=>'required',
            'batch_start_date'=>'required',
            'batch_end_date'=>'required',
            'batch_time'=>'required',
            'enroll_limit'=>'required',
            'live_in'=>'required',
            'link_or_address'=>'required',
            'batch_day'=>'required',
        ],[
            'batch_name.required'=>__('admin_local.Batch name is required'),
            'batch_code.required'=>__('admin_local.Batch code is required'),
            'batch_code.unique'=>__('admin_local.Batch name already taken'),
            'batch_instructor.required'=>__('admin_local.Batch instructor is required'),
            'batch_start_date.required'=>__('admin_local.Batch start date is required'),
            'batch_end_date.required'=>__('admin_local.Batch end date is required'),
            'batch_instructor.required'=>__('admin_local.Batch instructor is required'),
            'batch_instructor.required'=>__('admin_local.Batch instructor is required'),
            'batch_instructor.required'=>__('admin_local.Batch instructor is required'),
            'batch_day.required'=>__('admin_local.Link/Address type is required'),
        ]);

        $update = CourseBatch::findOrFail($id);
        $update->batch_name = $data->batch_name;
        $update->batch_code = $data->batch_code;
        $update->batch_instructor = $data->batch_instructor;
        $update->batch_start_date = $data->batch_start_date;
        $update->batch_end_date = $data->batch_end_date;
        $update->batch_time = $data->batch_time;
        $update->enroll_limit = $data->enroll_limit;
        $update->link_or_address = $data->link_or_address;
        $update->batch_day = implode(',',$data->batch_day);
        $update->updated_at = Carbon::now();
        $update->save();
        $coursei = CourseInstructor::where([['course_id',$update->course_id],['batch_id',$id]])->first();
        $coursei->instructor_id = $data->batch_instructor;
        $coursei->save();
        $batch = CourseBatch::with('instructor')->where([['id',$id]])->first();
        $batch->batch_start_date = date('d-M-Y',strtotime($batch->batch_start_date));
        $batch->batch_end_date = date('d-M-Y',strtotime($batch->batch_end_date));
        $batch->batch_time = date('h:i a',strtotime($batch->batch_time));
        return response([
            'batch'=>$batch,
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Batch data updated successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
    }


    public function videoUpload(Request $data){
        
        $data->validate([
            'video_no'=>'required',
            'video_group'=>'required',
            'video_title'=>'required',
            // 'video_file'=>'required',
            'video_link'=>'required',
            'video_duration'=>'required',
            'video_type'=>'required',
        ],[
            'video_no.required'=>__('admin_local.Video No is required'),
            'video_group.required'=>__('admin_local.Video group is required'),
            'video_title.required'=>__('admin_local.Video title is required'),
            'video_file.required'=>__('admin_local.Video file is required'),
            'video_link.required'=>__('admin_local.Video link is required'),
            'video_duration.required'=>__('admin_local.Video duration is required'),
            'video_type.required'=>__('admin_local.Video type is required'),
        ]);


        $video = new CourseVideo();
        $video->course_id = $data->course_id;
        $video->video_group = $data->video_group;
        $video->video_no = $data->video_no;
        $video->video_link = $data->video_link;
        $video->video_title = $data->video_title;
        $video->video_duration = $data->video_duration;
        $video->video_type = $data->video_type;
        $dir = getDirectoryLink('course/course-files');
        $makeDir = createDirectory($dir);
        if($data->video_file){
            $file = $data->video_file;
            $fileName = "COURSE_VIDEO_FILE_".$data->course_id.'_1_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($dir,$fileName);
            $fileName = $dir.'/'.$fileName;
        }else{
            $fileName = null;
        }
        $video->videos_file = $fileName;
        $video->admin_id = LoggedAdmin()->id;
        $video->save();
        return response([
            'video' => CourseVideo::findOrFail($video->id),
            'title' => __('admin_local.Congratulations !'),
            'text' => __('admin_local.Video added successfully.'),
            'confirmButtonText' => __('admin_local.Ok'),
            'hasAnyPermission' => hasPermission(['course-video-update', 'course-video-delete']),
            'hasEditPermission' => hasPermission(['course-video-update']),
            'hasDeletePermission' => hasPermission(['course-video-delete']),
        ], 200);
    }

    public function batchUpload(Request $data){
        $data->validate([
            'batch_name'=>'required',
            'batch_code'=>'required|unique:course_batches,batch_code,'.$data->course_id,
            'batch_instructor'=>'required',
            'batch_start_date'=>'required',
            'batch_end_date'=>'required',
            'batch_time'=>'required',
            'live_in'=>'required',
            'link_or_address'=>'required',
            'batch_day'=>'required',
        ],[
            'batch_name.required'=>__('admin_local.Batch Name is required'),
            'batch_code.required'=>__('admin_local.Batch Code is required'),
            'batch_code.unique'=>__('admin_local.Batch Code must be unique'),
            'batch_instructor.required'=>__('admin_local.Batch Instructor is required'),
            'batch_start_date.required'=>__('admin_local.Start date is required'),
            'batch_end_date.required'=>__('admin_local.End Date file is required'),
            'batch_time.required'=>__('admin_local.Batch Time link is required'),
            'live_in.required'=>__('admin_local.Live In is required'),
            'link_or_address.required'=>__('admin_local.Link/Address type is required'),
            'batch_day.required'=>__('admin_local.Link/Address type is required'),
        ]);

        $prev_batch = CourseBatch::where([['course_id',$data->course_id]])->orderBy('id','DESC')->first();

        $batch = new CourseBatch();
        $batch->course_id = $data->course_id;
        $batch->batch_name = $data->batch_name;
        $batch->batch_code = $data->batch_code;
        $batch->batch_number = $prev_batch->batch_number+1;
        $batch->batch_instructor = $data->batch_instructor;
        $batch->batch_start_date = $data->batch_start_date;
        $batch->batch_end_date = $data->batch_end_date;
        $batch->batch_time = $data->batch_time;
        $batch->enroll_limit = $data->enroll_limit;
        $batch->enrolled_count = 0;
        $batch->live_in = $data->live_in;
        $batch->link_or_address = $data->link_or_address;
        $batch->batch_day = implode(',',$data->batch_day);
        $batch->batch_added_by = LoggedAdmin()->id;
        $batch->batch_updated_by = LoggedAdmin()->id;

        $batch->save();

        $batches = CourseBatch::with('instructor')->where([['batch_delete',0],['id',$batch->id]])->first();
        $batches->batch_start_date = date('d-M-Y',strtotime($batch->batch_start_date));
        $batches->batch_end_date = date('d-M-Y',strtotime($batch->batch_end_date));
        $batches->batch_time = date('h:i a',strtotime($batch->batch_time));

        return response([
            'batch' =>  $batches,
            'title' => __('admin_local.Congratulations !'),
            'text' => __('admin_local.Batch created successfully.'),
            'confirmButtonText' => __('admin_local.Ok'),
            'hasAnyPermission' => hasPermission(['course-batch-update', 'course-batch-delete']),
            'hasEditPermission' => hasPermission(['course-batch-update']),
            'hasDeletePermission' => hasPermission(['course-batch-delete']),
        ], 200);
    }
}
