<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;
use App\Traits\SendMail;
use App\Traits\SendSms;
use Auth;

class StoreordersController extends Controller
{
    use SendMail;
    use SendSms;
    
     public function store_com_orders(Request $request)
    {
         $title = trans('keywords.Completed Orders');
           $email=Auth::guard('store')->user()->email;
         $store= DB::table('store')
                   ->where('email',$email)
                   ->first();
          $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();  
                
        $ord =DB::table('orders')
             ->join('store','orders.store_id', '=', 'store.id')
             ->join('delivery_boy','orders.dboy_id', '=', 'delivery_boy.dboy_id')
             ->join('users', 'orders.user_id', '=','users.id')
             ->orderBy('orders.delivery_date','DESC')
             ->where('orders.store_id', $store->id)
             ->Where('order_status', 'Completed')
             ->get();
             
         $details  =   DB::table('orders')
    	                ->join('store_orders', 'orders.cart_id', '=', 'store_orders.order_cart_id') 
    	               ->where('store_orders.store_approval',1)
    	               ->get();         
                
       return view('store.all_orders.com_orders', compact('title','logo','ord','details','store'));         
    }
    
    
    
      public function store_can_orders(Request $request)
    {
         $title = trans('keywords.Cancelled Orders');
           $email=Auth::guard('store')->user()->email;
         $store= DB::table('store')
                   ->where('email',$email)
                   ->first();
          $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();  
                
        $ord =DB::table('orders')
             ->leftjoin('store','orders.store_id', '=', 'store.id')
             ->leftjoin('delivery_boy','orders.dboy_id', '=', 'delivery_boy.dboy_id')
             ->join('users', 'orders.user_id', '=','users.id')
             ->orderBy('orders.delivery_date','DESC')
             ->where('orders.store_id', $store->id)
             ->orWhere('order_status', 'Cancelled')
             ->get();
             
         $details  =   DB::table('orders')
    	                ->join('store_orders', 'orders.cart_id', '=', 'store_orders.order_cart_id')
    	               ->where('store_orders.store_approval',1)
    	               ->get();         
                
       return view('store.all_orders.cancelled', compact('title','logo','ord','details','store'));         
    }
    
    
      public function store_pen_orders(Request $request)
    {
         $title = trans('keywords.Pending Orders');
           $email=Auth::guard('store')->user()->email;
         $store= DB::table('store')
                   ->where('email',$email)
                   ->first();
          $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();  
                
                
        $ord =DB::table('orders')
             ->join('users', 'orders.user_id', '=','users.id')
             ->orderBy('orders.delivery_date','DESC')
             ->where('orders.order_status', 'Pending')
             ->where('orders.store_id', $store->id)
             ->get();
             
         $details  =   DB::table('orders')
    	                ->join('store_orders', 'orders.cart_id', '=', 'store_orders.order_cart_id') 
    	               ->where('store_orders.store_approval',1)
    	               ->get();         
                
       return view('store.all_orders.pending', compact('title','logo','ord','details','store'));         
    }
    

       public function store_dboy_orders(Request $request)
    {
         $title = "Delivery Boy Order section";
         $id = $request->id;
        
         $email=Auth::guard('store')->user()->email;
         $store= DB::table('store')
                   ->where('email',$email)
                   ->first();
        $logo = DB::table('tbl_web_setting')
                ->first();
            $dboy = DB::table('store_delivery_boy')
                ->where('dboy_id',$id)
                ->first();
          $date = date('Y-m-d');
     $nearbydboy = DB::table('store_delivery_boy')
                ->leftJoin('orders', 'store_delivery_boy.dboy_id', '=', 'orders.dboy_id') 
                ->select("store_delivery_boy.boy_name","store_delivery_boy.dboy_id","store_delivery_boy.lat","store_delivery_boy.lng","store_delivery_boy.boy_city",DB::raw("Count(orders.order_id)as count"),DB::raw("6371 * acos(cos(radians(".$dboy->lat . ")) 
                * cos(radians(store_delivery_boy.lat)) 
                * cos(radians(store_delivery_boy.lng) - radians(" . $dboy->lng . ")) 
                + sin(radians(" .$dboy->lat. ")) 
                * sin(radians(store_delivery_boy.lat))) AS distance"))
               ->groupBy("store_delivery_boy.boy_name","store_delivery_boy.dboy_id","store_delivery_boy.lat","store_delivery_boy.lng","store_delivery_boy.boy_city")
               ->where('store_delivery_boy.boy_city', $dboy->boy_city)
               ->where('store_delivery_boy.dboy_id','!=',$dboy->dboy_id)
               ->orderBy('count')
               ->orderBy('distance')
               ->get();  
    
                
        $ord =DB::table('orders')
             ->join('users', 'orders.user_id', '=','users.id')
             ->where('orders.dboy_id',$dboy->dboy_id)
             ->orderBy('orders.delivery_date','ASC')
             ->where('order_status','!=', 'completed')
             ->paginate(10);
             
         $details  =   DB::table('orders')
                     ->join('store_orders', 'orders.cart_id', '=', 'store_orders.order_cart_id') 
                     ->where('orders.dboy_id',$id)
                     ->where('store_orders.store_approval',1)
                     ->get();         
                
       return view('store.d_boy.orders', compact('title','logo','ord','dboy','details','store','nearbydboy'));         
    }
    
    
     
     public function missed_orders(Request $request)
    {
         $title = trans('keywords.Missed Orders');
         $email=Auth::guard('store')->user()->email;
         $store= DB::table('store')
                   ->where('email',$email)
                   ->first();
        $logo = DB::table('tbl_web_setting')
                ->first();
        $today = date('Y-m-d');  
        $day = 1;
        $next_date = date('Y-m-d', strtotime($today.' - '.$day.' days'));
        $ord =DB::table('orders')
             ->join('users', 'orders.user_id', '=','users.id')
             ->join('store','orders.store_id','=','store.id')
             ->leftJoin('delivery_boy','orders.dboy_id','=','delivery_boy.dboy_id')
             ->orderBy('orders.delivery_date','DESC')
             ->select('orders.*','users.*','store.*','delivery_boy.boy_name')
            ->where('orders.order_status', '!=','Completed')
            ->where('orders.order_status', '!=','Cancelled')
             ->where('orders.delivery_date','<',$today)
             ->where('orders.store_id',$store->id)
             ->where('orders.payment_method','!=', NULL)
             ->where('orders.store_id','!=', 0)
             ->get();
             
         $details  =   DB::table('orders')
    	                ->join('store_orders', 'orders.cart_id', '=', 'store_orders.order_cart_id') 
    	               ->where('store_orders.store_approval',1)
    	               ->get();  
    	               
    	               
    	 $delivery = DB::table('store_delivery_boy')
    	           ->where('store_id', $store->id)
    	           ->get();
                
       return view('store.all_orders.missed', compact('title','logo','ord','details','store','delivery'));         
    }
    
    
    public function change(Request $request)
    {
       $cart_id = $request->cart_id;
       
        $user = DB::table('orders')
              ->where('cart_id',$cart_id)
              ->first();
        $user_id1 = $user->user_id;
         $userwa1 = DB::table('users')
                     ->where('id',$user_id1)
                     ->first();
      $reason = 'Cancelled By Admin';
      $order_status = 'Cancelled';
      $updated_at = Carbon::now();
      $order = DB::table('orders')
                  ->where('cart_id', $cart_id)
                  ->update([
                        'cancelling_reason'=>$reason,
                        'order_status'=>$order_status,
                        'updated_at'=>$updated_at]);
      
       if($order){
        if($user->payment_method == 'COD' || $user->payment_method == 'Cod' || $user->payment_method == 'cod'){
            $newbal1 = $userwa1->wallet + $user->paid_by_wallet;  
            
            $userwalletupdate = DB::table('users')
             ->where('id',$user_id1)
             ->update(['wallet'=>$newbal1]);  
              }
          else{
              if($user->payment_status=='success'){
                  $newbal1 = $userwa1->wallet + $user->rem_price + $user->paid_by_wallet;
                  
                  $userwalletupdate = DB::table('users')
               ->where('id',$user_id1)
               ->update(['wallet'=>$newbal1]);  
              }
              else{
                   $newbal1 = $userwa1->wallet;    
              }
             }                 
           
        	 return redirect()->back()->withSuccess(trans('keywords.Updated Successfully'));
        }
        else{
         return redirect()->back()->withErrors(trans('keywords.Something Wents Wrong'));
        }
    }
    
    
    
    
       public function assigndboy(Request $request)
    {
         $date = date('Y-m-d');
         $day = 1;
         $next_date = date('Y-m-d', strtotime($date.' + '.$day.' days'));
         $cart_id=$request->id;
         $d_boy = $request->d_boy;
         $boy = DB::table('delivery_boy')
              ->where('dboy_id',$d_boy)
              ->first();
        $email=Auth::guard('store')->user()->email;
         $store= DB::table('store')
                   ->where('email',$email)
                   ->first();
        $logo = DB::table('tbl_web_setting')
                ->first();
      
          $ord =DB::table('orders')
             ->where('cart_id', $cart_id)
             ->update(['dboy_id'=>$d_boy, 'time_slot'=>'anytime','delivery_date'=>$next_date,'order_status'=>'Confirmed']);
             
      
      return redirect()->back()->withSuccess(trans('keywords.Assigned to').' '.$boy->boy_name.' '. trans('keywords.Successfully'));
    }
} 