<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AppController extends Controller
{
   public function __construct(){
        $storage =  DB::table('image_space')
                    ->first();

        if($storage->aws == 1){
            $this->storage_space = "s3.aws";
        }
        else if($storage->digital_ocean == 1){
            $this->storage_space = "s3.digitalocean";
        }else{
            $this->storage_space ="same_server";
        }

    }
 
    public function app(Request $request)
    {
         if($this->storage_space != "same_server"){
           $url_aws =  rtrim(Storage::disk($this->storage_space)->url('/'),"/");
        }          
        else{
            $url_aws=url('/').'/';
        }        
          $user_id = $request->user_id;
          $store_id = $request->store_id;
          $wall = DB::table('users')
                ->select('wallet')
                ->where('id',$user_id)
                ->first();
           
             if($wall){
                $wallet = $wall->wallet;
            }else{
                $wallet = 0;
            }
                 
                
         
        if($store_id != NULL){
         $wishlist_items = DB::table('wishlist')
                    ->where('user_id',$user_id)
                    ->where('store_id', $store_id)
                    ->count();
         
                    
        }else{
           $wishlist_items = DB::table('wishlist')
                    ->where('user_id',$user_id)
                    ->count(); 
        }
          
             $sum = DB::table('store_orders')
            ->where('store_approval',$user_id)
            ->where('order_cart_id', "incart")
            ->select(DB::raw('SUM(store_orders.price) as sum'),DB::raw('COUNT(store_orders.store_order_id) as count'))
            ->first();
            
            if($sum && $user_id != NULL){
                $countp = $sum->count;
            }else{
                $countp = 0;
            }
            
            $app_link = DB::table('app_link')
                 ->first();
                 
            $android = $app_link->android_app_link;
            $ios = $app_link->ios_app_link;
          
          
          
          $app = DB::table('tbl_web_setting')
                      ->first();
                      
          $firebase_st = DB::table('firebase')
                ->first();
                
        $getScratchCard = DB::table('referral_points')
                                ->first();

         $scratch_card_offers = json_decode($getScratchCard->points);
           $min = $scratch_card_offers->min;
           $max = $scratch_card_offers->max;
          $refertext = "Refer and Earn Wallet Amount Upto from ".$min." to ".$max;         
                   
        if($firebase_st->status == '0'){
            $firebase_st = 'off';
            
        }else{
            $firebase_st = 'on';
        }      
            $currency = DB::table('currency')
                ->first();    
            $countrycode = DB::table('country_code')
                ->first();
             $code = $countrycode->country_code;    
            $isocode= DB::table('firebase_iso')
                ->first();    
                   
            $check= DB::table('smsby')
                   ->first();  
                   
            if($check->status == 1){
                $sms = 'on';
            }else{
                $sms = 'off';
            }
                      
        if($app)   { 
            $message = array('status'=>'1', 'message'=>'App Name & Logo','last_loc'=>$app->last_loc,'phone_number_length'=>$app->number_limit, 'app_name'=>$app->name,'app_logo'=>$app->icon, 'firebase'=>$firebase_st,'country_code'=>$code, 'firebase_iso'=>$isocode->iso_code, 'sms'=>$sms , 'currency_sign' => $currency->currency_sign,'refertext' =>$refertext,'total_items'=>$countp, 'android_app_link'=>$android,'payment_currency' => $currency->currency_name,'ios_app_link'=>$ios, "image_url"=>$url_aws,'wishlist_count'=>$wishlist_items, 'userwallet'=>$wallet);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'data not found', "image_url"=>$url_aws, 'data'=>[]);
            return $message;
        }

        return $message;
    }
    
    
    public function couponlist(Request $request)
    {   
        $store_id = $request->store_id;
          $coupon = DB::table('coupon')
                     ->where('store_id', $store_id)
                      ->get();
                      
        if($coupon)   { 
            $message = array('status'=>'1', 'message'=>'coupon list', 'data'=>$coupon);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        }

        return $message;
    } 
    
    public function delivery_info(Request $request)
    {
          $del_fee = DB::table('freedeliverycart')
                      ->first();
                      
        if($del_fee)   { 
            $message = array('status'=>'1', 'message'=>'Delivery fee and cart value', 'data'=>$del_fee);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        }

        return $message;
    }



      public function storebanner(Request $request)
    {  
        $store_id = $request->store_id;
        $banner = DB::table('store_banner')
                ->join('categories', 'store_banner.cat_id', '=','categories.cat_id')
                ->select('store_banner.*', 'categories.title')
                ->where('store_id',$store_id)
                ->get();
        
         if(count($banner)>0){
            $message = array('status'=>'1', 'message'=>'Banner List', 'data'=>$banner);
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'No Banner Found', 'data'=>[]);
            return $message;
        }
    }



    public function call(Request $request)
    {
        
          $user_id = $request->user_id;
          $date = date('Y-m-d');
          $store_id = $request->store_id;
          $check = DB::table('callback_req')
                 ->where('user_id',$user_id)
                 ->where('processed',0)
                ->first();
                
          $user = DB::table('users')
                ->where('id',$user_id)
                ->first();
                
                
          if($check){ 
              
         $app1 = DB::table('callback_req')
                   ->where('user_id',$user_id)
                 ->where('processed',0)
                 ->delete();
        if($store_id != NULL){         
          $app = DB::table('callback_req')
                ->insert(['user_id'=> $user_id,
                'user_name'=>$user->name,
                'user_phone'=>$user->user_phone,
                'date'=>$date,
                'store_id'=>$store_id,
                'processed'=>0]);
                
              }else{
                  $app = DB::table('callback_req')
                ->insert(['user_id'=> $user_id,
                'user_name'=>$user->name,
                'user_phone'=>$user->user_phone,
                'date'=>$date,
                'store_id'=>0,
                'processed'=>0]);
              }
          }    
          else{
               if($store_id != NULL){ 
              $app = DB::table('callback_req')
                ->insert(['user_id'=> $user_id,
                'user_name'=>$user->name,
                'user_phone'=>$user->user_phone,
                'date'=>$date,
                'store_id'=>$store_id,
                'processed'=>0]);
               }else{
                   $app = DB::table('callback_req')
                ->insert(['user_id'=> $user_id,
                'user_name'=>$user->name,
                'user_phone'=>$user->user_phone,
                'date'=>$date,
                'store_id'=>0,
                'processed'=>0]);
               }
          }
        if($app)   { 
            $message = array('status'=>'1', 'message'=>'Callback requested successfully');
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'Try again later', 'data'=>[]);
            return $message;
        }

        return $message;
    }



    public function minmax(Request $request)
    {  
        $store_id = $request->store_id;
        $minmax = DB::table('minimum_maximum_order_value')
                ->where('store_id', $store_id)
                ->first();
        
         if($minmax){
            $message = array('status'=>'1', 'message'=>'Min/Max Cart Value', 'data'=>$minmax);
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'Min/Max Cart Value not found', 'data'=>[]);
            return $message;
        }
    }
       public function payment(Request $request)
    {
    	return view('admin.payment');
    }
}
