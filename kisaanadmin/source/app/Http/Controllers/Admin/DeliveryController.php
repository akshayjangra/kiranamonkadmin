<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\carbon;
use App\Models\Admin;
use Auth;
class DeliveryController extends Controller
{
    public function list(Request $request)
    {
        $title = "Delivery Boy List";
         $admin_email=Auth::guard('admin')->user()->email;
       $admin= DB::table('admin')
             ->where('email',$admin_email)
             ->first();
        $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
           $d_boy = DB::table('delivery_boy')
                   ->where('added_by','admin')
                    ->get();
        
      return view('admin.d_boy.list', compact('title',"admin", "logo","d_boy"));
    }

    
     public function AddD_boy(Request $request)
    {
    
        $title = "Add Delivery Boy";
         $admin_email=Auth::guard('admin')->user()->email;
       $admin= DB::table('admin')
             ->where('email',$admin_email)
             ->first();
        $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
           $d_boy = DB::table('delivery_boy')
                    ->get();
        $city =DB::table('city')
              ->get();
              
         $map1 = DB::table('map_api')
             ->first();
         $map = $map1->map_api_key;      
          $mapset = DB::table('map_settings')
                ->first();
        $mapbox = DB::table('mapbox')
                ->first();
        
        $stores = DB::table('store')
                ->get();
        return view('admin.d_boy.add',compact("d_boy", "admin_email","logo", "admin","title", 'city','map','mapset','mapbox','stores'));
     }
    
     public function AddNewD_boy(Request $request)
    {
        $boy_name = $request->boy_name;
        $boy_phone =$request->boy_phone;
        $password = $request->password;
        $boy_loc = $request->boy_loc;
        $city =$request->city;
        $status = 1;
        $date=date('d-m-Y');
       
        $addres = str_replace(" ", "+", $boy_loc);
        $address1 = str_replace("-", "+", $addres);
         $mapapi = DB::table('map_api')
                 ->first();
         $mapset= DB::table('map_settings')
                ->first();        
                    
        $chkboyrphon = DB::table('delivery_boy')
                      ->where('boy_phone', $boy_phone)
                      ->first(); 

        if($chkboyrphon){
             return redirect()->back()->withErrors(trans('keywords.This Phone Number Is Already Registered With Another Delivery Boy'));
        } 
                 
        $key = $mapapi->map_api_key;  
        if($mapset->mapbox == 0 && $mapset->google_map == 1){ 
        $response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address1)."&key=".$key));
        
        
         $lat = $response->results[0]->geometry->location->lat;
         $lng = $response->results[0]->geometry->location->lng;
        }
        else{
            $lat = $request->lat;
            $lng = $request->lng;
        }
        
        $this->validate(
            $request,
                [
                    
                    'boy_name' => 'required',
                    'boy_phone' => 'required',
                    'password' => 'required',
                    'boy_loc'=> 'required',
                    'city'=>'required',
                    
                ],
                [
                    'boy_name.required' => 'Enter Boy Name.',
                    'boy_phone.required' => 'Choose Boy Phone.',
                    'password.required' => 'choose password',
                    'boy_loc.required' => 'enter boy location',
                    'city.required' => 'enter boy city',
                ]
        );
       

        $insert = DB::table('delivery_boy')
                            ->insertGetId([
                                'boy_name'=>$boy_name,
                                'boy_phone'=>$boy_phone,
                                'boy_city'=>$city,
                                'password'=>$password,
                                'boy_loc'=>$boy_loc,
                                'lat'=>$lat,
                                'lng'=>$lng,
                                'status'=>$status,
                               
                            ]);
        
        if($insert){
        $selectedstore = $request->selectedstore;
        foreach($selectedstore as $data)
        {
            $insertCategory = DB::table('store_delivery_boy')
                            ->insert([
                                'ad_dboy_id'=>$insert,
                                'store_id'=>$data,
                                'boy_name'=>$boy_name,
                                'boy_phone'=>$boy_phone,
                                'boy_city'=>$city,
                                'password'=>$password,
                                'boy_loc'=>$boy_loc,
                                'lat'=>$lat,
                                'lng'=>$lng,
                                'status'=>$status,
                                'added_by'=>'admin',

                            ]);
        }
            return redirect()->back()->withSuccess(trans('keywords.Added Successfully'));
        }
        else{
            return redirect()->back()->withErrors(trans('keywords.Something Wents Wrong'));
        }
      
    }
    
    public function EditD_boy(Request $request)
    {
        
         $dboy_id = $request->id;
         $title = "Edit Delivery Boy";
         $admin_email=Auth::guard('admin')->user()->email;
       $admin= DB::table('admin')
             ->where('email',$admin_email)
             ->first();
        $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        $stores = DB::table('store')
                ->get();            
        $d_boy=  DB::table('delivery_boy')
            ->where('dboy_id', $dboy_id)
            ->first();
        $city =DB::table('city')
              ->get();
              
         $map1 = DB::table('map_api')
             ->first();
         $map = $map1->map_api_key; 
         $mapset = DB::table('map_settings')
                ->first();
        $mapbox = DB::table('mapbox')
                ->first();

         $assigned_stores=DB::table('store_delivery_boy')
                  ->select('store_id')
                  ->where('added_by','admin')
                  ->where('ad_dboy_id',$dboy_id)
                  ->get();
            
            
            if(count($assigned_stores)>0){
                foreach($assigned_stores as $assigned_storess)
                {
                    $aci[]=$assigned_storess->store_id;
                }
            }
            else
            {
                $aci=array();
            }
            




        return view('admin.d_boy.edit',compact("d_boy","admin_email","admin","logo","title","city","map",'mapset','mapbox', 'aci','stores'));
    }

    public function UpdateD_boy(Request $request)
    {
       $dboy_id = $request->id;
       $boy_name = $request->boy_name;
       $boy_phone =$request->boy_phone;
       $password = $request->password;
       $boy_loc = $request->boy_loc;
       $city =$request->city;
       $mapset= DB::table('map_settings')
                ->first();
         $addres = str_replace(" ", "+", $boy_loc);
        $address1 = str_replace("-", "+", $addres);
        
     $chkboyrphon = DB::table('delivery_boy')
                  ->where('boy_phone', $boy_phone)
                  ->where('dboy_id','!=',$dboy_id)
                 ->first(); 

        if($chkboyrphon){
             return redirect()->back()->withErrors(trans('keywords.This Phone Number Is Already Registered With Another Delivery Boy'));
        } 
        
         $mapapi = DB::table('map_api')
                 ->first();
                 
        $key = $mapapi->map_api_key;  
        if($mapset->mapbox == 0 && $mapset->google_map == 1){ 
        $response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address1)."&key=".$key));
        
         $lat = $response->results[0]->geometry->location->lat;
         $lng = $response->results[0]->geometry->location->lng;
        }
        else{
           $lat = $request->lat;
            $lng = $request->lng; 
        }
        
         $this->validate(
            $request,
                [
                    
                    'boy_name' => 'required',
                    'boy_phone' => 'required',
                    'password' => 'required',
                    'boy_loc'=> 'required',
                    'city'=>'required',
                    'selectedcat'=>'required'
                    
                ],
                [
                    'boy_name.required' => 'Enter Boy Name.',
                    'boy_phone.required' => 'Choose Boy Phone.',
                    'password.required' => 'choose password',
                    'boy_loc.required' => 'enter boy location',
                    'city.required' => 'enter boy city',
                    'selectedcat.required'=>'select any store(s)'
                ]
        );


        $updated = DB::table('delivery_boy')
                   ->where('dboy_id', $dboy_id)
                    ->update([
                        'boy_name'=>$boy_name,
                        'boy_phone'=>$boy_phone,
                        'boy_city'=>$city,
                        'password'=>$password,
                        'boy_loc'=>$boy_loc,
                        'lat'=>$lat,
                        'lng'=>$lng
                       
                    ]);

        
        $selectedstore = $request->selectedcat;
          $delete =DB::table('store_delivery_boy')
                    ->where('ad_dboy_id', $dboy_id)
                    ->delete();
        foreach($selectedstore as $data)
        {

          

            $insertCategory = DB::table('store_delivery_boy')
                            ->insert([
                                'ad_dboy_id'=>$dboy_id,
                                'store_id'=>$data,
                                'boy_name'=>$boy_name,
                                'boy_phone'=>$boy_phone,
                                'boy_city'=>$city,
                                'password'=>$password,
                                'boy_loc'=>$boy_loc,
                                'lat'=>$lat,
                                'lng'=>$lng,
                                'added_by'=>'admin',

                            ]);
        }
            if($updated || $insertCategory){

            return redirect()->back()->withSuccess(trans('keywords.Updated Successfully'));
        }
        else{
            return redirect()->back()->withErrors(trans('keywords.Something Wents Wrong'));
        }
       
       
       
       
    }
    
    
    
 public function DeleteD_boy(Request $request)
    {
        $dboy_id = $request->id;

      $delete=DB::table('delivery_boy')
             ->where('dboy_id', $dboy_id)->delete();
        if($delete)
        {
             $delete =DB::table('store_delivery_boy')
                    ->where('ad_dboy_id', $dboy_id)
                    ->delete();

        return redirect()->back()->withSuccess(trans('keywords.Deleted Successfully'));
        }
        else
        {
           return redirect()->back()->withErrors(trans('keywords.Something Wents Wrong')); 
        }
    }
    
    
      public function boy_reports(Request $request)
    {
         $title = "Home";
          $admin_email=Auth::guard('admin')->user()->email;
    	 $admin= DB::table('admin')
    	 		   ->where('email',$admin_email)
    	 		   ->first();
    	 $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        $dboy = DB::table('delivery_boy')
                   ->where('added_by','admin')
                    ->get();
        
        $orddboy =DB::table('orders')
             ->leftJoin('delivery_boy','orders.dboy_id','=','delivery_boy.dboy_id')
             ->select('delivery_boy.boy_name','delivery_boy.boy_phone', DB::raw('Count(orders.cart_id) as count'))
             ->groupBy('delivery_boy.boy_name','delivery_boy.boy_phone')
             ->whereDate('orders.delivery_date', '>', Carbon::now()->subDays(30))
             ->where('orders.payment_method','!=', NULL)
             ->where('orders.order_status', 'Completed')
             ->orderBy('count', 'desc')
             ->get();
      
      
      $store = DB::table('store')
                    ->get();
        
        $ordstore =DB::table('orders')
             ->leftJoin('store','orders.store_id','=','store.id')
             ->select('store.store_name','store.phone_number', DB::raw('Count(orders.cart_id) as count'))
             ->groupBy('store.store_name','store.phone_number')
             ->whereDate('orders.delivery_date', '>', Carbon::now()->subDays(30))
             ->where('orders.payment_method','!=', NULL)
             ->where('orders.order_status', 'Completed')
             ->orderBy('count', 'desc')
             ->get();
             
  $user= DB::table('users')
             ->join('orders','users.id','=','orders.user_id')
             ->select('users.id','users.user_phone','users.name', DB::raw('Count(orders.cart_id) as count'))
             ->groupBy('users.id','users.user_phone','users.name')
             ->whereMonth('orders.delivery_date', date('m'))
            ->whereYear('orders.delivery_date', date('Y'))
            ->where('orders.payment_method','!=', NULL)
             ->where('orders.order_status', 'Completed')
            ->orderBy('count', 'desc')
            ->get();
      
   $user2 =DB::table('users')
             ->join('orders','users.id','=','orders.user_id')
             ->select('users.id','users.user_phone','users.name', DB::raw('Count(orders.cart_id) as count'))
             ->groupBy('users.id','users.user_phone','users.name')
             ->whereMonth('orders.delivery_date', '=', Carbon::now()->subMonth()->month)
             ->where('orders.payment_method','!=', NULL)
             ->where('orders.order_status', 'Completed')
            ->orderBy('count', 'asc')
            ->get();               
    	return view('admin.d_boy.d_boy_report', compact('title',"admin", "logo",'dboy','orddboy', 'store', 'ordstore','user','user2'));
    }

}