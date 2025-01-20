<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Course\CourseStoreRequest;
use App\Models\Admin\Course\Course;
use Illuminate\Http\Request;
use App\Models\Admin as Instructor;

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
        
        $courses = Course::where([['course_status',1],['course_delete',0]])->get();
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
        return view('backend.blade.course.create',compact('instructors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseStoreRequest $data)
    {
        dd($data->all());
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
}
