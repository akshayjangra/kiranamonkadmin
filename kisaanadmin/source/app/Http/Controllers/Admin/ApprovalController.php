<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use App\Models\Admin;
use Auth;

class ApprovalController extends Controller
{
    public function storeclist(Request $request)
    {
         $title = "Home";
         $admin_email=Auth::guard('admin')->user()->email;
    	 $admin= DB::table('admin')
    	 		   ->where('email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        
        $city = DB::table('store')
                ->leftJoin('store_doc', 'store.id','=','store_doc.store_id')
                ->select('store.*','store_doc.document')
                ->where('store.admin_approval', 0)
                ->get();
                
        return view('admin.store.approval_wait', compact('title','city','admin','logo'));    
        
        
    }
    
    public function storeapproved(Request $request)
    {
  
        $store_id = $request->id;
         $store = DB::table('store')
                ->where('id',$store_id)
                ->update(['admin_approval'=>1]);
    if($store){   
    return redirect()->back()->withSuccess(trans('keywords.Store Approved Successfully'));
    }
    else{
      return redirect()->back()->withErrors(trans('keywords.Something Wents Wrong'));   
    }
    }
}