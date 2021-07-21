<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Traits\SendMail;
use App\Traits\SendSms;

class WishlistController extends Controller
{
   use SendMail; 
   use SendSms;
   public function add_to_wishlist(Request $request)
    {   
        $current = Carbon::now();
        $user_id= $request->user_id;
        $store_id = $request->store_id;
        $varient_id = $request->varient_id;
      
        $created_at = Carbon::now();
        $ph = DB::table('users')
                  ->select('user_phone','wallet')
                  ->where('id',$user_id)
                  ->first();
        $user_phone = $ph->user_phone;
        
    
        $p = DB::table('store_products')
             ->join('product_varient','store_products.varient_id','=','product_varient.varient_id')
            ->join('product','product_varient.product_id','=','product.product_id')
           ->Leftjoin('deal_product','product_varient.varient_id','=','deal_product.varient_id')
           ->where('store_products.varient_id',$varient_id)
           ->where('store_products.store_id',$store_id)
           ->first();
         if($p->deal_price != NULL &&  $p->valid_from < $current && $p->valid_to > $current){
          $price= $p->deal_price;    
        }else{
      $price = $p->price;
        } 
        
        $mrpprice = $p->mrp;
        $price2= $price;
        $price5=$mrpprice;
     
       $var_image = $p->varient_image;
        $n =$p->product_name;
      
        $check = DB::table('wishlist')
            ->where('varient_id',$varient_id)
            ->where('user_id', $user_id)
            ->where('store_id', $store_id)
            ->first();
      
     if(!$check){

        $insert = DB::table('wishlist')
                ->insert([
                        'store_id' => $store_id,
                        'varient_id'=>$varient_id,
                        'product_name'=>$n,
                        'varient_image'=>$var_image,
                        'quantity'=>$p->quantity,
                        'unit'=>$p->unit,
                        'mrp'=>$price5,'description'=>$p->description,
                        'user_id'=>$user_id,
                        'created_at'=>$created_at,
                        'updated_at'=>$created_at,
                        'price'=>$price2]);
                        
  if($insert){
      $count = DB::table('wishlist')
            ->where('user_id', $user_id)
            ->where('store_id', $store_id)
            ->count();
        	$message = array('status'=>'1', 'message'=>'Added to Wishlist', 'wishlist_count'=>$count);
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'Something Wents Wrong', 'data'=>[]);
        	return $message;
        }
      
     }
     else{
          $del = DB::table('wishlist')
            ->where('varient_id',$varient_id)
            ->where('user_id', $user_id)
            ->where('store_id', $store_id)
            ->delete();
            
         if($del){
          $count = DB::table('wishlist')
             ->where('user_id', $user_id)
             ->where('store_id', $store_id)
               ->count();
        	$message = array('status'=>'2', 'message'=>'Removed from Wishlist', 'wishlist_count'=>$count);
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'Something Wents Wrong', 'data'=>[]);
        	return $message;
        }  
         
     }

 }
 
  public function wishlist_to_cart(Request $request)
    {   
        $current = Carbon::now();
        $user_id= $request->user_id;
        $store_id = $request->store_id;
      
        $data_array = DB::table('wishlist')
              ->where('user_id', $user_id)
              ->where('store_id', $store_id)
              ->get();
        $price2=0;
        $price5=0;
        $ph = DB::table('users')
                  ->select('user_phone','wallet')
                  ->where('id',$user_id)
                  ->first();
        $user_phone = $ph->user_phone;
    foreach ($data_array as $h){
        $varient_id = $h->varient_id;
        $insert = DB::table('store_orders')
                ->insertGetId([
                        'store_id'=> $store_id,
                        'varient_id'=>$varient_id,
                        'qty'=>1,
                        'product_name'=>$h->product_name,
                        'varient_image'=>$h->varient_image,
                        'quantity'=>$h->quantity,
                        'unit'=>$h->unit,
                        'total_mrp'=>$h->mrp,
                        'store_approval'=>$user_id,
                        'order_cart_id'=>"incart",
                        'order_date'=>$current,
                        'price'=>$h->price, 'description'=>$h->description]);
      
 }
 
  if($insert){
          $delete = DB::table('wishlist')
                    ->where('user_id',$user_id)
                    ->where('store_id', $store_id)
                    ->delete();
                    
             $sum = DB::table('store_orders')
            ->where('store_approval',$user_id)
            ->where('order_cart_id', "incart")
            ->select(DB::raw('SUM(store_orders.price) as sum'))
            ->first();
            
            
              $checkitems = DB::table('store_orders')
                    ->where('store_approval',$user_id)
                    ->where('order_cart_id', "incart")
                    ->get();
                    
             if(count($checkitems)==0)  {
                 $checkitems = [];
             }    
             
             if(!$sum)  {
                 $sump= 0;
             }   
             else{
                 $sump = $sum->sum;
             }
      
      
        	$message = array('status'=>'1', 'message'=>'Added to cart', 'total_price'=>$sump, 'cart_items'=>$checkitems);
        	return $message;     
        }
        else{
        	$message = array('status'=>'0', 'message'=>'insertion failed', 'data'=>[]);
        	return $message;
        }
       
 }       
 
   public function show_wishlist(Request $request)
    { 
        $user_id= $request->user_id;
        $store_id= $request->store_id;
        if($store_id != NULL){
         $prodsssss = DB::table('wishlist')
                   ->join('store_products','wishlist.varient_id','=', 'store_products.varient_id')
                      ->join('product_varient','store_products.varient_id','=','product_varient.varient_id')
                    ->join('product','product_varient.product_id','=','product.product_id')
                   ->select('wishlist.*', 'store_products.stock', 'product.product_id')
                    ->where('wishlist.user_id',$user_id)
                    ->where('wishlist.store_id', $store_id)
                    ->get();
         
                    
        }else{
           $wishlist_items = DB::table('wishlist')
                    ->join('store_products','wishlist.varient_id','=', 'store_products.varient_id')
                      ->join('product_varient','store_products.varient_id','=','product_varient.varient_id')
                    ->join('product','product_varient.product_id','=','product.product_id')
                    ->select('wishlist.*', 'store_products.stock', 'product.product_id')
                    ->where('user_id',$user_id)
                    ->get(); 
        }
    $wishlist_item = $prodsssss->unique('varient_id'); 
         $wishlist_items = NULL;
        foreach($wishlist_item as $store)
        {
           
                $wishlist_items[] = $store; 
            
        }                        
        if($wishlist_items != NULL){
             $count = DB::table('wishlist')
            ->where('user_id', $user_id)
            ->where('store_id', $store_id)
            ->count();
            
            $message = array('status'=>'1', 'message'=>'Wishlist items','count'=>$count, 'data'=>$wishlist_items );
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'Nothing in Wishlist From This Location', 'data'=>[]);
        	return $message;
        }
        }

}