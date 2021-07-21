<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Traits\SendSms;
use App\Traits\SendMail;
use App\Models\User;
use Hash;

class UserController extends Controller
{
    use SendSms;
    use SendMail;

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

public function social_login(Request $request)
    {
    $logintype = $request->type;
    $device_id = $request->device_id;
    if($logintype == 'google'){
       $user_email = $request->user_email;
       $checkuser = DB::table('users')
                  ->join('city','users.user_city','=','city.city_id')
                  ->join('society','users.user_area','=','society.society_id')
                  ->select('users.*','city.city_name','society.society_name')
                  ->where('users.email',$user_email)
                  ->where('users.is_verified','!=',0)
                  ->first();

      
      if($checkuser){
          $updateDeviceId = DB::table('users')
    		              ->where('email',$user_email)
    		              ->update(['device_id'=>$device_id]);
            $user = User::where('email',$user_email)
                    ->first();
              $token = $user->createToken('token')->accessToken;              
                 $message = array('satatus'=>'1', 'message'=>'Login Successfully','data'=>$checkuser, 'token'=>$token);
                return $message;
      }else{
          $delete = DB::table('users')
                  ->where('email',$user_email)
                  ->where('is_verified', 0)
                  ->delete();
         $message = array('status'=>'2', 'message'=>'go to register page', 'user_email'=>$user_email);
                return $message;
      }
    }
    else{
     $email = $request->email_id;
       $fb_id = $request->facebook_id;
        $checkuser = DB::table('users')
                  ->join('city','users.user_city','=','city.city_id')
                  ->join('society','users.user_area','=','society.society_id')
                  ->select('users.*','city.city_name','society.society_name')
                  ->where('users.is_verified','!=',0)
                  ->where('users.facebook_id',$fb_id)
                  ->orWhere('users.email', $email)
                  ->first();

      if($checkuser){
          $updateDeviceId = DB::table('users')
    		              ->where('facebook_id',$fb_id)
                          ->orWhere('email', $email)
    		              ->update(['device_id'=>$device_id]);
    		 $user = User::where('facebook_id',$fb_id)
                          ->orWhere('email', $email)
                    ->first();             
            $token = $user->createToken('token')->accessToken; 
                 $message = array('status'=>'1', 'message'=>'Login Successfully','data'=>$checkuser, 'token'=>$token);
                return $message;
      }else{
        $delete = DB::table('users')
                   ->where('is_verified','!=',0)
                     ->where('facebook_id',$fb_id)
                    ->orWhere('email', $user_email)
                  ->delete();
         $message = array('status'=>'3', 'message'=>'go to register page', 'fb_id' =>$fb_id);
                return $message;
      }
    }

   }

 public function signUp(Request $request)
    {
        $firebase = DB::table('firebase')
                  ->first();
        	$checuss = DB::table('users')
                        ->first();
       
        $type = $request->type;
         $created_at = Carbon::now();
        $updated_at = Carbon::now();
    	$user_name = $request->user_name;
    	$user_email = $request->user_email;
    	$user_phone = $request->user_phone;
    	$user_image = $request->user_image;
    	$user_city = $request->user_city;
    	$user_area = $request->user_area;
    	$fb_id = $request->fb_id;
        $user_password = Hash::make($request->password);
        $device_id = $request->device_id;
    	$date = date('d-m-Y');	          
    	 if($request->user_image){
            $image = $request->user_image;
            $fileName = $image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
           

           if($this->storage_space != "same_server"){
                $image_name = $image->getClientOriginalName();
                $image = $request->file('user_image');
                $filePath = '/user/'.$image_name;
                Storage::disk($this->storage_space)->put($filePath, fopen($request->file('user_image'), 'r+'), 'public');
            }
            else{
           
           $image->move('images/user/'.$date.'/', $fileName);
            $filePath = '/images/user/'.$date.'/'.$fileName;
        
            }
        }
          else{
               $filePath = 'N/A';
            }
        if($fb_id == NULL){
            $fb_id == NULL;
        }


    	
       
        $u_name1 = str_replace(' ', '', $user_name);
        $u_name2 = str_replace('.', '', $u_name1);
        $u_name3 = str_replace('-', '', $u_name2);
        $u_name = str_replace(',', '', $u_name3);
         $referral_code1 = $request->referral_code;
         $startingg = str_replace(' ', '', $u_name);
         $startingg1 = strtoupper(substr($u_name , 0, 3));
       
         $chars ="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                    $referral_code = "";
                    for ($i = 0; $i < 5; $i++){
                       $referral_code .= $chars[mt_rand(0, strlen($chars)-1)];
                    }
        $referral_c =$startingg1.$referral_code;             
        if($request->referral_code){
            $getReferredUser = DB::table('users')
                                ->where('referral_code', $referral_code1)
                                ->get();

            if(count($getReferredUser) == 0){
                $message = array('status'=>'0', 'message'=>'wrong referral code', 'data'=>$checuss);
                return $message;
            }
        }

        $date=date('d-m-Y');
    	$checkUser = DB::table('users')
    					->where('user_phone', $user_phone)
                        ->orwhere('email', $user_email)
    					->first();
    	//////delete if unverified/////				
    	if($checkUser && $checkUser->is_verified==0){
    	        $delnot= DB::table('notificationby')
    						->where('user_id', $checkUser->id)
    				     	->delete();
    						
    	    	$delUser = DB::table('users')
    					->where('id', $checkUser->id)
    					->delete();
    					}					
            $smsby = DB::table('smsby')
              ->first();
        if($smsby->status==1 && $firebase->status==0){      
        // check for otp verify
    	if($checkUser && $checkUser->is_verified==1){
    		$message = array('status'=>'0', 'message'=>'user already registered', 'data'=>$checuss);
            return $message;
    	}
    	
    ///////if phone not verified/////	
    	
	elseif($checkUser && $checkUser->is_verified==0){
        
    	 $user = DB::table('users')
         ->insertGetId([
            'name'=>$user_name,
            'email'=>$user_email,
            'user_phone'=>$user_phone,
            'user_image'=>$filePath,
            'user_city'=>$user_city,
            'user_area'=>$user_area,
            'password'=>$user_password,
            'device_id'=>$device_id,
            'reg_date'=>$created_at,
            'facebook_id'=>$fb_id,
            'referral_code'=>$referral_c,
            'created_at'=>$created_at,
            'updated_at'=>$updated_at, 
            ]);
 
       

        
           
    						
            	$Userdetails = DB::table('users')
    					->where('user_phone', $user_phone)
    					->first();
    		if($user){
    		     DB::table('notificationby')
    						->insert(['user_id'=> $user,
    						'sms'=> '1',
    						'app'=> '1',
    						'email'=> '1']);
    						
    						
    			$chars = "0123456789";
                $otpval = "";
                for ($i = 0; $i < 4; $i++){
                    $otpval .= $chars[mt_rand(0, strlen($chars)-1)];
                }
                
                
                $otpmsg = $this->otpmsg($otpval,$user_phone);
                
                $updateOtp = DB::table('users')
                                ->where('user_phone', $user_phone)
                                ->update(['otp_value'=>$otpval]);
    						
	    		$message = array('status'=>'1', 'message'=>'OTP Sent', 'data'=>$Userdetails);
	        	return $message;
	    	}
	    	else{
	    		$message = array('status'=>'0', 'message'=>'Something went wrong', 'data'=>$checuss);
	        return $message;
	    	}  
    	}
    	 ///////new user/////	
    	else{

         $user = DB::table('users')
         ->insertGetId([
            'name'=>$user_name,
            'email'=>$user_email,
            'user_phone'=>$user_phone,
            'user_image'=>$filePath,
            'user_city'=>$user_city,
            'user_area'=>$user_area,
            'password'=>$user_password,
            'device_id'=>$device_id,
            'reg_date'=>$created_at,
            'facebook_id'=>$fb_id,
            'referral_code'=>$referral_c,
            'created_at'=>$created_at,
            'updated_at'=>$updated_at, 
            ]);
 
        
    	
    						
            	$Userdetails = DB::table('users')
    					->where('user_phone', $user_phone)
    					->first();
    		if($user){
    		     DB::table('notificationby')
    						->insert(['user_id'=> $user,
    						'sms'=> '1',
    						'app'=> '1',
    						'email'=> '1']);
    						
    						
    			$chars = "0123456789";
                $otpval = "";
                for ($i = 0; $i < 4; $i++){
                    $otpval .= $chars[mt_rand(0, strlen($chars)-1)];
                }
                
               $otpmsg = $this->otpmsg($otpval,$user_phone);
    
                $updateOtp = DB::table('users')
                                ->where('user_phone', $user_phone)
                                ->update(['otp_value'=>$otpval]);
    						
	    		$message = array('status'=>'1', 'message'=>'OTP Sent', 'data'=>$Userdetails);
	        	return $message;
	    	}
	    	else{
	    		$message = array('status'=>'0', 'message'=>'Something went wrong', 'data'=>$checuss);
	        return $message;
	    	}
    	}
        }
        
        elseif($firebase->status==1){
        if($checkUser && $checkUser->is_verified==1){
    		$message = array('status'=>'0', 'message'=>'user already registered', 'data'=>$checuss);
            return $message;
    	}
    	else{

         $user = DB::table('users')
         ->insertGetId([
            'name'=>$user_name,
            'email'=>$user_email,
            'user_phone'=>$user_phone,
            'user_image'=>$filePath,
            'user_city'=>$user_city,
            'user_area'=>$user_area,
            'password'=>$user_password,
            'device_id'=>$device_id,
            'reg_date'=>$created_at,
            'is_verified'=>0,
            'otp_value'=>NULL,
            'facebook_id'=>$fb_id,
            'referral_code'=>$referral_c,
            'created_at'=>$created_at,
            'updated_at'=>$updated_at, 
            ]);
    		
            	$Userdetails = DB::table('users')
    					->where('user_phone', $user_phone)
    					->first();
    		if($user){
    		     DB::table('notificationby')
    						->insert(['user_id'=> $user,
    						'sms'=> '1',
    						'app'=> '1',
    						'email'=> '1']);
    			$message = array('status'=>'2', 'message'=>'Otp sent', 'data'=>$Userdetails);
                return $message;			
             	}
            }
        }
        
        else{
             $user = User::create([
            'name'=>$user_name,
            'email'=>$user_email,
            'user_phone'=>$user_phone,
            'user_image'=>$filePath,
            'user_city'=>$user_city,
            'user_area'=>$user_area,
            'password'=>$user_password,
            'device_id'=>$device_id,
            'reg_date'=>$created_at,
            'is_verified'=>1,
            'otp_value'=>NULL,
            'facebook_id'=>$fb_id,
            'referral_code'=>$referral_c,
            'created_at'=>$created_at,
            'updated_at'=>$updated_at, 
            ]);

    		
    						
            	$Userdetails = DB::table('users')
                    	->join('city','users.user_city','=','city.city_id')
                          ->join('society','users.user_area','=','society.society_id')
                          ->select('users.*','city.city_name','society.society_name')
    					->where('users.user_phone', $user_phone)
    					->first();
    		if($user){

    		     DB::table('notificationby')
    						->insert(['user_id'=> $user->id,
    						'sms'=> '1',
    						'app'=> '1',
    						'email'=> '1']);


                      ////earn referral amount/////      
    			  if($request->referral_code){
                    $getReferredUser1 = DB::table('users')
                                        ->where('referral_code', $referral_code1)
                                        ->first();

                    if($getReferredUser1){
                        $insertReferral = DB::table('tbl_referral')
                                            ->insert([
                                                'user_id'=>$user->id,
                                                'referral_by'=>$getReferredUser->id,
                                                'created_at'=>$created_at,
                                            ]);
                         $getScratchCard = DB::table('referral_points')
                                ->first();

                   $scratch_card_offers = json_decode($getScratchCard->points);
                   $earning = rand($scratch_card_offers->min, $scratch_card_offers->max);

                   $earn = "You've won ₹ ".$earning;
                   /////referral by user//////
                    $userupdate = DB::table('users')
                                        ->where('referral_code', $referral_code1)
                                        ->update(['wallet'=>$getReferredUser1->wallet + $earning]);
                    //////referral to user /////////
                      $userupdate2 = DB::table('users')
                                        ->where('id', $user->id)
                                        ->update(['wallet'=>$earning]);                   

                    }
                    else{
                        $message = array('status'=>'0', 'message'=>'wrong referral code', 'data'=>$checuss);
                        return $message;
                    }
                }	
                //////end referral ////		
    			$token = $user->createToken('token')->accessToken;			
    			$welcomemessage = $this->welmsg($user_name,$user_phone,$user_email);			
    			$welcomemail = $this->welmail($user_name,$user_phone,$user_email);			
    			$message = array('status'=>'2', 'message'=>'Login Successfully', 'data'=>$Userdetails, 'token'=> $token);
                return $message;			
             	}
            
        }



    }
    
    
    public function verifyotpfirebase(Request $request)
    {
        $phone = $request->user_phone;
        $status = $request->status;
        $device_id = $request->device_id;
        	$checuss = User::first();
        $referral_code = $request->referral_code;
        $smsby = DB::table('smsby') 
              ->first();
         $created_at = Carbon::now();       
        // check for otp verify
        $getUser = DB::table('users')
                  ->join('city','users.user_city','=','city.city_id')
                 ->join('society','users.user_area','=','society.society_id')
                  ->select('users.*','city.city_name','society.society_name')
                  ->where('users.user_phone', $phone)
                    ->first();
                    
        $user_name =  $getUser->name;
        $user_phone = $getUser->user_phone;
        $user_email = $getUser->email;
                    
                    
        if($getUser){
            
            if($status == "success"){
                // verify phone
                $getUser2 = User::where('user_phone', $phone)
                            ->update(['is_verified'=>1,
                            'otp_value'=>NULL]);


                 if($referral_code != NULL){
                    $getReferredUser1 = DB::table('users')
                                        ->where('referral_code', $referral_code)
                                        ->first();
                     $getuser = DB::table('users')
                            ->where('user_phone', $user_phone)
                            ->first();
                    if($getReferredUser1){
                        $insertReferral = DB::table('tbl_referral')
                                            ->insert([
                                                'user_id'=>$getuser->id,
                                                'referral_by'=>$getReferredUser->id,
                                                'created_at'=>$created_at,
                                            ]);
                         $getScratchCard = DB::table('referral_points')
                                ->first();

                   $scratch_card_offers = json_decode($getScratchCard->points);
                   $earning = rand($scratch_card_offers->min, $scratch_card_offers->max);

                   $earn = "You've won ₹ ".$earning;
                   /////referral by user//////
                    $userupdate = DB::table('users')
                                        ->where('referral_code', $referral_code)
                                        ->update(['wallet'=>$getReferredUser1->wallet + $earning]);
                    //////referral to user /////////
                      $userupdate2 = DB::table('users')
                                        ->where('user_phone', $user_phone)
                                        ->update(['wallet'=>$earning]);                   

                    }
                    else{
                        $message = array('status'=>'0', 'message'=>'wrong referral code', 'data'=>$checuss);
                        return $message;
                    }
                }
                 $updateDeviceId = DB::table('users')
    		                        ->where('user_phone', $phone)
    		                        ->update(['device_id'=>$device_id]);
                 $welcomemessage = $this->welmsg($user_name,$user_phone,$user_email); 
                 
                 $welcomemail = $this->welmail($user_name,$user_phone,$user_email);   
                 $user = User::where('user_phone', $phone)
                    ->first();
                 $token = $user->createToken('token')->accessToken;
                $message = array('status'=>1, 'message'=>"Phone Verified! login successfully", 'data'=> $getUser, 'token'=>$token);
                return $message;
            }
            else{
                $message = array('status'=>0, 'message'=>"Wrong OTP", 'data'=>$checuss);
                return $message;
            }
       
        }
        else{
            $message = array('status'=>0, 'message'=>"User not registered", 'data'=>$checuss);
            return $message;
        }
        
    }
    
    
     public function verifyPhone(Request $request)
    {
        $phone = $request->user_phone;
         $device_id = $request->device_id;
        $otp = $request->otp;
        	$checuss = DB::table('users')
                        ->first();
         $referral_code = $request->referral_code;
        $smsby = DB::table('smsby')
              ->first();
        if($smsby->status==1){      
        // check for otp verify
        $getUser =  DB::table('users')
                  ->join('city','users.user_city','=','city.city_id')
                 ->join('society','users.user_area','=','society.society_id')
                  ->select('users.*','city.city_name','society.society_name')
                  ->where('users.user_phone', $phone)
                    ->first();
                    
         $user_name =  $getUser->user_name;
        $user_phone = $getUser->user_phone;
        $user_email = $getUser->email;
                                
                    
                    
        if($getUser){
            $getotp = $getUser->otp_value;
            
            if($otp == $getotp){
                // verify phone
                $getUser2 = DB::table('users')
                            ->where('user_phone', $phone)
                            ->update(['is_verified'=>1,
                            'otp_value'=>NULL]);
                 if($referral_code != NULL){
                    $getReferredUser1 = DB::table('users')
                                        ->where('referral_code', $referral_code)
                                        ->first();
                     $getuser3 = DB::table('users')
                            ->where('user_phone', $user_phone)
                            ->first();
                    if($getReferredUser1){
                        $insertReferral = DB::table('tbl_referral')
                                            ->insert([
                                                'user_id'=>$getuser->id,
                                                'referral_by'=>$getReferredUser1->id,
                                                'created_at'=>$created_at,
                                            ]);
                         $getScratchCard = DB::table('referral_points')
                                ->first();

                   $scratch_card_offers = json_decode($getScratchCard->points);
                   $earning = rand($scratch_card_offers->min, $scratch_card_offers->max);

                   $earn = "You've won ₹ ".$earning;
                   /////referral by user//////
                    $userupdate = DB::table('users')
                                        ->where('referral_code', $referral_code)
                                        ->update(['wallet'=>$getReferredUser1->wallet + $earning]);
                    //////referral to user /////////
                      $userupdate2 = DB::table('users')
                                        ->where('user_phone', $user_phone)
                                        ->update(['wallet'=>$earning]);                   

                    }
                    else{
                        $message = array('status'=>'0', 'message'=>'wrong referral code', 'data'=>$checuss);
                        return $message;
                    }
                }
                 $updateDeviceId = DB::table('users')
    		                        ->where('user_phone', $phone)
    		                        ->update(['device_id'=>$device_id]);
                  $welcomemessage = $this->welmsg($user_name,$user_phone,$user_email);  
                  $welcomemail = $this->welmail($user_name,$user_phone,$user_email);
                  $user = User::where('user_phone', $phone)
                    ->first();
                 $token = $user->createToken('token')->accessToken;
                $message = array('status'=>1, 'message'=>"Phone Verified! login successfully",'data'=> $getUser, 'token'=>$token);
                return $message;
            }
            else{
                $message = array('status'=>0, 'message'=>"Wrong OTP", 'data'=>$checuss);
                return $message;
            }
       
        }
        else{
            $message = array('status'=>0, 'message'=>"User not registered", 'data'=>$checuss);
            return $message;
        }
        }
        else{
              $getUserr = DB::table('users')
                            ->where('user_phone', $phone)
                            ->update(['is_verified'=>1,
                            'otp_value'=>NULL]);

                 $user = User::where('user_phone', $phone)
                    ->first();
                 $token = $user->createToken('token')->accessToken;            
             $message = array('status'=>1, 'message'=>"Phone Verified! login successfully", 'data'=> $getUser, 'token'=>$token);
            return $message;
        }
    }


  public function loginverifyotpfirebase(Request $request)
    {
        $phone = $request->user_phone;
          $device_id = $request->device_id;
        $status = $request->status;
        	$checuss = DB::table('users')
                        ->first();
        $smsby = DB::table('smsby')
              ->first();
    
        // check for otp verify
        $getUser =  DB::table('users')
                  ->join('city','users.user_city','=','city.city_id')
                 ->join('society','users.user_area','=','society.society_id')
                  ->select('users.*','city.city_name','society.society_name')
                  ->where('users.user_phone', $phone)
                    ->first();
  
        if($getUser){
            
            if($status == "success"){
                // verify phone
                $getUser = DB::table('users')
                            ->where('user_phone', $phone)
                            ->update(['is_verified'=>1,
                            'otp_value'=>NULL]);
                 
                 	$Userdetails =  DB::table('users')
                  ->join('city','users.user_city','=','city.city_id')
                 ->join('society','users.user_area','=','society.society_id')
                  ->select('users.*','city.city_name','society.society_name')
                  ->where('users.user_phone', $phone)
                    ->first();

                      $user = User::where('user_phone', $phone)
                    ->first();
                    $updateDeviceId = DB::table('users')
    		                        ->where('user_phone', $phone)
    		                        ->update(['device_id'=>$device_id]);
                 $token = $user->createToken('token')->accessToken;   
                     
                $message = array('status'=>1, 'message'=>"Phone Verified! login successfully", 'data'=>$Userdetails, 'token'=>$token);
                return $message;
            }
            else{
                $message = array('status'=>0, 'message'=>"Wrong OTP", 'data'=>$checuss);
                return $message;
            }
       
        }
        else{
            $message = array('status'=>0, 'message'=>"User not registered", 'data'=>$checuss);
            return $message;
        }
        
    }
    
    
     public function loginverifyPhone(Request $request)
    {
        $phone = $request->user_phone;
          $device_id = $request->device_id;
        	$checuss = DB::table('users')
                        ->first();
        $otp = $request->otp;
        $smsby = DB::table('smsby')
              ->first();
        if($smsby->status==1){      
        // check for otp verify
        $getUser =  DB::table('users')
                  ->join('city','users.user_city','=','city.city_id')
                 ->join('society','users.user_area','=','society.society_id')
                  ->select('users.*','city.city_name','society.society_name')
                  ->where('users.user_phone', $phone)
                    ->first();
                    
        if($getUser){
            $getotp = $getUser->otp_value;
            
            if($otp == $getotp){
                // verify phone
                $getUser = DB::table('users')
                            ->where('user_phone', $phone)
                            ->update(['is_verified'=>1,
                            'otp_value'=>NULL]);
                 $Userdetails =  DB::table('users')
                          ->join('city','users.user_city','=','city.city_id')
                         ->join('society','users.user_area','=','society.society_id')
                          ->select('users.*','city.city_name','society.society_name')
                          ->where('users.user_phone', $phone)
                            ->first();
                    $user = User::where('user_phone', $phone)
                    ->first();
                 $token = $user->createToken('token')->accessToken; 
                   $updateDeviceId = DB::table('users')
    		                        ->where('user_phone', $phone)
    		                        ->update(['device_id'=>$device_id]);
                $message = array('status'=>1, 'message'=>"Phone Verified! login successfully" , 'data'=>$Userdetails, 'token'=>$token);
                return $message;
            }
            else{
                $message = array('status'=>0, 'message'=>"Wrong OTP", 'data'=>$checuss);
                return $message;
            }
       
        }
        else{
            $message = array('status'=>0, 'message'=>"User not registered", 'data'=>$checuss);
            return $message;
        }
        }
        else{
              $getUser = DB::table('users')
                            ->where('user_phone', $phone)
                            ->update(['is_verified'=>1,
                            'otp_value'=>NULL]);
             $message = array('status'=>1, 'message'=>"Phone Verified! login successfully", 'data'=>$checuss);
            return $message;
        }
    }





    public function login(Request $request)
    
     {
    	$user_phone = $request->user_phone;
    	$user_password = $request->user_password;
    	$device_id = $request->device_id;
    	$logintype = $request->logintype;
    	$checuss = DB::table('users')
                        ->first();
    	 $smsby = DB::table('smsby')
              ->first();
          $firebase = DB::table('firebase')
                  ->first();
            
    	$checkUser = DB::table('users')
    					->where('user_phone', $user_phone)
    					->first();
    	if($checkUser){
    	  if($smsby->status==1 && $firebase->status==0 && $logintype == "otp"){ 
    	    
    	       $chars = "0123456789";
                $otpval = "";
                for ($i = 0; $i < 4; $i++){
                    $otpval .= $chars[mt_rand(0, strlen($chars)-1)];
                }
                
               $otpmsg = $this->otpmsg($otpval,$user_phone);
    		   $updateDeviceId = DB::table('users')
    		                        ->where('user_phone', $user_phone)
    		                        ->update(['device_id'=>$device_id,
    		                        'otp_value'=>$otpval]);
    		                       
    		   $checkUser1 = DB::table('users')
            					->where('user_phone', $user_phone)
            					->first();
    		                        
    			$message = array('status'=>'2', 'message'=>'Verify OTP', 'data'=>$checkUser1);
	        	return $message;
    	   }
    	      elseif($firebase->status==1 && $logintype == "otp"){
    	          	$Userdetails = DB::table('users')
    					->where('user_phone', $user_phone)
    					->first();

                    $updateDeviceId = DB::table('users')
                                    ->where('user_phone', $user_phone)
                                    ->update(['device_id'=>$device_id]);

    			$message = array('status'=>'3', 'message'=>'Verify OTP via firebase', 'data'=>$Userdetails);
                return $message;	
    	      }
    	   else{
    		   $checkUserreg = DB::table('users')
            					->where('user_phone', $user_phone)
            				// 	->where('password', $user_password)
            					->first();
    
            if(Hash::check($user_password, $checkUserreg->password)){
    		   $updateDeviceId = DB::table('users')
    		                        ->where('user_phone', $user_phone)
    		                        ->update(['device_id'=>$device_id]);
    		                       
    		   $checkUser1 =  DB::table('users')
                   ->leftjoin('city','users.user_city','=','city.city_id')
                   ->leftjoin('society','users.user_area','=','society.society_id')
                  ->select('users.*','city.city_name','society.society_name')
                  ->where('users.user_phone', $user_phone)
            	  ->first();
            	  
    		         $user = User::where('user_phone', $user_phone)
                    ->first();
                 $token = $user->createToken('token')->accessToken;                   
    			$message = array('status'=>'1', 'message'=>'login successfully', 'data'=>$checkUser1, 'token'=>$token);
	        	return $message;
                 
    	   }
    	   else{
    		$message = array('status'=>'4', 'message'=>'Wrong Password', 'data'=>$checuss);
	        return $message;
    	}
    }
    
	}	else{
    		$message = array('status'=>'0', 'message'=>'Phone not Registered', 'data'=>$checuss);
	        return $message;
    	}
     }
    
    
    
    public function myprofile(Request $request)
    {   
        $user_id = $request->user_id;
         $user =  DB::table('users')
               ->join('city','users.user_city','=','city.city_id')
               ->join('society','users.user_area','=','society.society_id')
               ->select('users.*','city.city_name','society.society_name')
                ->where('users.id', $user_id )
                ->first();
                        
    if($user){
        	$message = array('status'=>'1', 'message'=>'User Profile', 'data'=>$user);
	        return $message;
              }
    	else{
    		$message = array('status'=>'0', 'message'=>'User not found', 'data'=>[]);
	        return $message;
    	}
        
    }   
    
    public function forgotPassword(Request $request)
    {
        $user_phone = $request->user_phone;
        $checuss = DB::table('users')
                        ->first();
        $checkUser = DB::table('users')
                        ->where('user_phone', $user_phone)
                        ->where('is_verified',1)
                        ->first();
                        
        if($checkUser){
                $chars = "0123456789";
                $otpval = "";
                for ($i = 0; $i < 4; $i++){
                    $otpval .= $chars[mt_rand(0, strlen($chars)-1)];
                }
                
               $otpmsg = $this->otpmsg($otpval,$user_phone);
    
                $updateOtp = DB::table('users')
                                ->where('user_phone', $user_phone)
                                ->update(['otp_value'=>$otpval]);
                                
            if($updateOtp){
              $checkUser1 = DB::table('users')
            					->where('user_phone', $user_phone)
            					->first();
    		                        
    			$message = array('status'=>'1', 'message'=>'Verify OTP', 'data'=>$checkUser1);
	        	return $message; 
            }
            else{
                $message = array('status'=>'0', 'message'=>'Something wrong', 'data'=>$checuss);
	        	return $message; 
            }
        }                
        else{
            $message = array('status'=>'0', 'message'=>'User not registered', 'data'=>$checuss);
	        return $message;
        }
        
    }
    
    public function verifyOtp(Request $request)
    {
        $phone = $request->user_phone;
        $otp = $request->otp;
        $checuss = DB::table('users')
                        ->first();
        // check for otp verify
        $getUser = DB::table('users')
                    ->where('user_phone', $phone)
                    ->first();
                    
        if($getUser){
            $getotp = $getUser->otp_value;
            
            if($otp == $getotp){
                $message = array('status'=>1, 'message'=>"Otp Matched Successfully", 'data'=>$getUser);
                return $message;
            }
            else{
                $message = array('status'=>0, 'message'=>"Wrong OTP", 'data'=>$getUser);
                return $message;
            }
        }
        else{
            $message = array('status'=>0, 'message'=>"User not registered", 'data'=>$checuss);
            return $message;
        }
    }
    
    public function changePassword(Request $request)
    {
        $user_phone = $request->user_phone;
        $password = Hash::make($request->user_password);
        	$checuss = DB::table('users')
                        ->first();
        $getUser = DB::table('users')
                    ->where('user_phone', $user_phone)
                    ->first();
                    
        if($getUser){
            $updateOtp = DB::table('users')
                            ->where('user_phone', $user_phone)
                            ->update(['password'=>$password]);
                                
            if($updateOtp){
              $checkUser1 = DB::table('users')
            					->where('user_phone', $user_phone)
            					->first();
    		                        
    			$message = array('status'=>'1', 'message'=>'Password changed', 'data'=>$checkUser1);
	        	return $message; 
            }
            else{
                $message = array('status'=>'0', 'message'=>'Use Another Password', 'data'=>$checuss);
	        	return $message; 
            }
        }
        else{
            $message = array('status'=>0, 'message'=>"User not registered", 'data'=>$checuss);
            return $message;
        }
    }
    
    
     public function profile_edit(Request $request)
    {
        $user_id = $request->user_id;
        $checuss = DB::table('users')
                        ->first();
    	$user_name = $request->user_name;
    	$user_city = $request->user_city;
    	$user_area = $request->user_area;
    	$user_email = $request->user_email;
    	$user_phone = $request->user_phone;
    	$user_image = $request->user_image;
    		$uu = DB::table('users')
    	    ->where('id', $user_id)
    	    ->first();
    	$user_password = $uu->password;
           $date=date('d-m-Y');
    	    
    	  if($request->user_image){
    	     $image = $request->user_image;
            $fileName = $image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
           

           if($this->storage_space != "same_server"){
                $image_name = $image->getClientOriginalName();
                $image = $request->file('user_image');
                $filePath = '/user/'.$image_name;
                Storage::disk($this->storage_space)->put($filePath, fopen($request->file('user_image'), 'r+'), 'public');
            }
            else{
           
           $image->move('images/user/'.$date.'/', $fileName);
            $filePath = '/images/user/'.$date.'/'.$fileName;
        
            }
        }
            else{
                $filePath = $uu->user_image;
            }
        
        $checkUser = DB::table('users')
    			->where('user_phone', $user_phone)
    			->where('id','!=', $user_id)
    			->first();
    	if($checkUser && $checkUser->is_verified==1){
    		$message = array('status'=>'0', 'message'=>'This Phone number is attached with another account', 'data'=>	$checuss);
            return $message;
    	}
    	
        else{
        
    		$insertUser = DB::table('users')
    		            ->where('id', $user_id)
    						->update([
    							'name'=>$user_name,
    							'email'=>$user_email,
    							'user_city'=>$user_city,
    							'user_area'=>$user_area,
    							'user_phone'=>$user_phone,
    							'user_image'=>$filePath,
    							'password'=>$user_password,
    						]);
    						
            	$Userdetails = DB::table('users')
    					->where('id', $user_id)
    					->first();
    					
    					
    		if($insertUser){
    						
	    		$message = array('status'=>'1', 'message'=>'Profile Updated', 'data'=>$Userdetails);
	        	return $message;
	    	}
	    	else{
	    		$message = array('status'=>'0', 'message'=>'Something Went wrong', 'data'=>	$checuss);
	        return $message;
	    	}  
    	}
    }
    
      public function user_block_check(Request $request)
    {   
        $user_id = $request->user_id;
         $user =  DB::table('users')
                ->select('block')
                ->where('id', $user_id )
                ->first();
                        
    if($user){
        if($user->block==1){
        	$message = array('status'=>'1', 'message'=>'User is Blocked');
	        return $message;
        }else{
            	$message = array('status'=>'2', 'message'=>'User is Active');
	        return $message;
            }
         }
    	else{
    		$message = array('status'=>'0', 'message'=>'User not found');
	        return $message;
    	}
        
    }   
    
    
    public function resendotp(Request $request)
    {
        $user_phone = $request->user_phone;
       $chars ="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                    $otpval = "";
                    for ($i = 0; $i < 5; $i++){
                       $otpval .= $chars[mt_rand(0, strlen($chars)-1)];
                    }
        	$checuss = DB::table('users')
                        ->first();
        $smsby = DB::table('smsby')
              ->first();
              
         $firebase = DB::table('firebase')
              ->first();      
    
        // check for otp verify
        $getUser = DB::table('users')
                    ->where('user_phone', $user_phone)
                    ->first();
  
        if($getUser){
            if($firebase->status==1){
              $getUserup = DB::table('users')
                            ->where('user_phone', $user_phone)
                            ->update(['otp_value'=>NULL]);
                            
                $message = array('status'=>'2', 'message'=>'Otp sent via firebase', 'data'=>$getUser);
                return $message;	            
            }
            elseif($smsby->status == 1){
                $getUserup = DB::table('users')
                            ->where('user_phone', $user_phone)
                            ->update(['otp_value'=>$otpval]);
                            
                $otpmsg = $this->otpmsg($otpval,$user_phone);            
                $message = array('status'=>'1', 'message'=>'Otp sent', 'data'=>$getUser);
                return $message;	 
            }else{
                 $message = array('status'=>'0', 'message'=>'Otp Off', 'data'=>$getUser);
                return $message;
            }
         
       
        }
        else{
            $message = array('status'=>0, 'message'=>"User not found", 'data'=>	$checuss);
            return $message;
        }
        
    }
    
     public function deletenum(Request $request)
    {
       $user_phone = $request->user_phone;
       $del = DB::table('users')
            ->where('user_phone', $user_phone)
            ->delete();
        if($del){
             $message = array('status'=>1, 'message'=>"User Number Deleted");
            return $message;
        }else{
             $message = array('status'=>0, 'message'=>"not found");
            return $message;
        }    
    }
    

  public function validates(Request $request)
    {
      
            return response()->json(['error' => 'UnAuthorised'], 401);
        
    }

}
