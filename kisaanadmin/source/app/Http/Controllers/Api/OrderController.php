<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Traits\SendMail;
use App\Traits\SendSms;
use App\Traits\SendInapp;
use App\Setting;
use Razorpay\Api\Api;
use PayPal\Api\Amount;
use PayPal\Api\Refund;
use PayPal\Api\RefundRequest;
use PayPal\Api\Sale;

class OrderController extends Controller
{
   use SendMail; 
   use SendSms;
   use SendInapp;
 public function checkout(Request $request)
    { 
        $cart_id=$request->cart_id;
        $payment_method= $request->payment_method;
        $payment_status = $request->payment_status;
        $wallet = $request->wallet;
          $payment_id = $request->payment_id;
            $payment_gateway = $request->payment_gateway;
        $orderr = DB::table('orders')
           ->where('cart_id', $cart_id)
           ->first(); 
           
         $cart =  DB::table('orders')
           ->where('cart_id', $cart_id)
           ->first();   
        $store_id = $cart->store_id;  
         $getD = DB::table('store')
                         ->where('id', $store_id)
                        ->first();
                        
       $store_n = $getD->store_name; 
        $user_id= $orderr->user_id;   
        $delivery_date = $orderr->delivery_date;
        $time_slot= $orderr->time_slot;
        
        $var= DB::table('store_orders')
           ->where('order_cart_id', $cart_id)
           ->get();
        $price2 = $orderr->rem_price;
        $ph = DB::table('users')
                  ->select('name','user_phone','wallet')
                  ->where('id',$user_id)
                  ->first();
        $user_phone = $ph->user_phone;  
        $user_name = $ph->name;
        foreach ($var as $h){
        $varient_id = $h->varient_id;
        $p = DB::table('store_orders')
           ->where('order_cart_id',$cart_id)
           ->where('varient_id',$varient_id)
           ->first();
        $price = $p->price;   
        $order_qty = $h->qty;
        $unit[] = $p->unit;
        $qty[]= $p->quantity;
        $p_name[] = $p->product_name."(".$p->quantity.$p->unit.")*".$order_qty;
        $prod_name = implode(',',$p_name);
        }
         $charge = 0;
         $prii = $price2;
        if ($payment_method == 'COD' || $payment_method =='cod'){
             $walletamt = 0;    
            
             $payment_status="COD";
            if($wallet == 'yes' || $wallet == 'Yes' || $wallet == 'YES'){
             if($ph->wallet >= $prii){
                $rem_amount = 0; 
                $walletamt = $prii; 
                $rem_wallet = $ph->wallet-$prii;
                $walupdate = DB::table('users')
                           ->where('id',$user_id)
                           ->update(['wallet'=>$rem_wallet]);
                $payment_status="success";           
                $payment_method = "wallet";   
                $payment_id = $cart_id;
                $payment_gateway = "wallet";
             }
             else{
                
                $rem_amount= $prii - $ph->wallet;
                $walletamt = $ph->wallet;
                $rem_wallet = 0;
                $walupdate = DB::table('users')
                           ->where('id',$user_id)
                           ->update(['wallet'=>$rem_wallet]);
             }
         }
         else{
             $rem_amount=  $prii;
             $walletamt= 0;
         }
       
          $oo = DB::table('orders')
           ->where('cart_id',$cart_id)
            ->update([
            'paid_by_wallet'=>$walletamt,
            'rem_price'=>$rem_amount,
            'payment_status'=>$payment_status,
            'payment_method'=>$payment_method
            ]); 
             
            $sms = DB::table('notificationby')
                       ->select('sms')
                       ->where('user_id',$user_id)
                       ->first();
            $sms_status = $sms->sms;
            
                if($sms_status == 1){
                    $orderplacedmsg = $this->ordersuccessfull($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_phone);
                    
            
                }
                
                
                
                
                
                      /////send mail
            $email = DB::table('notificationby')
                   ->select('email','app')
                   ->where('user_id',$user_id)
                   ->first();
             $q = DB::table('users')
                              ->select('email','name','device_id')
                              ->where('id',$user_id)
                              ->first();
            $user_email = $q->email;             
            $device_id = $q->device_id;     
            $user_name = $q->name;       
            $email_status = $email->email;       
            if($email_status == 1){
                   
                    $codorderplaced = $this->codorderplacedMail($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_email,$user_name);
                    
                    
               }
               
            
      
               
                 ///////send notification to User//////
             if($email->app ==1){
                 
                  $codorderplaced = $this->codorderplacedinapp($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_email,$user_name,$user_id,$device_id);
                    
                     
                 
             }  
                $orderr1 = DB::table('orders')
                       ->where('cart_id', $cart_id)
                       ->first();   
           
                ///////send notification to store//////
                $getD = DB::table('store')
                         ->where('id', $store_id)
                        ->first();
                        
                $store_n = $getD->store_name; 
             if($getD){
               
                   $store_phone = $getD->phone_number;
                   $store_email = $getD->email;
                     $orderplacedmsgstore = $this->ordersuccessfullstore($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$store_phone);
                     $codorderplacedstore = $this->codorderplacedMailstore($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_email,$user_name, $store_n,$store_email);
                     
                      $codorderplacedstore = $this->codorderplacedinappstore($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_email,$user_name,$store_n,$store_id);
                 }
         $admin = DB::table('admin')
                ->first();
          $admin_email = $admin->email;
          $admin_name = $admin->name;
             $codorderplacedadmin = $this->codorderplacedMailadmin($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_email,$user_name,$store_n,$admin_email,$admin_name); 
               
                               
            $delete = DB::table('store_orders')
                           ->where('store_approval',$user_id)
                           ->where('order_cart_id', 'incart')
                           ->delete();
            $message = array('status'=>'1', 'message'=>'Order Placed successfully', 'data'=>$orderr1 );
        	return $message;   
        }
       
        else{
        $walletamt = 0;    
        $prii = $price2 + $charge;
        if($request->wallet == 'yes' || $request->wallet == 'Yes' || $request->wallet == 'YES'){
             if($ph->wallet >= $prii){
                $rem_amount = 0; 
                $walletamt = $prii; 
                $rem_wallet = $ph->wallet - $prii;
                $walupdate = DB::table('users')
                           ->where('id',$user_id)
                           ->update(['wallet'=>$rem_wallet]);
                $payment_status="success";           
                $payment_method = "wallet";
                $payment_id =$cart_id;
                $payment_gateway = "wallet";
                
             }
             else{
                 
                $rem_amount=  $prii-$ph->wallet;
                $walletamt = $ph->wallet;
                $rem_wallet =0;
                $walupdate = DB::table('users')
                           ->where('id',$user_id)
                           ->update(['wallet'=>$rem_wallet]);
             }
         }
          else{
              $rem_amount=  $prii;
              $walletamt = 0;
          }
        if($payment_status=='success'){
            
          
            $oo = DB::table('orders')
           ->where('cart_id',$cart_id)
            ->update([
            'paid_by_wallet'=>$walletamt,
            'rem_price'=>$rem_amount,
            'payment_method'=>$payment_method,
            'payment_status'=>'success'
            ]); 
            
         $payments = DB::table('cart_payments')
            ->insert([
            'cart_id'=>$cart_id,
            'amount'=>$rem_amount,
            'payment_gateway'=>$payment_gateway,
            'payment_id'=>$payment_id,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
            ]); 
            
            $sms = DB::table('notificationby')
                       ->select('sms')
                       ->where('user_id',$user_id)
                       ->first();
            $sms_status = $sms->sms;
                if($sms_status == 1){
                    
                /////send sms/////    
                $codorderplaced = $this->ordersuccessfull($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_phone);
                }
                      /////send mail
            $email = DB::table('notificationby')
                   ->select('email','app')
                   ->where('user_id',$user_id)
                   ->first();
            $email_status = $email->email;
             $q = DB::table('users')
                  ->select('email','name')
                  ->where('id',$user_id)
                  ->first();
            $user_email = $q->email;     
            $user_name = $q->name;
            if($email_status == 1){
                   
                     ///sending mails//    
                    $orderplaced = $this->orderplacedMail($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_email,$user_name);
                 
               }
            if($email->app == 1){
                 ///////send notification to User//////
                 $codorderplaced = $this->codorderplacedinapp($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_email,$user_name,$user_id);
                
                 
             } 
            $orderr1 = DB::table('orders')
           ->where('cart_id', $cart_id)
           ->first();
           
              ///////send notification to store//////
                $getD = DB::table('store')
                         ->where('id', $store_id)
                        ->first();
                        
                $store_n = $getD->store_name;   
                
                
               
                                
            $delete = DB::table('store_orders')
                           ->where('store_approval',$user_id)
                           ->where('order_cart_id', 'incart')
                           ->delete();
    
    
             if($getD){
               
                   $store_phone = $getD->phone_number;
                   $store_email = $getD->email;
                     $orderplacedmsgstore = $this->ordersuccessfullstore($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$store_phone);
                     $codorderplacedstore = $this->codorderplacedMailstore($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_email,$user_name, $store_n,$store_email);
                     
                      $codorderplacedstore = $this->codorderplacedinappstore($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_email,$user_name,$store_n,$store_id);
                 }
         $admin = DB::table('admin')
                ->first();
          $admin_email = $admin->email;
          $admin_name = $admin->name;
             $codorderplacedadmin = $this->codorderplacedMailadmin($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_email,$user_name,$store_n,$admin_email,$admin_name); 
            $message = array('status'=>'2', 'message'=>'Order Placed successfully', 'data'=>$orderr1 );
        	return $message; 
         }
         else{
              $oo = DB::table('orders')
           ->where('cart_id',$cart_id)
            ->update([
            'paid_by_wallet'=>0,
            'rem_price'=>$rem_amount,
            'payment_method'=>NULL,
            'payment_status'=>'failed'
            ]);  
        	$message = array('status'=>'0', 'message'=>'Payment Failed');
        	return $message;
         }
      }
    }       
           








     
 
  public function ongoing(Request $request)
    {
      $user_id = $request->user_id;
      $ongoing = DB::table('orders')
            ->join('store','orders.store_id','=','store.id')
            ->join('users','orders.user_id','=','users.id')
             ->join('address','orders.address_id','=','address.address_id')
             ->leftJoin('delivery_boy', 'orders.dboy_id', '=', 'delivery_boy.dboy_id')
              ->where('orders.user_id',$user_id)
              ->where('orders.order_status', '!=', NULL)
              ->where('orders.payment_method', '!=', NULL)
              ->orderBy('orders.order_id', 'DESC')
               ->get();
      
      if(count($ongoing)>0){
      foreach($ongoing as $ongoings){
      $order = DB::table('store_orders')
            ->where('order_cart_id',$ongoings->cart_id)
            ->get();
                  
        
        $data[]=array('user_name'=>$ongoings->name,'delivery_address'=>$ongoings->house_no.','.$ongoings->society.','.$ongoings->city.','.$ongoings->landmark.','.$ongoings->state.','.$ongoings->pincode,'store_name'=>$ongoings->store_name,'store_owner'=>$ongoings->employee_name, 'store_phone'=>$ongoings->phone_number, 'store_email'=>$ongoings->email, 'store_address'=>$ongoings->address ,'order_status'=>$ongoings->order_status, 'delivery_date'=>$ongoings->delivery_date, 'time_slot'=>$ongoings->time_slot,'payment_method'=>$ongoings->payment_method,'payment_status'=>$ongoings->payment_status,'paid_by_wallet'=>$ongoings->paid_by_wallet, 'cart_id'=>$ongoings->cart_id ,'price'=>$ongoings->total_price,'del_charge'=>$ongoings->delivery_charge,'remaining_amount'=>$ongoings->rem_price,'coupon_discount'=>$ongoings->coupon_discount,'dboy_name'=>$ongoings->boy_name,'dboy_phone'=>$ongoings->boy_phone, 'data'=>$order); 
        }
        }
        else{
             $data=array('data'=>[]);
        }
        return $data;       
                  
                  
  }     
  
  
 
 
 
 
  
  
  public function cancel_for(Request $request)
    { 
   $cancelfor = DB::table('cancel_for')
                  ->get();
      
       if($cancelfor){
        	$message = array('status'=>'1', 'message'=>'Cancelling reason list', 'data'=>$cancelfor);
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'no list found', 'data'=>[]);
        	return $message;
        }
  }
  
  
  public function delete_order(Request $request)
  {
      $cart_id = $request->cart_id;
       $user = DB::table('orders')
              ->where('cart_id',$cart_id)
              ->first();
       $var= DB::table('store_orders')
           ->where('order_cart_id', $cart_id)
           ->get();
           $store_id =$user->store_id; 
        $price2=0;
        $ph = DB::table('users')
                  ->select('user_phone','wallet','name','id')
                  ->where('id',$user->user_id)
                  ->first();
        $user_id = $ph->id;          
        $user_phone = $ph->user_phone;   
        $user_name = $ph->name;
        foreach ($var as $h){
        $varient_id = $h->varient_id;
       $p = DB::table('store_products')
            ->join('product_varient','store_products.varient_id','=','product_varient.varient_id') 
            ->join('product','product_varient.product_id','=','product.product_id')
           ->where('product_varient.varient_id',$varient_id)
           ->where('store_products.store_id',$store_id)
           ->first();
        $price = $p->price;   
        $order_qty = $h->qty;
        $price2+= $price*$order_qty;
        $unit[] = $p->unit;
        $qty[]= $p->quantity;
        $p_name[] = $p->product_name."(".$p->quantity.$p->unit.")*".$order_qty;
        $prod_name = implode(',',$p_name);
        }   
        $c_pmnt = DB::table('cart_payments')
              ->where('cart_id',$cart_id)
              ->first();      
        $user_id1 = $user->user_id;
         $userwa1 = DB::table('users')
                     ->where('id',$user_id1)
                     ->first();
      $reason = $request->reason;
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
              }
          else{
              if($user->payment_status=='success' && $c_pmnt->payment_gateway != NULL){

                if($c_pmnt->payment_gateway == "razorpay" || $c_pmnt->payment_gateway == "Razorpay" || $c_pmnt->payment_gateway == "RAZORPAY"){

                     $razorpay_secret =Setting::where('name', 'razorpay_secret_key')->select('value')->first(); 
                     $razorpay_key =Setting::where('name', 'razorpay_key_id')->select('value')->first();

                    $api = new Api($razorpay_key->value, $razorpay_secret->value);

                    $payment = $api->payment->fetch($c_pmnt->payment_id);
                    $refund = $payment->refund();
                  $newbal1 = $userwa1->wallet + $user->paid_by_wallet;  

                    $userwalletupdate = DB::table('users')
                                     ->where('id',$user_id1)
                                    ->update(['wallet'=>$newbal1]);  
                   }elseif($c_pmnt->payment_gateway == "stripe" || $c_pmnt->payment_gateway == "Stripe" || $c_pmnt->payment_gateway == "STRIPE"){
                     $stripe_secret =Setting::where('name', 'stripe_secret_key')->select('value')->first(); 
                     $stripe_publishable_key =Setting::where('name', 'stripe_publishable_key')->select('value')->first(); 
                    $stripe = new \Stripe\StripeClient(
                      $stripe_secret->value
                    );
                    $stripe->refunds->create([
                      'charge' => $c_pmnt->payment_id,
                    ]);
                    $newbal1 = $userwa1->wallet + $user->paid_by_wallet;  
                    $userwalletupdate = DB::table('users')
                                     ->where('id',$user_id1)
                                        ->update(['wallet'=>$newbal1]);  
                    
                   }elseif($c_pmnt->payment_gateway == "paystack" || $c_pmnt->payment_gateway == "Paystack" || $c_pmnt->payment_gateway == "PAYSTACK"){
                    $paystack_public_key =Setting::where('name', 'paystack_public_key')->select('value')->first(); 
                    $paystack_secret_key =Setting::where('name', 'paystack_secret_key')->select('value')->first(); 
                                  
                                   $url = "https://api.paystack.co/refund";
              $fields = [
                'transaction' =>  $c_pmnt->payment_id
              ];
              $fields_string = http_build_query($fields);
              $ch = curl_init();
              curl_setopt($ch,CURLOPT_URL, $url);
              curl_setopt($ch,CURLOPT_POST, true);
              curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
              curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Authorization: Bearer ".$paystack_secret_key,
                "Cache-Control: no-cache",
              ));
              
              curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
              $result = curl_exec($ch);
                    $newbal1 = $userwa1->wallet + $user->paid_by_wallet;  
                    $userwalletupdate = DB::table('users')
                                      ->where('id',$user_id1)
                                        ->update(['wallet'=>$newbal1]);  
             
                   }else{
                    $clientId =Setting::where('name', 'paypal_client_id')->select('value')->first();
                    $clientSecret =Setting::where('name', 'paypal_secret_key')->select('value')->first();   
                    $newbal1 = $userwa1->wallet; 
                     $userwalletupdate = DB::table('users')
                    ->where('id',$user_id1)
                     ->update(['wallet'=>$newbal1]);  
                 }
              }
              else{
                   $newbal1 = $userwa1->wallet+$user->paid_by_wallet;   
                    $userwalletupdate = DB::table('users')
                                 ->where('id',$user_id1)
                                 ->update(['wallet'=>$newbal1]);  
              }
             }      
             
              $sms = DB::table('notificationby')
                       ->select('sms')
                       ->where('user_id',$user_id1)
                       ->first();
                       
            $sms_status = $sms->sms;
            $user_phone = $userwa1->user_phone;
            $user_name = $userwa1->name;
            $device_id = $userwa1->device_id;
            $user_email = $userwa1->email;
            $store = DB::table('store')
                   ->where('id', $user->store_id)
                   ->first();
                if($sms_status == 1){
                    $ordercancelled = $this->ordercancelled($cart_id,$user_phone,$user_name,$prod_name, $price2);
                   
                }
                 
                
                    
                      /////send mail
            $email = DB::table('notificationby')
                   ->select('email','app')
                   ->where('user_id',$user_id1)
                   ->first();
             $q = DB::table('users')
                  ->select('email','name','device_id')
                  ->where('id',$user_id)
                  ->first();
            $user_email = $q->email;             
            $device_id = $q->device_id;     
            $user_name = $q->name;       
            $email_status = $email->email;       
            if($email_status == 1){
                   
                    $codordercancel = $this->ordercancelMail($cart_id,$user_phone,$user_name,$user_email,$prod_name, $price2);
               }
          
          
           if($store){
               
                   $store_phone = $store->phone_number;
                   $store_email = $store->email;
                   $store_n = $store->store_name;
                     $ordercancelledstore = $this->ordercancelledstore($cart_id,$user_phone,$store_phone,$user_name,$prod_name, $price2);
                     $codorderplacedstore = $this->ordercancelMailstore($cart_id,$user_phone,$user_name,$store_email,$store_n,$prod_name, $price2);
                 }
                 
          $admin = DB::table('admin')
                ->first();
          $admin_email = $admin->email;
          $admin_name = $admin->name;
             $codorderplacedadmin = $this->ordercancelMailadmin($cart_id,$user_phone,$user_name,$admin_email,$admin_name,$prod_name, $price2);     
        	$message = array('status'=>'1', 'message'=>'order cancelled', 'data'=>$order);
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'something went wrong', 'data'=>[]);
        	return $message;
        }
      
      
  }   
  
  
  
  
    public function whatsnew(Request $request){
        $current = Carbon::now(); 
       $store_id = $request->store_id;
               
       $new = DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                  ->join ('product', 'product_varient.product_id', '=', 'product.product_id')
                  ->Leftjoin ('deal_product', 'product_varient.varient_id', '=', 'deal_product.varient_id')
                   ->join('store', 'store_products.store_id', '=', 'store.id')
                  ->select('store_products.store_id','store_products.stock','product_varient.varient_id','product.product_id','product.product_name', 'product.product_image', 'product_varient.description', 'store_products.price', 'store_products.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','product.type')
                ->groupBy('store_products.store_id','store_products.stock','product_varient.varient_id','product.product_id','product.product_name', 'product.product_image', 'product_varient.description', 'store_products.price', 'store_products.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','product.type')    
                 ->limit(10)
                ->where('deal_product.deal_price', NULL)
                ->where('store_products.price','!=',NULL)
                ->where('store_products.store_id',$store_id)
                ->where('product.hide',0)
                ->orderBy('store_products.stock', 'DESC')
                ->orderBy('store_products.p_id', 'DESC')
                ->limit(8)
                 ->get();
           
     if(count($new)>0){
            $result =array();
            $j = 0;
            $k= 0;
            $l=0;
            $m=0;
            foreach ($new as $prods) {
                array_push($result, $prods);
                 $c = array($prods->product_id);
                    $app1 =DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                 ->Leftjoin('deal_product','product_varient.varient_id','=','deal_product.varient_id')
                         ->select('store_products.store_id','store_products.stock','product_varient.varient_id', 'product_varient.description', 'store_products.price', 'store_products.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','deal_product.deal_price', 'deal_product.valid_from', 'deal_product.valid_to')
                         ->where('store_products.store_id', $store_id)
                        ->whereIn('product_varient.product_id', $c)
                        ->where('store_products.price','!=',NULL)
                         ->where('product_varient.approved',1)
                         ->get();
                         
                
                 $result[$k]->varient = $app1;
                 $k++;
                    $l++; 
                $app = json_decode($prods->product_id);
                $apps = array($app);
                $images = DB::table('product_images')
                ->select('image')
                 ->whereIn('product_id', $apps)
                 ->get();
                if(count($images)>0){
                    $result[$m]->images = $images;
                    $m++; 
                }else{
                    $images = DB::table('product')
                 ->select('product_image as image')    
                 ->whereIn('product_id', $apps)
                 ->get();
                 
                  $result[$m]->images = $images;
                    $m++; 
                    
                }
                $tag = DB::table('tags')
                 ->whereIn('product_id', $apps)
                ->get();
                $result[$j]->tags = $tag;  
                $j++;
               
             
            }

          	$message = array('status'=>'1', 'message'=>'New in Store', 'data'=>$new);
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'nothing in new', 'data'=>[]);
        	return $message;
        }      
           
                  
         
        

  }    
  
  

  
  
   public function completed_orders(Request $request)
    {
      $user_id = $request->user_id;
      $completeds = DB::table('orders')
               ->leftJoin('delivery_boy', 'orders.dboy_id', '=', 'delivery_boy.dboy_id')
              ->where('orders.user_id',$user_id)
              ->where('orders.order_status', 'Completed')
              ->get();
      
      if(count($completeds)>0){
      foreach($completeds as $completed){
      $order = DB::table('store_orders')
              ->leftJoin('product_varient', 'store_orders.varient_id','=','product_varient.varient_id')
              ->select('store_orders.*','product_varient.description')
              ->where('store_orders.order_cart_id',$completed->cart_id)
              ->orderBy('store_orders.order_date', 'DESC')
              ->get();
                  
        
        $data[]=array('order_status'=>$completed->order_status, 'delivery_date'=>$completed->delivery_date, 'time_slot'=>$completed->time_slot,'payment_method'=>$completed->payment_method,'payment_status'=>$completed->payment_status,'paid_by_wallet'=>$completed->paid_by_wallet, 'cart_id'=>$completed->cart_id ,'price'=>$completed->total_price,'del_charge'=>$completed->delivery_charge,'remaining_amount'=>$completed->rem_price,'coupon_discount'=>$completed->coupon_discount,'dboy_name'=>$completed->boy_name,'dboy_phone'=>$completed->boy_phone, 'data'=>$order); 
        }
        }
        else{
            $data=array('data'=>[]);
        }
        return $data;       
                  
                  
  }     
  
  
  
  
   public function can_orders(Request $request)
    {
      $user_id = $request->user_id;
      $completed = DB::table('orders')
              ->where('user_id',$user_id)
              ->where('order_status', 'cancelled')
               ->get();
      
      if(count($completed)>0){
      foreach($completed as $completeds){
      $order = DB::table('store_orders')
            ->join ('product_varient', 'store_orders.varient_id', '=', 'product_varient.varient_id')
            ->join ('product', 'product_varient.product_id', '=', 'product.product_id')
                  ->select('product_varient.varient_id','product.product_name', 'product_varient.varient_image','store_orders.qty','product_varient.description','product_varient.unit','product_varient.quantity','store_orders.order_cart_id')
                  ->where('store_orders.order_cart_id',$completeds->cart_id)
                  ->groupBy('product_varient.varient_id','product.product_name', 'product_varient.varient_image','store_orders.qty','product_varient.description','product_varient.unit','product_varient.quantity','store_orders.order_cart_id')
                  ->orderBy('store_orders.order_date', 'DESC')
                  ->get();
                  
        
        $data[]=array( 'cart_id'=>$completeds->cart_id ,'price'=>$completeds->total_price,'del_charge'=>$completeds->delivery_charge, 'data'=>$order); 
        }
        }
        else{
            $data[]=array('data'=>'No Orders Cancelled Yet');
        }
        return $data;       
                  
                  
  }     
  
  
   public function top_selling(Request $request){
      
       $current = Carbon::now();
       $store_id = $request->store_id;
       
                  
       $topselling = DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                  ->join ('product', 'product_varient.product_id', '=', 'product.product_id')
                  ->Leftjoin ('store_orders', 'store_products.varient_id', '=', 'store_orders.varient_id') 
                  ->Leftjoin ('orders', 'store_orders.order_cart_id', '=', 'orders.cart_id')
                  ->Leftjoin ('deal_product', 'product_varient.varient_id', '=', 'deal_product.varient_id')
                  ->select('store_products.store_id','store_products.stock','product_varient.varient_id','product.product_id','product.product_name', 'product.product_image', 'product_varient.description', 'store_products.price', 'store_products.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','product.type',DB::raw('count(store_orders.varient_id) as count'))
                  ->groupBy('store_products.store_id','store_products.stock','product_varient.varient_id','product.product_id','product.product_name', 'product.product_image', 'product_varient.description', 'store_products.price', 'store_products.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','product.type')
                  ->where('store_products.store_id', $store_id)
                  ->where('deal_product.deal_price', NULL)
                  ->where('store_products.price','!=',NULL)
                  ->where('product.hide',0)
                  ->orderBy('count','desc')
                  ->limit(8)
                  ->get();
                  
         if(count($topselling)>0){
              $result =array();
            $j = 0;
            $l=0;
            $k=0;
            $m=0;
            foreach ($topselling as $prods) {
                array_push($result, $prods);
                $c = array($prods->product_id);
                    $app1 =DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                 ->Leftjoin('deal_product','product_varient.varient_id','=','deal_product.varient_id')
                         ->select('store_products.store_id','store_products.stock','product_varient.varient_id', 'product_varient.description', 'store_products.price', 'store_products.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','deal_product.deal_price', 'deal_product.valid_from', 'deal_product.valid_to')
                         ->where('store_products.store_id', $store_id)
                        ->whereIn('product_varient.product_id', $c)
                        ->where('store_products.price','!=',NULL)
                         ->where('product_varient.approved',1)
                         ->get();
                         
                 $result[$k]->varient = $app1;
                 $k++;
                    $l++; 
                $app = json_decode($prods->product_id);
                $apps = array($app);
              $images = DB::table('product_images')
                ->select('image')
                 ->whereIn('product_id', $apps)
                 ->get();
                if(count($images)>0){
                    $result[$m]->images = $images;
                    $m++; 
                }else{
                    $images = DB::table('product')
                 ->select('product_image as image')    
                 ->whereIn('product_id', $apps)
                 ->get();
                 
                  $result[$m]->images = $images;
                    $m++; 
                    
                }
                $tag = DB::table('tags')
                 ->whereIn('product_id', $apps)
                ->get();
                $result[$j]->tags = $tag;  
                $j++;
               
             
            }
        	$message = array('status'=>'1', 'message'=>'top selling products', 'data'=>$topselling);
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'nothing in top', 'data'=>[]);
        	return $message;
        }      
     
  }    
  
  
    public function recentselling(Request $request){
        $current = Carbon::now();    
          $store_id = $request->store_id;
              
       $recentselling = DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                  ->join ('product', 'product_varient.product_id', '=', 'product.product_id')
                  ->Leftjoin ('store_orders', 'product_varient.varient_id', '=', 'store_orders.varient_id') 
                  ->Leftjoin ('orders', 'store_orders.order_cart_id', '=', 'orders.cart_id')
                  ->Leftjoin ('deal_product', 'product_varient.varient_id', '=', 'deal_product.varient_id')
                  ->select('store_products.store_id','store_products.stock','product_varient.varient_id','product.product_id','product.product_name', 'product.product_image', 'product_varient.description', 'store_products.price', 'store_products.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','product.type',DB::raw('count(store_orders.varient_id) as count'))
                  ->groupBy('store_products.store_id','store_products.stock','product_varient.varient_id','product.product_id','product.product_name', 'product.product_image', 'product_varient.description', 'store_products.price', 'store_products.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','product.type')
                   ->where('store_products.store_id', $store_id)
                  ->orderByRaw('RAND()')
                  ->where('deal_product.deal_price', NULL)
                  ->where('product.hide',0)
                ->where('store_products.price','!=',NULL)
                  ->limit(8)
                  ->get();
                  
         if(count($recentselling)>0){
             
         $result =array();
            $j = 0;
            $l=0;
            $k=0;
            $m=0;
            foreach ($recentselling as $prods) {
                array_push($result, $prods);
                $c = array($prods->product_id);
                    $app1 =DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                 ->Leftjoin('deal_product','product_varient.varient_id','=','deal_product.varient_id')
                         ->select('store_products.store_id','store_products.stock','product_varient.varient_id', 'product_varient.description', 'store_products.price', 'store_products.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','deal_product.deal_price', 'deal_product.valid_from', 'deal_product.valid_to')
                         ->where('store_products.store_id', $store_id)
                        ->whereIn('product_varient.product_id', $c)
                        ->where('store_products.price','!=',NULL)
                         ->where('product_varient.approved',1)
                         ->get();
                 $result[$k]->varient = $app1;
                 $k++;
                    $l++; 
                $app = json_decode($prods->product_id);
                $apps = array($app);
                $images = DB::table('product_images')
                ->select('image')
                 ->whereIn('product_id', $apps)
                 ->get();
                if(count($images)>0){
                    $result[$m]->images = $images;
                    $m++; 
                }else{
                    $images = DB::table('product')
                 ->select('product_image as image')    
                 ->whereIn('product_id', $apps)
                 ->get();
                 
                  $result[$m]->images = $images;
                    $m++; 
                    
                }
                $tag = DB::table('tags')
                 ->whereIn('product_id', $apps)
                ->get();
                $result[$j]->tags = $tag;  
                $j++;
               
             
            }
        	$message = array('status'=>'1', 'message'=>'recent selling products', 'data'=>$recentselling);
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'nothing in top', 'data'=>[]);
        	return $message;
        } 
    
  }    
  
}