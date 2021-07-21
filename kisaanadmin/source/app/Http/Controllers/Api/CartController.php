<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Traits\SendMail;
use App\Traits\SendSms;

class CartController extends Controller
{
   use SendMail; 
   use SendSms;
   public function add_to_cart(Request $request)
    {   
        $current = Carbon::now();
        $user_id= $request->user_id;
        $qty = $request->qty;
        $store_id = $request->store_id;
        $varient_id = $request->varient_id;
        $order_status = "incart";
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $val = "";
                for ($i = 0; $i < 4; $i++){
                    $val .= $chars[mt_rand(0, strlen($chars)-1)];
                }
        $chars2 = "0123456789";
                $val2 = "";
                for ($i = 0; $i < 2; $i++){
                    $val2 .= $chars2[mt_rand(0, strlen($chars2)-1)];
                }    
                
        $cart_items = DB::table('store_orders')
                    ->where('store_approval',$user_id)
                    ->where('order_cart_id', 'incart')
                    ->first();
      
       if($cart_items){       
        $store_id1 = $cart_items->store_id; 
       
         if ($store_id != $store_id){
            $message = array('status'=>'2', 'message'=>'your previous cart items will be cleared when you are going to order from new store.');
        	return $message; 
            
        }else{
        $cr  = substr(md5(microtime()),rand(0,26),2);
        $cart_id = $val.$val2.$cr;
        $created_at = Carbon::now();
        $ph = DB::table('users')
                  ->select('user_phone','wallet')
                  ->where('id',$user_id)
                  ->first();
        if(!$ph){
            $message = array('status'=>'0', 'message'=>'User not Found');
        	return $message;
        }          
        $user_phone = $ph->user_phone;
        
    
        $p = DB::table('store_products')
             ->join('product_varient','store_products.varient_id','=','product_varient.varient_id')
            ->join('product','product_varient.product_id','=','product.product_id')
           ->where('store_products.varient_id',$varient_id)
           ->where('store_products.store_id',$store_id)
           ->first();
           
         $deal = DB::table('deal_product')
           ->where('varient_id',$varient_id)
           ->where('store_id',$store_id)
           ->first();   
           
         if($deal){
          $price= $deal->deal_price;    
        }else{
      $price = $p->price;
        } 
        
        $mrpprice = $p->mrp;
        $price2= $price*$qty;
        $price5=$mrpprice*$qty;
     
       $var_image = $p->product_image;
        $n =$p->product_name;
      
        $check = DB::table('store_orders')
            ->where('store_approval',$user_id)
            ->where('varient_id',$varient_id)
            ->where('order_cart_id', "incart")
            ->first();
      
     if(!$check){

        $insert = DB::table('store_orders')
                ->insert([
                        'store_id' => $store_id,
                        'varient_id'=>$varient_id,
                        'qty'=>$qty,
                        'product_name'=>$n,
                        'varient_image'=>$var_image,
                        'quantity'=>$p->quantity,
                        'unit'=>$p->unit,
                        'store_approval'=>$user_id,
                        'total_mrp'=>$price5,
                        'order_cart_id'=>"incart",
                        'order_date'=>$created_at,
                        'price'=>$price2,
                        'description'=>$p->description]);
      
     }
     else{
          $del = DB::table('store_orders')
            ->where('store_approval',$user_id)
            ->where('varient_id',$varient_id)
            ->where('order_cart_id', "incart")
            ->delete();
     
         $insert = DB::table('store_orders')
                ->insert([
                        'store_id' => $store_id,
                        'varient_id'=>$varient_id,
                        'qty'=>$qty,
                        'product_name'=>$n,
                        'varient_image'=>$var_image,
                        'quantity'=>$p->quantity,
                        'unit'=>$p->unit,
                        'store_approval'=>$user_id,
                        'total_mrp'=>$price5,
                        'order_cart_id'=>"incart",
                        'order_date'=>$created_at,
                        'price'=>$price2,
                        'description'=>$p->description]);
         
     }

   
 
  if($insert){
      $del = DB::table('store_orders')
            ->where('store_approval',$user_id)
            ->where('varient_id',$varient_id)
            ->where('qty', 0)
            ->delete();
      $sum = DB::table('store_orders')
            ->where('store_approval',$user_id)
            ->where('order_cart_id', "incart")
            ->select(DB::raw('SUM(store_orders.total_mrp) as mrp'),DB::raw('SUM(store_orders.price) as sum'))
            ->first();
            
            
      $checkitems = DB::table('store_orders')
            ->join('store_products', 'store_orders.varient_id','=','store_products.varient_id')
            ->join('product_varient','store_products.varient_id','=','product_varient.varient_id')
            ->join('product','product_varient.product_id','=','product.product_id')
           ->select('store_orders.product_name','store_orders.varient_image','store_orders.quantity','store_orders.unit','store_orders.price','store_orders.qty','store_orders.total_mrp','store_orders.order_cart_id','store_orders.order_date','store_orders.store_approval','store_orders.store_id','store_orders.varient_id','product.product_id', 'store_products.stock')
            ->groupBy('store_orders.product_name','store_orders.varient_image','store_orders.quantity','store_orders.unit','store_orders.price','store_orders.qty','store_orders.total_mrp','store_orders.order_cart_id','store_orders.order_date','store_orders.store_approval','store_orders.store_id','store_orders.varient_id','product.product_id', 'store_products.stock')
            ->where('store_products.store_id',$store_id)
            ->where('store_orders.store_approval',$user_id)
            ->where('store_orders.order_cart_id', "incart")
            ->get();
            
     if(count($checkitems)==0)  {
         $checkitems = [];
     }    
     
     if(!$sum)  {
         $mrpp = 0;
         $sump= 0;
     }   
     else{
          $mrpp = $sum->mrp;
         $sump = $sum->sum;
     }
     
      $delcharge=DB::table('freedeliverycart')
           ->where('store_id', $store_id)
           ->first();
  if($delcharge){         
if ($delcharge->min_cart_value <= $sump){
    $charge=0;
}  
else{
    $charge =$delcharge->del_charge;
}
  }else{
      $charge=0;
  }
      
        	$message = array('status'=>'1', 'message'=>'Added to cart', 'delivery_charge'=>$charge, 'total_price'=>$sump,'total_mrp'=>$mrpp, 'cart_items'=>$checkitems);
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'insertion failed', 'data'=>[]);
        	return $message;
        }
        
        }
       }
    else{
        $cr  = substr(md5(microtime()),rand(0,26),2);
        $cart_id = $val.$val2.$cr;
        $created_at = Carbon::now();
        $ph = DB::table('users')
                  ->select('user_phone','wallet')
                  ->where('id',$user_id)
                  ->first();
        if(!$ph){
            $message = array('status'=>'0', 'message'=>'User not Found');
        	return $message;
        }          
        $user_phone = $ph->user_phone;
        
    
        $p = DB::table('store_products')
             ->join('product_varient','store_products.varient_id','=','product_varient.varient_id')
            ->join('product','product_varient.product_id','=','product.product_id')
           ->Leftjoin('deal_product','product_varient.varient_id','=','deal_product.varient_id')
           ->where('store_products.varient_id',$varient_id)
           ->where('store_products.store_id',$store_id)
           ->first();
           
        $deal = DB::table('deal_product')
           ->where('varient_id',$varient_id)
           ->where('store_id',$store_id)
           ->first();   
           
         if($deal){
          $price= $deal->deal_price;    
        }else{
         $price = $p->price;
        } 
        
        $mrpprice = $p->mrp;
        $price2= $price*$qty;
        $price5=$mrpprice*$qty;
     
       $var_image = $p->product_image;
        $n =$p->product_name;
      
        $check = DB::table('store_orders')
            ->where('store_approval',$user_id)
            ->where('varient_id',$varient_id)
            ->where('order_cart_id', "incart")
            ->first();
      
     if(!$check){

        $insert = DB::table('store_orders')
                ->insert([
                        'store_id' => $store_id,
                        'varient_id'=>$varient_id,
                        'qty'=>$qty,
                        'product_name'=>$n,
                        'varient_image'=>$var_image,
                        'quantity'=>$p->quantity,
                        'unit'=>$p->unit,
                        'store_approval'=>$user_id,
                        'total_mrp'=>$price5,
                        'order_cart_id'=>"incart",
                        'order_date'=>$created_at,
                        'price'=>$price2,
                        'description'=>$p->description]);
      
     }
     else{
          $del = DB::table('store_orders')
            ->where('store_approval',$user_id)
            ->where('varient_id',$varient_id)
            ->where('order_cart_id', "incart")
            ->delete();
     
         $insert = DB::table('store_orders')
                ->insert([
                        'store_id' => $store_id,
                        'varient_id'=>$varient_id,
                        'qty'=>$qty,
                        'product_name'=>$n,
                        'varient_image'=>$var_image,
                        'quantity'=>$p->quantity,
                        'unit'=>$p->unit,
                        'store_approval'=>$user_id,
                        'total_mrp'=>$price5,
                        'order_cart_id'=>"incart",
                        'order_date'=>$created_at,
                        'price'=>$price2,
                        'description'=>$p->description]);
         
     }

   
 
  if($insert){
      $del = DB::table('store_orders')
            ->where('store_approval',$user_id)
            ->where('varient_id',$varient_id)
            ->where('qty', 0)
            ->delete();
      $sum = DB::table('store_orders')
            ->where('store_approval',$user_id)
            ->where('order_cart_id', "incart")
            ->select(DB::raw('SUM(store_orders.total_mrp) as mrp'),DB::raw('SUM(store_orders.price) as sum'))
            ->first();
            
            
      $checkitems = DB::table('store_orders')
             ->join('store_products', 'store_orders.varient_id','=','store_products.varient_id')
              ->join('product_varient','store_products.varient_id','=','product_varient.varient_id')
            ->join('product','product_varient.product_id','=','product.product_id')
           ->select('store_orders.product_name','store_orders.varient_image','store_orders.quantity','store_orders.unit','store_orders.price','store_orders.qty','store_orders.total_mrp','store_orders.order_cart_id','store_orders.order_date','store_orders.store_approval','store_orders.store_id','store_orders.varient_id','product.product_id', 'store_products.stock')
            ->groupBy('store_orders.product_name','store_orders.varient_image','store_orders.quantity','store_orders.unit','store_orders.price','store_orders.qty','store_orders.total_mrp','store_orders.order_cart_id','store_orders.order_date','store_orders.store_approval','store_orders.store_id','store_orders.varient_id','product.product_id', 'store_products.stock')
            ->where('store_products.store_id',$store_id)
            ->where('store_orders.store_approval',$user_id)
            ->where('store_orders.order_cart_id', "incart")
            ->get();
            
     if(count($checkitems)==0)  {
         $checkitems = [];
     }    
     
     if(!$sum)  {
         $mrpp = 0;
         $sump= 0;
     }   
     else{
          $mrpp = $sum->mrp;
         $sump = $sum->sum;
     }
     
      $delcharge=DB::table('freedeliverycart')
           ->where('store_id', $store_id)
           ->first();
           
  if($delcharge){         
if ($delcharge->min_cart_value <= $sump){
    $charge=0;
}  
else{
    $charge =$delcharge->del_charge;
}
  }else{
      $charge=0;
  }
      
      
        	$message = array('status'=>'1', 'message'=>'Added to cart', 'delivery_charge'=>$charge, 'total_price'=>$sump,'total_mrp'=>$mrpp, 'cart_items'=>$checkitems);
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'insertion failed', 'data'=>[]);
        	return $message;
        }
        
        }
 }
 
  public function make_an_order(Request $request)
    {   
        $current = Carbon::now();
        $user_id= $request->user_id;
        $delivery_date = $request-> delivery_date;
        $time_slot= $request->time_slot;
         $ordsssss = DB::table('orders')
             ->where('payment_method', NULL)
             ->where('user_id',$user_id)
             ->get();
         foreach($ordsssss as $ordt){
             DB::table('store_orders')
             ->where('order_cart_id', $ordt->cart_id)
             ->delete();
         } 
         $ordelete = DB::table('orders')
             ->where('payment_method', NULL)
             ->where('user_id',$user_id)
             ->delete();
         
             
        $store =  DB::table('store_orders')
              ->where('store_approval', $user_id)
              ->where('order_cart_id',"incart")
              ->first();
              
        $store_id = $store->store_id;
        $data_array = DB::table('store_orders')
              ->where('store_approval', $user_id)
              ->where('order_cart_id',"incart")
              ->get();
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $val = "";
                for ($i = 0; $i < 4; $i++){
                    $val .= $chars[mt_rand(0, strlen($chars)-1)];
                }
                
        $chars2 = "0123456789";
                $val2 = "";
                for ($i = 0; $i < 2; $i++){
                    $val2 .= $chars2[mt_rand(0, strlen($chars2)-1)];
                }        
        $cr  = substr(md5(microtime()),rand(0,26),2);
        $cart_id = $val.$val2.$cr;
        $ar= DB::table('address')
            ->select('society','city','lat','lng','address_id')
            ->where('user_id', $user_id)
            ->where('select_status', 1)
            ->first();
       if(!$ar){
           	$message = array('status'=>'0', 'message'=>'Select any Address');
        	return $message;
       }
        $created_at = Carbon::now();
        $price2=0;
        $price5=0;
        $pricecheck=0;
        $ph = DB::table('users')
                  ->select('user_phone','wallet')
                  ->where('id',$user_id)
                  ->first();
        $user_phone = $ph->user_phone;
      foreach ($data_array as $h){
        
        $varient_id = $h->varient_id;
        $p = DB::table('store_products')
             ->join('product_varient','store_products.varient_id','=','product_varient.varient_id')
            ->join('product','product_varient.product_id','=','product.product_id')
           ->Leftjoin('deal_product','product_varient.varient_id','=','deal_product.varient_id')
           ->where('store_products.varient_id',$varient_id)
           ->where('store_products.store_id',$store_id)
           ->first();

            $var_image= $p->product_image; 
      
        $deal = DB::table('deal_product')
           ->where('varient_id',$varient_id)
           ->where('store_id',$store_id)
           ->first();   
           
         if($deal){
          $price= $deal->deal_price;    
        }else{
      $price = $p->price;
        } 
       
        $mrpprice = $p->mrp;
        $order_qty = $h->qty;
        $pricecheck+= $price*$order_qty;
       
      }
      
      $min = DB::table('minimum_maximum_order_value')
           ->where('store_id', $store_id)
           ->first();
    if($min){       
       if($pricecheck<$min->min_value){
           $message = array('status'=>'0', 'message'=>'you have to order between '.$min->min_value.' to '.$min->max_value, 'data'=>[]);
        	return $message;
       }
        if($pricecheck>$min->max_value){
           $message = array('status'=>'0', 'message'=>'you have to order between '.$min->min_value.' to '.$min->max_value, 'data'=>[]);
        	return $message;
       }
    }
    foreach ($data_array as $h){
        
        $varient_id = $h->varient_id;
        $p = DB::table('store_products')
             ->join('product_varient','store_products.varient_id','=','product_varient.varient_id')
            ->join('product','product_varient.product_id','=','product.product_id')
           ->Leftjoin('deal_product','product_varient.varient_id','=','deal_product.varient_id')
           ->where('store_products.varient_id',$varient_id)
           ->where('store_products.store_id',$store_id)
           ->first();

            $var_image= $p->product_image; 
      
        $deal = DB::table('deal_product')
           ->where('varient_id',$varient_id)
           ->where('store_id',$store_id)
           ->first();   
           
         if($deal){
          $price= $deal->deal_price;    
        }else{
      $price = $p->price;
        } 
       
        $mrpprice = $p->mrp;
        $order_qty = $h->qty;
        $price2+= $price*$order_qty;
        $price5+=$mrpprice*$order_qty;
        $unit[] = $p->unit;
        $qty[]= $p->quantity;
        $p_name[] = $p->product_name."(".$p->quantity.$p->unit.")*".$order_qty;
        $prod_name = implode(',',$p_name);
        $n =$p->product_name;
       $total_mrp = $p->mrp*$order_qty;
        $price1 = $p->price*$order_qty;
        $insert = DB::table('store_orders')
                ->insertGetId([
                        'store_id'=> $store_id,
                        'varient_id'=>$varient_id,
                        'qty'=>$order_qty,
                        'product_name'=>$n,
                        'varient_image'=>$var_image,
                        'quantity'=>$p->quantity,
                        'unit'=>$p->unit,
                        'total_mrp'=>$total_mrp,
                        'order_cart_id'=>$cart_id,
                        'order_date'=>$created_at,
                        'price'=>$price1,
                        'description'=>$p->description]);
      
 }
 
 $delcharge=DB::table('freedeliverycart')
           ->where('store_id', $store_id)
           ->first();
           
  if($delcharge){         
if ($delcharge->min_cart_value <= $price2){
    $charge=0;
}  
else{
    $charge =$delcharge->del_charge;
}
  }else{
      $charge=0;
  }
  if($insert){
        $oo = DB::table('orders')
            ->insertGetId(['cart_id'=>$cart_id,
            'total_price'=>$price2 + $charge,
            'price_without_delivery'=>$price2,
            'total_products_mrp'=>$price5,
            'delivery_charge'=>$charge,
            'user_id'=>$user_id,
            'store_id'=>$store_id,
            'rem_price'=>$price2 + $charge,
            'order_date'=> $created_at,
            'delivery_date'=> $delivery_date,
            'time_slot'=>$time_slot,
            'address_id'=>$ar->address_id]); 
                    
           $ordersuccessed = DB::table('orders')
                           ->where('order_id',$oo)
                           ->first();
          
        	$message = array('status'=>'1', 'message'=>'Proceed to payment', 'data'=>$ordersuccessed );
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'insertion failed', 'data'=>[]);
        	return $message;
        }
       
 }       
 
   public function show_cart(Request $request)
    { 
        $user_id= $request->user_id;
        $cart_items = DB::table('store_orders')
                    ->where('store_approval',$user_id)
                    ->where('order_cart_id', 'incart')
                    ->get();
         
                        
        if(count($cart_items)>0){
             $sum = DB::table('store_orders')
            ->where('store_approval',$user_id)
            ->where('order_cart_id', "incart")
            ->select(DB::raw('SUM(store_orders.total_mrp) as mrp'),DB::raw('SUM(store_orders.price) as sum'),DB::raw('COUNT(store_orders.store_order_id) as count'))
            ->first();
            
            $store = DB::table('store_orders')
                    ->where('store_approval',$user_id)
                    ->where('order_cart_id', 'incart')
                    ->first();
        $cart_items1 = DB::table('store_orders')
                     ->join('store_products', 'store_orders.varient_id','=','store_products.varient_id')
                      ->join('product_varient','store_products.varient_id','=','product_varient.varient_id')
                    ->join('product','product_varient.product_id','=','product.product_id')
                   ->select('store_orders.product_name','store_orders.varient_image','store_orders.quantity','store_orders.unit','store_orders.price','store_orders.qty','store_orders.total_mrp','store_orders.order_cart_id','store_orders.order_date','store_orders.store_approval','store_orders.store_id','store_orders.varient_id','product.product_id', 'store_products.stock')
                   ->groupBy('store_orders.product_name','store_orders.varient_image','store_orders.quantity','store_orders.unit','store_orders.price','store_orders.qty','store_orders.total_mrp','store_orders.order_cart_id','store_orders.order_date','store_orders.store_approval','store_orders.store_id','store_orders.varient_id','product.product_id', 'store_products.stock')
                    ->where('store_products.store_id',$store->store_id)
                    ->where('store_orders.store_approval',$user_id)
                    ->where('store_orders.order_cart_id', 'incart')
                    ->get();
                    
            $nearbystore = DB::table('store')
                  ->where('id',$store->store_id)
                  ->first();
            $delcharge=DB::table('freedeliverycart')
           ->where('store_id', $store->store_id)
           ->first();
if($delcharge){         
if ($delcharge->min_cart_value <= $sum->sum){
    $charge=0;
}  
else{
    $charge =$delcharge->del_charge;
}
  }else{
      $charge=0;
  }
            
            $message = array('status'=>'1', 'message'=>'cart_items','delivery_charge'=>$charge,'total_price'=>$sum->sum,'total_mrp'=>$sum->mrp,'total_items'=>$sum->count,'store_details'=>$nearbystore, 'data'=>$cart_items1 );
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'insertion failed', 'data'=>[]);
        	return $message;
        }
        }
        
  public function del_frm_cart(Request $request)
    { 
        $user_id= $request->user_id;
        $store_id = $request->store_id;
        $varient_id = $request->varient_id;
        $cart_items = DB::table('store_orders')
                    ->where('store_approval',$user_id)
                    ->where('order_cart_id', 'incart')
                    ->where('varient_id', $varient_id)
                    ->delete();
         
                        
        if($cart_items){
            $cart_items2 = DB::table('store_orders')
                    ->where('store_approval',$user_id)
                    ->where('order_cart_id', 'incart')
                    ->get();
             $sum = DB::table('store_orders')
            ->where('store_approval',$user_id)
            ->where('order_cart_id', "incart")
            ->select(DB::raw('SUM(store_orders.price) as sum'),DB::raw('COUNT(store_orders.store_order_id) as count'))
            ->first();
            
              $delcharge=DB::table('freedeliverycart')
           ->where('store_id', $store_id)
           ->first();
           
             if($delcharge){         
if ($delcharge->min_cart_value <= $sum->sum){
    $charge=0;
}  
else{
    $charge =$delcharge->del_charge;
}
  }else{
      $charge=0;
  }
            $message = array('status'=>'1', 'message'=>'Product has been removed from cart','delivery_charge'=>$charge,'total_price'=>$sum->sum,'total_items'=>$sum->count, 'data'=>$cart_items2 );
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'insertion failed', 'data'=>[]);
        	return $message;
        }
        }      
        
   public function check_cart(Request $request)
    { 
        $user_id= $request->user_id;
        $store_id = $request->store_id;
        $cart_items = DB::table('store_orders')
                    ->where('store_approval',$user_id)
                    ->where('order_cart_id', 'incart')
                    ->get();
        if(count($cart_items)>0){
        $store =  DB::table('store_orders')
              ->where('store_approval', $user_id)
              ->where('order_cart_id',"incart")
              ->first();
              
        $store_id1 = $store->store_id;
    
        if ($store_id != $store_id){
            $message = array('status'=>'1', 'message'=>'your previous cart items will be cleared when you are going to order from new store.');
        	return $message; 
            
        }
        else{
             $message = array('status'=>'0', 'message'=>'enter to store');
        	return $message; 
        }
        }else{
              $message = array('status'=>'0', 'message'=>'enter to store');
        	return $message; 
        }
        }
        
        
     public function clear_cart(Request $request)
    { 
        $user_id= $request->user_id;
        $cart_items = DB::table('store_orders')
                    ->where('store_approval',$user_id)
                    ->where('order_cart_id', 'incart')
                    ->delete();
        
    
        if ($cart_items){
            $message = array('status'=>'1', 'message'=>'your cart has been cleared.');
        	return $message; 
            
        }
        else{
             $message = array('status'=>'0', 'message'=>'nothing in cart');
        	return $message; 
        }
        }    
         
 
}