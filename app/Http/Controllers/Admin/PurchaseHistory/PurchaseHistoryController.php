<?php

namespace App\Http\Controllers\Admin\PurchaseHistory;

use App\Http\Controllers\Controller;
use App\Models\FrontEnd\Purchase;
use App\Models\FrontEnd\PurchaseCourse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseHistoryController extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function index()
    {
        $purchases = Purchase::where([['delete',0]]);
        if(request()->start_date && request()->start_date){
             $purchases = $purchases->whereBetween('created_at',[date('Y-m-d',strtotime(request()->start_date)),date('Y-m-d',strtotime(request()->end_date))]);
        }
        if(isset(request()->payment_status)){
            $purchases = $purchases->where([['payment_status',request()->payment_status]]);
        }
         $purchases = $purchases->get();
        return view('backend.blade.purchase_history.index',compact('purchases'));
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
    public function store(Request $data)
    {
        $purchases = Purchase::whereBetween('created_at',[date('Y-m-d',strtotime($data->start_date)),date('Y-m-d',strtotime($data->end_date))])->where([['payment_status',$data->payment_status],['delete',0]])->get();

        foreach($purchases as $key=>$purchase){
            $purchases[$key]->create_date = date('Y-m-d',strtotime($purchase->created_at));
        }
        return response([
            'purchases'=>$purchases,
            'hasAnyPermission' => hasPermission(['course-category-update', 'course-category-delete']),
            'hasEditPermission' => hasPermission(['course-category-update']),
            'hasDeletePermission' => hasPermission(['course-category-delete']),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $purchases_courses = PurchaseCourse::with('course','batch')->where([['purchase_id',$id]])->get();
        return $purchases_courses;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
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

    public function changeStatus(Request $data){
        $purchases = Purchase::findOrFail(request()->id);
        $purchases->payment_status=request()->status;
        $purchases->updated_at=Carbon::now();
        $purchases->save();

        $purchaseCourse = PurchaseCourse::where('purchase_id',request()->id)->update([
            'status'=>request()->status,
        ]);
        return response($purchases);
    }
}
