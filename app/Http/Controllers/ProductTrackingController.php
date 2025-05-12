<?php

namespace App\Http\Controllers;

use App\Models\ProductTracking;
use Illuminate\Http\Request;

class ProductTrackingController extends Controller
{
  
    public function trackingStore(Request $request){
        
        $validate=$request->validate([
            'product_code'=>'required',
            'status'=>'required|in:انبار,درحال ارسال,ارسال شد,درحال تولید,آماده سازی',
            'note'=>'nullable'
            

        ]);
        ProductTracking::create($validate);
        return redirect()->back()->with('success', 'وضعیت محصول ثبت شد.');

    }
    public function createTracking(){
        return view('ProductTracking.create');
    }
    public function index(){
        $traking=ProductTracking::all();
        return view('ProductTracking.index',compact('traking'));


}
public function search(Request $request)
{
    $request->validate([
        'product_code' => 'required'
    ]);

    $tracking = ProductTracking::where('product_code', $request->product_code)->first();

    // یک متغیر برای فهمیدن اینکه کاربر سرچ کرده
    $searched = true;

    return view('ProductTracking.search', compact('tracking', 'searched'));
}

}

