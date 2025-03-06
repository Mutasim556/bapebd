<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Admin as Instructor;
use App\Models\Admin\AdminProfileDetails;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Spatie\Permission\Models\Role;

class InstructorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:instructor-index,admin'])->only('index');
        $this->middleware(['permission:instructor-create,admin'])->only('store');
        $this->middleware(['permission:instructor-update,admin'])->only(['edit','update','updateStatus']);
        $this->middleware(['permission:instructor-delete,admin'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $instructors = Instructor::where([['delete','0']])->get();
        $roles = Role::all();
        $instructors = $instructors->reject(function ($instructor, $key) {
            return $instructor->getRoleNames()->first()!='Instructor';
        });
        $roles = $roles->reject(function ($role, $key) {
            return $role->name!='Instructor';
        });
        return view('backend.blade.instructor.index',compact('instructors','roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $data) : Response
    {
        $data->validate([
            'instructor_name'=>'required',
            'instructor_email'=>'required|unique:admins,email',
            'instructor_phone'=>'required|unique:admins,phone',
            'instructorname'=>'required|unique:admins,username',
            'instructor_password'=>'required',
            'instructor_image'=>'required|mimes:jpg,jpeg,png',
            'designation'=>'required',
            'designation'=>'required',
        ]);
        $instructor = new Instructor();
        $instructor->name = $data->instructor_name;
        $instructor->email = $data->instructor_email;
        $instructor->phone = $data->instructor_phone;
        $instructor->username = $data->instructorname;
        $instructor->password = Hash::make($data->instructor_password);

        $dir = getDirectoryLink('admin/instructor');
        $makeDir = createDirectory($dir);
        if($data->instructor_image){
            $files = $data->instructor_image;
            $file =time().'.'.$files->getClientOriginalExtension();
            $file_name =  $dir.'/'.$file;
            // dd($file_name);
            $manager = new ImageManager(new Driver);
            $manager->read($data->instructor_image)->save($file_name);
        }else{
            $file_name = "";
        }
        $instructor->image = $file_name;
        $instructor->save();

        $instructor->assignRole('Instructor');

        $instructor_prof = new AdminProfileDetails();
        $instructor_prof->instructor_id = $instructor->id; 
        $instructor_prof->designation = $data->designation; 
        $instructor_prof->department = $data->department; 
        $instructor_prof->facebook = $data->facebook; 
        $instructor_prof->twitter = $data->twitter; 
        $instructor_prof->linkedin = $data->linkedin;
        $instructor_prof->save();
        // Mail::to($data->user_email)->send(new CreateUserMail($data->user_email,$data->user_password));

        if($instructor){
            $instructor = Instructor::where('id',$instructor->id)->first();
            return response([
                'instructor'=>$instructor,
                'role' => $instructor->getRoleNames()->first(),
                'title'=>__('admin_local.Congratulations !'),
                'text'=>__('admin_local.Instructor created successfully'),
                'confirmButtonText'=>__('admin_local.Ok'),
                'hasAnyPermission' => hasPermission(['instructor-update','instructor-delete']),
                'hasEditPermission' => hasPermission(['instructor-update']),
                'hasDeletePermission' => hasPermission(['instructor-delete']),
            ]);
        }else{
            return response()->json([
                'message'=>__('admin_local.Something went wrong.'),
                'title'=>__('admin_local.Warning !'),
                'confirmButtonText'=>__('admin_local.Ok'),
            ],422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) : Response
    {
        $instructor = Instructor::findOrFail($id);
        $instructor->instructor_prof = AdminProfileDetails::where('instructor_id',$id)->first();
        $role = $instructor->getRoleNames()->first();

        return response([
            'instructor'=>$instructor,
            'role'=>$role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $data, string $id) :Response
    {
        // dd($id);
        $data->validate([
            'instructor_name'=>'required',
            'instructor_email'=>'required|unique:admins,email,'.$id,
            'instructor_phone'=>'required|unique:admins,phone,'.$id,
            'instructorname'=>'required|unique:admins,username,'.$id,
            // 'instructor_password'=>'required',
            'instructor_image'=>'mimes:jpg,jpeg,png',
            'designation'=>'required',
            'designation'=>'required',
        ]);
        
        $instructor = Instructor::findOrFail($id);
        $instructor->name = $data->instructor_name;
        $instructor->email = $data->instructor_email;
        $instructor->phone = $data->instructor_phone;
        $instructor->username = $data->instructorname;
        if($data->instructor_password){
            $instructor->password = Hash::make($data->instructor_password);
        }
        $dir = getDirectoryLink('admin/instructor');
        $makeDir = createDirectory($dir);
        // dd($data->instructor_image);
        if($data->instructor_image){
            $files = $data->instructor_image;
            $file =time().'.'.$files->getClientOriginalExtension();
            $file_name =  $dir.'/'.$file;
            // dd($file_name);
            $manager = new ImageManager(new Driver);
            $manager->read($data->instructor_image)->resize(277,277)->save($file_name);
        }else{
            $file_name = $instructor->image;
        }
        $instructor->image = $file_name;
        $instructor->save();

        $instructor_prof = AdminProfileDetails::where([['instructor_id',$id]])->first()?AdminProfileDetails::where([['instructor_id',$id]])->first():new AdminProfileDetails();
        $instructor_prof->instructor_id = $instructor->id; 
        $instructor_prof->designation = $data->designation; 
        $instructor_prof->department = $data->department; 
        $instructor_prof->facebook = $data->facebook; 
        $instructor_prof->twitter = $data->twitter; 
        $instructor_prof->linkedin = $data->linkedin;
        $instructor_prof->save();
        return response([
            'instructor'=>$instructor,
            'role' => $instructor->getRoleNames()->first(),
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.User updated successfully'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id):Response
    {
        Instructor::where('id',$id)->update(['delete'=>1,'status'=>0,'updated_at'=>Carbon::now()]);
        return response([
            'message'=>'Deleted',
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.User removed successfully'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
    }

     
    public function updateStatus(string $id,string $status) 
    {
       
        try {
            $user = Instructor::findOrfail($id);
            $user->status = $status;
            $user->updated_at = Carbon::now();
            $user->save();
            return $user;
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => __('admin_local.Someting went wrong!')]);
        }
    }
}
