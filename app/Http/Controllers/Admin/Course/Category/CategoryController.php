<?php

namespace App\Http\Controllers\Admin\Course\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Course\CategoryStoreRequest;
use App\Http\Requests\Admin\Course\CategoryUpdateRequest;
use App\Models\Admin\Course\CourseCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:course-category-index,admin');
        $this->middleware('permission:course-category-store,admin')->only('store');
        $this->middleware('permission:course-category-update,admin')->only(['edit','update','updateStatus']);
        $this->middleware('permission:course-category-delete,admin')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!app()->getLocale()){
          app()->setLocale('en');  
        }
        $categories = CourseCategory::with('admin')->where('category_delete',0)->get();
        
        return view('backend.blade.course.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $data):Response
    {
        $category_id = $data->store();
        return response([
            'category' => CourseCategory::with('admin')->findOrFail($category_id),
            'title' => __('admin_local.Congratulations !'),
            'text' => __('admin_local.Category create successfully.'),
            'confirmButtonText' => __('admin_local.Ok'),
            'hasAnyPermission' => hasPermission(['course-category-update', 'course-category-delete']),
            'hasEditPermission' => hasPermission(['course-category-update']),
            'hasDeletePermission' => hasPermission(['course-category-delete']),
        ], 200);
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
        // if(!app()->getLocale()){
        //     app()->setLocale('en');  
        // }
        $category = CourseCategory::withoutGlobalScope('translate')->findOrFail($id);
        // dd($category->category_name);
        return response($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $data, string $id)
    {
        if(request()->ajax() && $data->update($id)){
            return response()->json([
                'category' => CourseCategory::with('admin')->findOrFail($id),
                'title'=>__('admin_local.Congratulations !'),
                'text'=>__('admin_local.Category updated successfully.'),
                'confirmButtonText'=>__('admin_local.Ok'),
            ],200);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) :Response
    {
        $category = CourseCategory::findOrFail($id);
        $category->category_delete=1;
        $category->save();
        return response([
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Category deleted successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
    }

    public function updateStatus(Request $data){
        $category = CourseCategory::findOrFail($data->id);
        $category->category_status=$data->status;
        $category->updated_at=Carbon::now();
        $category->save();
        return response($category);
    }
}
