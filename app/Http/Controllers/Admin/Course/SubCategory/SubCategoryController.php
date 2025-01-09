<?php

namespace App\Http\Controllers\Admin\Course\SubCategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Course\SubCategoryStoreRequest;
use App\Http\Requests\Admin\Course\SubCategoryUpdateRequest;
use App\Models\Admin\Course\CourseCategory;
use App\Models\Admin\Course\CourseSubCategory;
use App\Models\Admin\Language;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:course-subcategory-index,admin');
        $this->middleware('permission:course-subcategory-store,admin')->only('store');
        $this->middleware('permission:course-subcategory-update,admin')->only(['edit','update','updateStatus']);
        $this->middleware('permission:course-subcategory-delete,admin')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CourseCategory::where('category_delete', 0)->get();
        $sub_categories = CourseSubCategory::where('sub_category_delete', 0)->get();
        return view('backend.blade.course.sub_category.index',compact('sub_categories','categories'));
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
    public function store(SubCategoryStoreRequest $data)
    {
        $langarr = [
            'translation'=>[
                'en' => ['title' => 'My first post'],
                'fr' => ['title' => 'Mon premier post'],
            ],
        ];
        // dd($langarr[translate('en')]);
        $sub_category_id = $data->store();
        return response([
            'sub_category' => CourseSubCategory::with('admin','category')->findOrFail($sub_category_id),
            'title' => __('admin_local.Congratulations !'),
            'text' => __('admin_local.Sub Category create successfully.'),
            'confirmButtonText' => __('admin_local.Ok'),
            'hasAnyPermission' => hasPermission(['course-subcategory-update', 'course-subcategory-delete']),
            'hasEditPermission' => hasPermission(['course-subcategory-update']),
            'hasDeletePermission' => hasPermission(['course-subcategory-delete']),
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
        $sub_category = CourseSubCategory::with('admin','category')->findOrFail($id);
        return response($sub_category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubCategoryUpdateRequest $data, string $id)
    {
        
        if($data->update($id)){
            return response([
                'sub_category' => CourseSubCategory::with('admin','category')->findOrFail($id),
                'title'=>__('admin_local.Congratulations !'),
                'text'=>__('admin_local.Sub Category updated successfully.'),
                'confirmButtonText'=>__('admin_local.Ok'),
            ],200);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sub_category = CourseSubCategory::findOrFail($id);
        $sub_category->sub_category_delete=1;
        $sub_category->save();
        return response([
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Sub Category deleted successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
    }

    public function updateStatus(Request $data){
        $sub_category = CourseSubCategory::findOrFail($data->id);
        $sub_category->sub_category_status=$data->status;
        $sub_category->updated_at=Carbon::now();
        $sub_category->save();
        return response($sub_category);
    }
}
