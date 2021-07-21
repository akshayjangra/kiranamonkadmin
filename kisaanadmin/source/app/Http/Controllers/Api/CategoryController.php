<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class CategoryController extends Controller
{

  public function product_images(Request $request){
          $prod_id = $request->product_id;
                
      $images = DB::table('product_images')
                 ->where('product_id', $prod_id)
                 ->get();

      if(count($images)>0){
         $message = array('status'=>'1', 'message'=>'Product Images', 'data'=>$images);
            return $message;
      }
      else{
          $prod_id = $request->product_id;
                
      $images = DB::table('product')
                 ->where('product_id', $prod_id)
                 ->get();
         if(count($images)>0){
         $message = array('status'=>'1', 'message'=>'Product Images', 'data'=>$images);
            return $message;
          }
          else{
              $message = array('status'=>'0', 'message'=>'no images found', 'data'=>$images);
            return $message;
          }
      }

}
    public function getneareststore(Request $request)
    {
       $lat = $request->lat;
       $lng = $request->lng;
       $nearbystore = DB::table('store')
                    ->select('phone_number','del_range','id','store_name','store_status','inactive_reason','lat','lng','store_opening_time','store_closing_time',DB::raw("6371 * acos(cos(radians(".$lat . ")) 
                    * cos(radians(lat)) 
                    * cos(radians(lng) - radians(" . $lng . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(lat))) AS distance"))
                  ->orderBy('distance')
                  ->where('store_status',1)
                  ->first();
    if($nearbystore){              
     if($nearbystore->del_range >= $nearbystore->distance)  {  
           if($nearbystore->store_status == 1){
            $message = array('status'=>'1', 'message'=>'Store Found at your location', 'data'=>$nearbystore);
            return $message;
           }
           else{
                $message = array('status'=>'2', 'message'=>'Store Is Closed', 'data'=>$nearbystore);
            return $message;
           }
        }
        else{
              $cities= DB::table('city')
                    ->join('store', 'city.city_name', '=', 'store.city')
                    ->select('city.city_name')
                    ->groupBy('city.city_name')
                  ->get();
          foreach($cities as $city){        
        $c_name[] = $city->city_name;
        $city_name = implode(',',$c_name);    
          }        
                  
            
            $message = array('status'=>'0', 'message'=>'We are not delivering your area. we service in '.$city_name.' only', 'data'=>[]);
            return $message;
        }    

    }
    else{
         $cities= DB::table('city')
                    ->join('store', 'city.city_name', '=', 'store.city')
                    ->select('city.city_name')
                    ->groupBy('city.city_name')
                  ->get();
                  
       foreach($cities as $city){        
        $c_name[] = $city->city_name;
        $city_name = implode(',',$c_name);    
          }           
                  
                  
            
           $message = array('status'=>'0', 'message'=>'We are not delivering your area. we service in '.$city_name.' only', 'data'=>[]);
            return $message;
        
        }    
    }



    public function oneapi(Request $request)
    {
         $d = Carbon::Now();
       $store_id = $request->store_id;
        $deal_pssss= DB::table('deal_product')
                ->join('store_products', 'deal_product.varient_id', '=', 'store_products.varient_id')
                ->join('store', 'deal_product.store_id', '=', 'store.id')
                ->join('product_varient', 'deal_product.varient_id', '=', 'product_varient.varient_id')
                ->join('product', 'product_varient.product_id', '=', 'product.product_id')
                ->select('store.del_range','store_products.store_id','store_products.stock','deal_product.deal_price as price', 'product_varient.varient_image', 'product_varient.quantity','product_varient.unit', 'store_products.mrp','product_varient.description' ,'product.product_name','product.product_image','product_varient.varient_id','product.product_id','deal_product.valid_to','deal_product.valid_from','product.type')
                ->groupBy('store.del_range','store_products.store_id','store_products.stock','deal_product.deal_price', 'product_varient.varient_image', 'product_varient.quantity','product_varient.unit', 'store_products.mrp','product_varient.description' ,'product.product_name','product.product_image','product_varient.varient_id','product.product_id','deal_product.valid_to','deal_product.valid_from','product.type')
                ->whereDate('deal_product.valid_from','<=',$d->toDateString())
                ->where('deal_product.valid_to','>',$d->toDateString())
                ->where('store_products.price','!=',NULL)
                ->where('product.hide',0)
                ->limit(6)
                ->where('deal_product.store_id',$store_id)
                ->get();
                
           $deal_p = $deal_pssss->unique('varient_id');        
          
         $deal_products = array();
        foreach($deal_p as $store)
        {
           
                $deal_products[] = $store; 
            
        }
         if(count($deal_products) >0){
            $result =array();
            $i = 0;
             $j = 0;
             $k=0;
             $l=0;
             $m=0;
            foreach ($deal_products as $deal_ps) {
                array_push($result, $deal_ps);
                  $c = array($deal_ps->product_id);
                    $app1 =DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                 ->join('deal_product','product_varient.varient_id','=','deal_product.varient_id')
                         ->select('store_products.store_id','store_products.stock','product_varient.varient_id', 'product_varient.description', 'store_products.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','deal_product.deal_price as price', 'deal_product.valid_from', 'deal_product.valid_to')
                         ->where('store_products.store_id', $store_id)
                        ->whereIn('product_varient.product_id', $c)
                        ->where('store_products.price','!=',NULL)
                         ->where('product_varient.approved',1)
                         ->get();
                    $tag = DB::table('tags')
                 ->whereIn('product_id', $c)
                ->get();
                $images = DB::table('product_images')
                ->select('image')
                 ->whereIn('product_id', $c)
                 ->get();
                if(count($images)>0){
                    $result[$m]->images = $images;
                    $m++; 
                }else{
                    $images = DB::table('product')
                 ->select('product_image as image')    
                 ->whereIn('product_id', $c)
                 ->get();
                 
                  $result[$m]->images = $images;
                    $m++; 
                    
                }
                if(count($tag)>0){        
                    $result[$k]->tags = $tag;
                    $k++; 
                   }
                   else{
                     $result[$k]->tags = [];
                    $k++;  
                   }
                         
                    $result[$l]->varient = $app1;
                    $l++; 
                 
                $val_to =  $deal_ps->valid_to;       
                $diff_in_minutes = $d->diffInMinutes($val_to); 
                $totalDuration =  $d->diff($val_to)->format('%H:%I:%S');
                $result[$i]->timediff = $diff_in_minutes;
                $i++; 
                $result[$j]->hoursmin= $totalDuration;
                $j++; 
            }
         }
          $topcat = DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                  ->join ('product', 'product_varient.product_id', '=', 'product.product_id')
                  ->Leftjoin ('store_orders', 'product_varient.varient_id', '=', 'store_orders.varient_id') 
                  ->Leftjoin ('orders', 'store_orders.order_cart_id', '=', 'orders.cart_id')
                   ->join('store', 'store_products.store_id', '=', 'store.id')
                  ->join ('categories', 'product.cat_id','=','categories.cat_id')
                  ->select('store.del_range','store.id','categories.title', 'categories.image', 'categories.description','categories.cat_id',DB::raw("count('orders.order_id') as count" )) 
                  ->groupBy('store.del_range','store.id','categories.title', 'categories.image', 'categories.description','categories.cat_id')
                   ->where('store_products.price','!=',NULL)
                   ->where('product.hide',0)
                   ->where('store.id',$store_id)
                  ->orderBy('count','desc')
                  ->limit(8)
                  ->get();
                  
        $topsix = NULL;
        foreach($topcat as $store)
        {
            
                $topsix[] = $store; 
            
        }      
         $banner = DB::table('store_banner')
                ->join('categories', 'store_banner.cat_id', '=','categories.cat_id')
                ->select('store_banner.*', 'categories.title')
                ->where('store_id',$store_id)
                ->get();
        
          $new = DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                  ->join ('product', 'product_varient.product_id', '=', 'product.product_id')
                  ->Leftjoin ('deal_product', 'product_varient.varient_id', '=', 'deal_product.varient_id')
                   ->join('store', 'store_products.store_id', '=', 'store.id')
                  ->select('store_products.store_id','store_products.stock','product_varient.varient_id','product.product_id','product.product_name', 'product.product_image', 'product_varient.description', 'store_products.price', 'store_products.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','product.type')
                ->groupBy('store_products.store_id','store_products.stock','product_varient.varient_id','product.product_id','product.product_name', 'product.product_image', 'product_varient.description', 'store_products.price', 'store_products.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','product.type')    
                ->where('deal_product.deal_price', NULL)
                ->where('store_products.price','!=',NULL)
                ->where('store_products.store_id',$store_id)
                ->where('product.hide',0)
                ->orderBy('store_products.stock', 'DESC')
                ->orderBy('store_products.p_id', 'DESC')
                ->limit(6)
                 ->get();
           
     if(count($new)>0){
            $result =array();
            $i=0;
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
                         
                $images = DB::table('product_images')
                ->select('image')
                 ->whereIn('product_id', $c)
                 ->get();
                if(count($images)>0){
                    $result[$m]->images = $images;
                    $m++; 
                }else{
                    $images = DB::table('product')
                 ->select('product_image as image')    
                 ->whereIn('product_id', $c)
                 ->get();
                 
                  $result[$m]->images = $images;
                    $m++; 
                    
                }         
                 $result[$k]->varient = $app1;
                    $k++; 
                $app = json_decode($prods->product_id);
                $apps = array($app);
              
                $tag = DB::table('tags')
                 ->whereIn('product_id', $apps)
                ->get();
                $result[$j]->tags = $tag;  
                $j++;
               
             
            }
     }
            
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
                  ->limit(6)
                  ->get();
                  
         if(count($topselling)>0){
              $result =array();
            $i=0;
            $j = 0;
            $k= 0;
            $l=0;
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
                $images = DB::table('product_images')
                ->select('image')
                 ->whereIn('product_id', $c)
                 ->get();
                if(count($images)>0){
                    $result[$m]->images = $images;
                    $m++; 
                }else{
                    $images = DB::table('product')
                 ->select('product_image as image')    
                 ->whereIn('product_id', $c)
                 ->get();
                 
                  $result[$m]->images = $images;
                    $m++; 
                    
                }         
                 $result[$k]->varient = $app1;
                    $k++; 
                $app = json_decode($prods->product_id);
                $apps = array($app);
              
                $tag = DB::table('tags')
                 ->whereIn('product_id', $apps)
                ->get();
                $result[$j]->tags = $tag;  
                $j++;
               
             
            }
         }
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
                  ->limit(6)
                  ->get();
                  
         if(count($recentselling)>0){
             
         $result =array();
           $i=0;
            $j = 0;
            $k= 0;
            $l=0;
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
                $images = DB::table('product_images')
                ->select('image')
                 ->whereIn('product_id', $c)
                 ->get();
                if(count($images)>0){
                    $result[$m]->images = $images;
                    $m++; 
                }else{
                    $images = DB::table('product')
                 ->select('product_image as image')    
                 ->whereIn('product_id', $c)
                 ->get();
                 
                  $result[$m]->images = $images;
                    $m++; 
                    
                }         
                 $result[$k]->varient = $app1;
                    $k++; 
                $app = json_decode($prods->product_id);
                $apps = array($app);
              
                $tag = DB::table('tags')
                 ->whereIn('product_id', $apps)
                ->get();
                $result[$j]->tags = $tag;  
                $j++;
               
             
            }
         }
          if(count($recentselling)>0){
         $recent_selling = array('type'=>'Recent Selling', 'data'=>$recentselling);
          }else{
             $recent_selling=''; 
          }
          if(count($topselling)>0){
         $top_selling = array('type'=>'Top Selling', 'data'=>$topselling);
          }else{
              $top_selling='';
          }
          if(count($new)>0){
         $whatsnew = array('type'=>'Whats New', 'data'=>$new);
          }
          else{
            $whatsnew='';  
          }
         if(count($deal_products)>0){
         $deal = array('type'=>'Deal Products', 'data'=>$deal_products);
         }else{
          $deal ='';
          
         }
         $tab= array($recent_selling,$top_selling,$whatsnew,$deal);
         $tab_filter =array_filter($tab); 
         $tab_encode=json_encode($tab_filter);
         $tabs =json_decode($tab_encode);
         
          $message = array('status'=>'1', 'message'=>'Homepage data', 'banner'=>$banner,'top_cat'=>$topsix, 'tabs'=>$tabs);
          return $message;
    }
    
    public function tabs(Request $request)
    {
         $d = Carbon::Now();
       $store_id = $request->store_id;
        $deal_pssss= DB::table('deal_product')
                ->join('store_products', 'deal_product.varient_id', '=', 'store_products.varient_id')
                ->join('store', 'deal_product.store_id', '=', 'store.id')
                ->join('product_varient', 'deal_product.varient_id', '=', 'product_varient.varient_id')
                ->join('product', 'product_varient.product_id', '=', 'product.product_id')
                ->select('store.del_range','store_products.store_id','store_products.stock','deal_product.deal_price as price', 'product_varient.varient_image', 'product_varient.quantity','product_varient.unit', 'store_products.mrp','product_varient.description' ,'product.product_name','product.product_image','product_varient.varient_id','product.product_id','deal_product.valid_to','deal_product.valid_from','product.type')
                ->groupBy('store.del_range','store_products.store_id','store_products.stock','deal_product.deal_price', 'product_varient.varient_image', 'product_varient.quantity','product_varient.unit', 'store_products.mrp','product_varient.description' ,'product.product_name','product.product_image','product_varient.varient_id','product.product_id','deal_product.valid_to','deal_product.valid_from','product.type')
                ->whereDate('deal_product.valid_from','<=',$d->toDateString())
                ->where('deal_product.valid_to','>',$d->toDateString())
                ->where('store_products.price','!=',NULL)
                ->where('product.hide',0)
                ->limit(6)
                ->where('deal_product.store_id',$store_id)
                ->get();
                
           $deal_p = $deal_pssss->unique('varient_id');        
          
         $deal_products = array();
        foreach($deal_p as $store)
        {
           
                $deal_products[] = $store; 
            
        }
         if(count($deal_products) >0){
            $result =array();
            $i = 0;
             $j = 0;
             $k=0;
             $l=0;
             $m=0;
            foreach ($deal_products as $deal_ps) {
                array_push($result, $deal_ps);
                  $c = array($deal_ps->product_id);
                    $app1 =DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                 ->join('deal_product','product_varient.varient_id','=','deal_product.varient_id')
                         ->select('store_products.store_id','store_products.stock','product_varient.varient_id', 'product_varient.description', 'store_products.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','deal_product.deal_price as price', 'deal_product.valid_from', 'deal_product.valid_to')
                         ->where('store_products.store_id', $store_id)
                        ->whereIn('product_varient.product_id', $c)
                        ->where('store_products.price','!=',NULL)
                         ->where('product_varient.approved',1)
                         ->get();
                    $tag = DB::table('tags')
                 ->whereIn('product_id', $c)
                ->get();
                $images = DB::table('product_images')
                ->select('image')
                 ->whereIn('product_id', $c)
                 ->get();
                if(count($images)>0){
                    $result[$m]->images = $images;
                    $m++; 
                }else{
                    $images = DB::table('product')
                 ->select('product_image as image')    
                 ->whereIn('product_id', $c)
                 ->get();
                 
                  $result[$m]->images = $images;
                    $m++; 
                    
                }
                if(count($tag)>0){        
                    $result[$k]->tags = $tag;
                    $k++; 
                   }
                   else{
                     $result[$k]->tags = [];
                    $k++;  
                   }
                         
                    $result[$l]->varient = $app1;
                    $l++; 
                 
                $val_to =  $deal_ps->valid_to;       
                $diff_in_minutes = $d->diffInMinutes($val_to); 
                $totalDuration =  $d->diff($val_to)->format('%H:%I:%S');
                $result[$i]->timediff = $diff_in_minutes;
                $i++; 
                $result[$j]->hoursmin= $totalDuration;
                $j++; 
            }
         }
     
        
          $new = DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                  ->join ('product', 'product_varient.product_id', '=', 'product.product_id')
                  ->Leftjoin ('deal_product', 'product_varient.varient_id', '=', 'deal_product.varient_id')
                   ->join('store', 'store_products.store_id', '=', 'store.id')
                  ->select('store_products.store_id','store_products.stock','product_varient.varient_id','product.product_id','product.product_name', 'product.product_image', 'product_varient.description', 'store_products.price', 'store_products.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','product.type')
                ->groupBy('store_products.store_id','store_products.stock','product_varient.varient_id','product.product_id','product.product_name', 'product.product_image', 'product_varient.description', 'store_products.price', 'store_products.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','product.type')    
                ->where('deal_product.deal_price', NULL)
                ->where('store_products.price','!=',NULL)
                ->where('store_products.store_id',$store_id)
                ->where('product.hide',0)
                ->orderBy('store_products.stock', 'DESC')
                ->orderBy('store_products.p_id', 'DESC')
                ->limit(6)
                 ->get();
           
     if(count($new)>0){
            $result =array();
            $i=0;
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
                $images = DB::table('product_images')
                ->select('image')
                 ->whereIn('product_id', $c)
                 ->get();
                if(count($images)>0){
                    $result[$m]->images = $images;
                    $m++; 
                }else{
                    $images = DB::table('product')
                 ->select('product_image as image')    
                 ->whereIn('product_id', $c)
                 ->get();
                 
                  $result[$m]->images = $images;
                    $m++; 
                    
                }
                 $result[$k]->varient = $app1;
                    $k++; 
                $app = json_decode($prods->product_id);
                $apps = array($app);
              
                $tag = DB::table('tags')
                 ->whereIn('product_id', $apps)
                ->get();
                $result[$j]->tags = $tag;  
                $j++;
               
             
            }
     }
            
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
                  ->limit(6)
                  ->get();
                  
         if(count($topselling)>0){
              $result =array();
            $i=0;
            $j = 0;
            $k= 0;
            $l=0;
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
                 $images = DB::table('product_images')
                ->select('image')
                 ->whereIn('product_id', $c)
                 ->get();
                if(count($images)>0){
                    $result[$m]->images = $images;
                    $m++; 
                }else{
                    $images = DB::table('product')
                 ->select('product_image as image')    
                 ->whereIn('product_id', $c)
                 ->get();
                 
                  $result[$m]->images = $images;
                    $m++; 
                    
                }
                 $result[$k]->varient = $app1;
                    $k++; 
                $app = json_decode($prods->product_id);
                $apps = array($app);
              
                $tag = DB::table('tags')
                 ->whereIn('product_id', $apps)
                ->get();
                $result[$j]->tags = $tag;  
                $j++;
               
             
            }
         }
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
                  ->limit(6)
                  ->get();
                  
         if(count($recentselling)>0){
             
         $result =array();
           $i=0;
            $j = 0;
            $k= 0;
            $l=0;
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
                         
                $images = DB::table('product_images')
                ->select('image')
                 ->whereIn('product_id', $c)
                 ->get();
                if(count($images)>0){
                    $result[$m]->images = $images;
                    $m++; 
                }else{
                    $images = DB::table('product')
                 ->select('product_image as image')    
                 ->whereIn('product_id', $c)
                 ->get();
                 
                  $result[$m]->images = $images;
                    $m++; 
                    
                }         
                 $result[$k]->varient = $app1;
                    $k++; 
                $app = json_decode($prods->product_id);
                $apps = array($app);
              
                $tag = DB::table('tags')
                 ->whereIn('product_id', $apps)
                ->get();
                $result[$j]->tags = $tag;  
                $j++;
               
             
            }
         }
          if(count($recentselling)>0){
         $recent_selling = array('type'=>'Recent Selling', 'data'=>$recentselling);
          }else{
             $recent_selling=''; 
          }
          if(count($topselling)>0){
         $top_selling = array('type'=>'Top Selling', 'data'=>$topselling);
          }else{
              $top_selling='';
          }
          if(count($new)>0){
         $whatsnew = array('type'=>'Whats New', 'data'=>$new);
          }
          else{
            $whatsnew='';  
          }
         if(count($deal_products)>0){
         $deal = array('type'=>'Deal Products', 'data'=>$deal_products);
         }else{
          $deal ='';
          
         }
         $tab= array($recent_selling,$top_selling,$whatsnew,$deal);
         $tab_filter =array_filter($tab); 
         $tab_encode=json_encode($tab_filter);
         $tabs =json_decode($tab_encode);
         
        	$message = array('status'=>'1', 'message'=>'Homepage data', 'tabs'=>$tabs);
        	return $message;
        
    }
    
    
    public function cate(Request $request)
    {
    $store_id = $request->store_id;    
     $cat = DB::table('categories')
          ->join('categories as cat','categories.cat_id', '=', 'cat.parent' )
          ->join('product','cat.cat_id', '=', 'product.cat_id' )
          ->join('product_varient','product.product_id', '=', 'product_varient.product_id' )
          ->join('store_products','product_varient.varient_id', '=', 'store_products.varient_id' )
          ->select('categories.title','categories.cat_id','categories.image', 'categories.description')
          ->groupBy('categories.title','categories.cat_id','categories.image', 'categories.description')
          ->where('categories.level', 0)
          ->where('store_products.store_id', $store_id)
          ->get();

        if(count($cat)>0){
            $result =array();
            $i = 0;

            foreach ($cat as $cats) {
                array_push($result, $cats);

                $app = json_decode($cats->cat_id);
                $apps = array($app);
                $app = DB::table('categories')
                        ->whereIn('parent', $apps)
                        ->where('level',1)
                        ->get();
                        
                $result[$i]->subcategory = $app;
                $i++; 
                $res =array();
                $j = 0;
                foreach ($app as $appss) {
                    array_push($res, $appss);
                    $c = array($appss->cat_id);
                    $app1 = DB::table('categories')
                            ->whereIn('parent', $c)
                            ->where('level',2)
                            ->get();
                if(count($app1)>0){        
                    $res[$j]->subchild = $app1;
                    $j++; 
                   }
                   else{
                     $res[$j]->subchild = [];
                    $j++;  
                   }
                 }   
             
            }

            $message = array('status'=>'1', 'message'=>'data found', 'data'=>$cat);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        }
    }
    
    
    
    
     public function top_cat_prduct(Request $request){
          $store_id = $request->store_id;
                
      $topcat = DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                  ->join ('product', 'product_varient.product_id', '=', 'product.product_id')
                  ->Leftjoin ('store_orders', 'product_varient.varient_id', '=', 'store_orders.varient_id') 
                  ->Leftjoin ('orders', 'store_orders.order_cart_id', '=', 'orders.cart_id')
                   ->join('store', 'store_products.store_id', '=', 'store.id')
                  ->join ('categories', 'product.cat_id','=','categories.cat_id')
                  ->select('categories.title','categories.cat_id',DB::raw("count('orders.order_id') as count" )) 
                  ->groupBy('categories.title','categories.cat_id')
                   ->where('store_products.price','!=',NULL)
                   ->where('product.hide',0)
                   ->where('store.id',$store_id)
                  ->orderBy('count','desc')
                  ->limit(4)
                  ->get();
                  
        $topsix = NULL;
        foreach($topcat as $store)
        {
            
                $topsix[] = $store; 
            
        }      
                  
         if($topsix != NULL){
              $result =array();
            $i = 0;

            foreach ($topsix as $cats) {
                array_push($result, $cats);

                $app = json_decode($cats->cat_id);
                $apps = array($app);
                $app = DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                  ->join ('product', 'product_varient.product_id', '=', 'product.product_id')
          ->whereIn('product.cat_id', $apps)
          ->where('store_products.store_id', $store_id)
          ->where('store_products.price','!=',NULL)
          ->where('product.hide',0)
          ->where('product.approved',1)
            ->limit(6)
             ->get();
                        
                $result[$i]->products = $app;
                $i++; 
                $res =array();
                $j = 0;
                $k = 0;
                $m=0;
                foreach ($app as $appss) {
                    array_push($res, $appss);
                    $c = array($appss->product_id);
                    $app1 =DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                 ->Leftjoin('deal_product','product_varient.varient_id','=','deal_product.varient_id')
                         ->select('store_products.store_id','store_products.stock','product_varient.varient_id', 'product_varient.description', 'store_products.price', 'store_products.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','deal_product.deal_price', 'deal_product.valid_from', 'deal_product.valid_to')
                         ->where('store_products.store_id', $store_id)
                        ->whereIn('product_varient.product_id', $c)
                        ->where('store_products.price','!=',NULL)
                         ->where('product_varient.approved',1)
                         ->get();
                $images = DB::table('product_images')
                ->select('image')
                 ->whereIn('product_id', $c)
                 ->get();
                if(count($images)>0){
                    $result[$m]->images = $images;
                    $m++; 
                }else{
                    $images = DB::table('product')
                 ->select('product_image as image')    
                 ->whereIn('product_id', $c)
                 ->get();
                 
                  $result[$m]->images = $images;
                    $m++; 
                    
                }         
                    $tag = DB::table('tags')
                 ->whereIn('product_id', $c)
                ->get();
                
                if(count($tag)>0){        
                    $res[$k]->tags = $tag;
                    $k++; 
                   }
                   else{
                     $res[$k]->tags = [];
                    $k++;  
                   }
                         
                    $res[$j]->varient = $app1;
                    $j++; 
                 
                 }   
             
            }

            $message = array('status'=>'1', 'message'=>'data found', 'data'=>$topsix);
            return $message;
        }
        else{
          $message = array('status'=>'0', 'message'=>'Nothing in Top Categories', 'data'=>[]);
          return $message;
        } 
    
  }   
    
    
    public function catego(Request $request)
    {
    $store_id = $request->store_id; 
    $cat_id = $request->cat_id;
     $cat = DB::table('categories')
          ->join('product','categories.cat_id', '=', 'product.cat_id' )
          ->join('product_varient','product.product_id', '=', 'product_varient.product_id' )
          ->join('store_products','product_varient.varient_id', '=', 'store_products.varient_id' )
          ->select('categories.title','categories.cat_id','categories.image', 'categories.description')
          ->groupBy('categories.title','categories.cat_id','categories.image', 'categories.description')
          ->where('store_products.store_id', $store_id)
          ->where('categories.parent', $cat_id)
          ->get();

        if(count($cat)>0){
            

            $message = array('status'=>'1', 'message'=>'data found', 'data'=>$cat);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        }
    }
    
   
      
  public function cat_product(Request $request)
    {
       $cat_id =$request->cat_id;  
       $store_id = $request->store_id;
       $prodsssss =  DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                  ->join ('product', 'product_varient.product_id', '=', 'product.product_id')
          ->where('product.cat_id', $cat_id)
          ->where('store_products.store_id', $store_id)
          ->where('store_products.price','!=',NULL)
          ->where('product.hide',0)
          ->where('product.approved',1)
          ->paginate(10);
         
        $prodsd = $prodsssss->unique('product_id'); 
        
        
         $prod = NULL;
        foreach($prodsd as $store)
        {
           
                $prod[] = $store; 
            
        }
         
        if($prod != NULL){
            $result =array();
            $i = 0;
            $j = 0;
            $m = 0;
            foreach ($prod as $prods) {
                array_push($result, $prods);

                $app = json_decode($prods->product_id);
                $apps = array($app);
                $app =  DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                 ->Leftjoin('deal_product','product_varient.varient_id','=','deal_product.varient_id')
                         ->select('store_products.store_id','store_products.stock','product_varient.varient_id', 'product_varient.description', 'store_products.price', 'store_products.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','deal_product.deal_price', 'deal_product.valid_from', 'deal_product.valid_to')
                         ->where('store_products.store_id', $store_id)
                        ->whereIn('product_varient.product_id', $apps)
                        ->where('store_products.price','!=',NULL)
                         ->where('product_varient.approved',1)
                        ->get();
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
                $result[$i]->varients = $app;
                $i++; 
             
            }

            $message = array('status'=>'1', 'message'=>'Products found', 'data'=>$prod);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'Products not found', 'data'=>[]);
            return $message;
        }
     
    }   
    
    
    

    
     public function varient(Request $request)
    {
        $prod_id = $request->product_id;
         $store_id = $request->store_id;
        $varient= DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                 ->Leftjoin('deal_product','product_varient.varient_id','=','deal_product.varient_id')
                         ->select('store_products.store_id','store_products.stock','product_varient.varient_id', 'product_varient.description', 'store_products.price', 'store_products.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','deal_product.deal_price', 'deal_product.valid_from', 'deal_product.valid_to')
                ->where('product_id',$prod_id)
                ->where('store_products.price','!=',NULL)
                ->where('store_products.store_id',$store_id)
                ->where('product_varient.approved',1)
                ->get();
        if(count($varient)>0){        
          $message = array('status'=>'1', 'message'=>'varients', 'data'=>$varient);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        } 
   
                
    }
    
    
     public function dealproduct(Request $request)
    {
        $d = Carbon::Now();
       $store_id = $request->store_id;
        $deal_pssss= DB::table('deal_product')
                ->join('store_products', 'deal_product.varient_id', '=', 'store_products.varient_id')
                ->join('store', 'deal_product.store_id', '=', 'store.id')
                ->join('product_varient', 'deal_product.varient_id', '=', 'product_varient.varient_id')
                ->join('product', 'product_varient.product_id', '=', 'product.product_id')
                ->select('store.del_range','store_products.store_id','store_products.stock','deal_product.deal_price as price', 'product_varient.varient_image', 'product_varient.quantity','product_varient.unit', 'store_products.mrp','product_varient.description' ,'product.product_name','product.product_image','product_varient.varient_id','product.product_id','deal_product.valid_to','deal_product.valid_from','product.type')
                ->groupBy('store.del_range','store_products.store_id','store_products.stock','deal_product.deal_price', 'product_varient.varient_image', 'product_varient.quantity','product_varient.unit', 'store_products.mrp','product_varient.description' ,'product.product_name','product.product_image','product_varient.varient_id','product.product_id','deal_product.valid_to','deal_product.valid_from','product.type')
                ->whereDate('deal_product.valid_from','<=',$d->toDateString())
                ->where('deal_product.valid_to','>',$d->toDateString())
                ->where('store_products.price','!=',NULL)
                ->where('product.hide',0)
                ->limit(8)
                ->where('deal_product.store_id',$store_id)
                ->get();
                
           $deal_p = $deal_pssss->unique('varient_id');        
          
         $deal_products = NULL;
        foreach($deal_p as $store)
        {
           
                $deal_products[] = $store; 
            
        }
         if($deal_products != NULL){
            $result =array();
            $i = 0;
             $j = 0;
             $k=0;
             $l=0;
             $m=0;
            foreach ($deal_products as $deal_ps) {
                array_push($result, $deal_ps);
                  $c = array($deal_ps->product_id);
                    $app1 =DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                 ->join('deal_product','product_varient.varient_id','=','deal_product.varient_id')
                         ->select('store_products.store_id','store_products.stock','product_varient.varient_id', 'product_varient.description', 'store_products.price', 'store_products.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','deal_product.deal_price', 'deal_product.valid_from', 'deal_product.valid_to')
                         ->where('store_products.store_id', $store_id)
                        ->whereIn('product_varient.product_id', $c)
                        ->where('store_products.price','!=',NULL)
                         ->where('product_varient.approved',1)
                         ->get();
                $images = DB::table('product_images')
                ->select('image')
                 ->whereIn('product_id', $c)
                 ->get();
                if(count($images)>0){
                    $result[$m]->images = $images;
                    $m++; 
                }else{
                    $images = DB::table('product')
                 ->select('product_image as image')    
                 ->whereIn('product_id', $c)
                 ->get();
                 
                  $result[$m]->images = $images;
                    $m++; 
                    
                }
                    $tag = DB::table('tags')
                 ->whereIn('product_id', $c)
                ->get();
                
                if(count($tag)>0){        
                    $result[$k]->tags = $tag;
                    $k++; 
                   }
                   else{
                     $result[$k]->tags = [];
                    $k++;  
                   }
                         
                    $result[$l]->varient = $app1;
                    $l++; 
                 
                $val_to =  $deal_ps->valid_to;       
                $diff_in_minutes = $d->diffInMinutes($val_to); 
                $totalDuration =  $d->diff($val_to)->format('%H:%I:%S');
                $result[$i]->timediff = $diff_in_minutes;
                $i++; 
                $result[$j]->hoursmin= $totalDuration;
                $j++; 
            }
         

            $message = array('status'=>'1', 'message'=>'Products found', 'data'=>$deal_products);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'Products not found', 'data'=>[]);
            return $message;
        }     

    }
    
    
       public function top_cat(Request $request){
          $store_id = $request->store_id;
                
      $topcat = DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                  ->join ('product', 'product_varient.product_id', '=', 'product.product_id')
                  ->Leftjoin ('store_orders', 'product_varient.varient_id', '=', 'store_orders.varient_id') 
                  ->Leftjoin ('orders', 'store_orders.order_cart_id', '=', 'orders.cart_id')
                   ->join('store', 'store_products.store_id', '=', 'store.id')
                  ->join ('categories', 'product.cat_id','=','categories.cat_id')
                  ->select('store.del_range','store.id','categories.title', 'categories.image', 'categories.description','categories.cat_id',DB::raw("count('orders.order_id') as count" )) 
                  ->groupBy('store.del_range','store.id','categories.title', 'categories.image', 'categories.description','categories.cat_id')
                   ->where('store_products.price','!=',NULL)
                   ->where('product.hide',0)
                   ->where('store.id',$store_id)
                  ->orderBy('count','desc')
                  ->get();
                  
        $topsix = NULL;
        foreach($topcat as $store)
        {
            
                $topsix[] = $store; 
            
        }      
                  
         if($topsix != NULL){
          $message = array('status'=>'1', 'message'=>'Top Categories', 'data'=>$topsix);
          return $message;
        }
        else{
          $message = array('status'=>'0', 'message'=>'Nothing in Top Six', 'data'=>[]);
          return $message;
        } 
    
  }   

 
    
    
   public function store_homecat(Request $request)
    {   
        $store_id = $request->store_id;
        $category = DB::table('store_homecat')
                  ->join('store_assign_homecat','store_homecat.homecat_id','=','store_homecat.homecat_id')
                  ->select('store_homecat.homecat_name','store_homecat.homecat_id','store_homecat.homecat_status','store_homecat.order','store_homecat.store_id')
                  ->groupBy('store_homecat.homecat_name','store_homecat.homecat_id','store_homecat.homecat_status','store_homecat.order','store_homecat.store_id')
                  ->where('store_homecat.store_id', $store_id)
                  ->where('store_homecat.homecat_status', 1)
               ->get();
        if(count($category)>0){      
        foreach($category as $homecat)
        {
            $newhomecat = DB::table('store_assign_homecat')
                   ->join('categories', 'store_assign_homecat.cat_id', '=', 'categories.cat_id')
                   ->join('store_homecat','store_assign_homecat.homecat_id','=','store_homecat.homecat_id')
                   ->select('categories.*','store_assign_homecat.*','store_homecat.store_id')
                   ->where('store_assign_homecat.homecat_id',$homecat->homecat_id)
               ->get();
               
           $homecate = NULL;
        foreach($newhomecat as $store)
        {
            
                $homecate[] = $store; 
            
        }          
          if($homecate != NULL){     
            $home[]=array('name'=>$homecat->homecat_name, 'store_id'=>$homecat->store_id, 'data'=>$homecate);
          }else{
           $home[]=array('data'=>'No Home category Group');  
          }
        }
        }
        else{
            $home[]=array('data'=>'No Home category Group');
        }
        return $home;
    }
    
    
    
   public function tag_product(Request $request)
    {
       $tag =ucfirst($request->tag_name);  
       $store_id = $request->store_id;
       $prodsssss =  DB::table('tags')
                  ->join ('product', 'tags.product_id', '=', 'product.product_id')
                 ->join('product_varient', 'product.product_id', '=', 'product_varient.product_id')
                 ->join('store_products', 'product_varient.varient_id', '=','store_products.varient_id')
                  ->where('tags.tag', $tag)
                  ->where('store_products.store_id', $store_id)
                  ->where('store_products.price','!=',NULL)
                  ->where('product.hide',0)
                  ->where('product.approved',1)
                  ->get();
         
        $prodsd = $prodsssss->unique('product_id'); 
        
        
         $prod = NULL;
        foreach($prodsd as $store)
        {
           
                $prod[] = $store; 
            
        }
         
        if(count($prod)>0){
            $result =array();
            $i = 0;
            $j = 0;
            $m =0;
            foreach ($prod as $prods) {
                array_push($result, $prods);

                $app = json_decode($prods->product_id);
                $apps = array($app);
                $app =  DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                 ->Leftjoin('deal_product','product_varient.varient_id','=','deal_product.varient_id')
                         ->select('store_products.store_id','store_products.stock','product_varient.varient_id', 'product_varient.description', 'store_products.price', 'store_products.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','deal_product.deal_price', 'deal_product.valid_from', 'deal_product.valid_to')
                         ->where('store_products.store_id', $store_id)
                        ->whereIn('product_varient.product_id', $apps)
                        ->where('store_products.price','!=',NULL)
                         ->where('product_varient.approved',1)
                        ->get();
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
                $result[$i]->varients = $app;
                $i++; 
             
            }

            $message = array('status'=>'1', 'message'=>'Products found', 'data'=>$prod);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'Products not found', 'data'=>[]);
            return $message;
        }
     
    }   
      
    
}