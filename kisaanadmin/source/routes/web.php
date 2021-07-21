
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
//Admin Controllers
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TwilioController;
use App\Http\Controllers\Admin\MapController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VarientController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\SocietyController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\TimeSlotController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\AdminorderController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\RewardController;
use App\Http\Controllers\Admin\ReedemController;
use App\Http\Controllers\Admin\SecondaryBannerController;
use App\Http\Controllers\Admin\SecretloginController;
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\Admin\HideController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\ImportExcelController;
use App\Http\Controllers\Admin\SalesreportController;
use App\Http\Controllers\Admin\RequiredController;
use App\Http\Controllers\Admin\ProductapproveController;
use App\Http\Controllers\Admin\StorehideController;
use App\Http\Controllers\Admin\PayoutController;
use App\Http\Controllers\Admin\ReasonController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\PayController;
use App\Http\Controllers\Admin\StorecallbackController;
use App\Http\Controllers\Admin\DrivercallbackController;
use App\Http\Controllers\Admin\UsercallbackController;
use App\Http\Controllers\Admin\UserwalletController;
use App\Http\Controllers\Admin\SubController;
use App\Http\Controllers\Admin\OrderstatussController;

//Store Controllers
use App\Http\Controllers\Store\AssignHomecateController;
use App\Http\Controllers\Store\AssignorderController;
use App\Http\Controllers\Store\ByphotoController;
use App\Http\Controllers\Store\CallbackController;
use App\Http\Controllers\Store\CouponController;
use App\Http\Controllers\Store\DealController;
use App\Http\Controllers\Store\DeliveryboyController;
use App\Http\Controllers\Store\DriverfinanceController;
use App\Http\Controllers\Store\HomecateController;
use App\Http\Controllers\Store\StoreHomeController;
use App\Http\Controllers\Store\ImpexcelController;
use App\Http\Controllers\Store\InvoiceController;
use App\Http\Controllers\Store\StoreLoginController;
use App\Http\Controllers\Store\StorePayoutController;
use App\Http\Controllers\Store\PriceController;
use App\Http\Controllers\Store\StProductController;
use App\Http\Controllers\Store\StRequiredController;
use App\Http\Controllers\Store\StSalesreportController;
use App\Http\Controllers\Store\StoreassignHomecateController;
use App\Http\Controllers\Store\StorebannerController;
use App\Http\Controllers\Store\StorehomecateController;
use App\Http\Controllers\Store\StoreordersController;
use App\Http\Controllers\Store\StoreProductController;
use App\Http\Controllers\Store\StoreregController;
use App\Http\Controllers\Store\StoreTimeslotController;
use App\Http\Controllers\Store\StoreVarientController;
use App\Http\Controllers\Store\UsrnotificationController;



use App\Http\Controllers\Installer\InstallController;

use Illuminate\Http\Request;

Route::get('/clear-all', function () {
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "Cache, route, view, config is cleared";
});


Route::get('verifyLicense', [InstallController::class,'verifyLicense'])->name('verifyLicense');

Route::group(['middleware' => ['verifylicense']], function () {
    Route::get('installFinish', [InstallController::class,'installFinish'])->name('installFinish');

    Route::get('/', [InstallController::class,'requirement']);    

    Route::get('requirement', [InstallController::class,'requirement']);
    
    Route::get('verify', [InstallController::class,'verify'])->name('verify');
    Route::post('verifyPost', [InstallController::class,'verifyPost'])->name('verifyPost');

    Route::get('databaseinst', [InstallController::class,'databaseinst'])->name('databaseinst');   

    Route::post('databasePost', [InstallController::class,'databasePost'])->name('databasePost');

    Route::post('databaseVerifyPost', function () {
        Artisan::call('config:cache');
        Artisan::call('config:clear');

        return app(\App\Http\Controllers\Installer\InstallController::class)->databaseVerifyPost();
    });

Route::namespace("Admin")->prefix('admin')->group(function () {
    Route::get('/', [LoginController::class,'adminLogin'])->name('adminLogin');
    Route::get('/login', [LoginController::class,'adminLogin'])->name('login');
    Route::post('loginCheck', [LoginController::class,'adminLoginCheck'])->name('adminLoginCheck');
    Route::post('reset_pass', [AuthController::class,'reset_pass'])->name('reset_pass');
    Route::get('adminlogout', [LoginController::class,'logout'])->name('adminlogout');

   
    Route::group(['middleware' => 'auth:admin'], function () {

           Route::get('logout', [LoginController::class,'logout'])->name('logout');
        Route::get('home', [HomeController::class,'adminHome'])->name('adminHome');
        Route::get('profile', [ProfileController::class,'adminProfile'])->name('prof');
        Route::post('profile/update/{id}', [ProfileController::class,'adminUpdateProfile'])->name('updateprof');
        Route::get('password/change', [ProfileController::class,'adminChangePass'])->name('passchange');
        Route::post('password/update/{id}', [ProfileController::class,'adminChangePassword'])->name('updatepass');

        /////settings/////
        Route::get('global_settings', [SettingsController::class,'app_details'])->name('app_details');
        Route::post('app_details/update', [SettingsController::class,'updateappdetails'])->name('updateappdetails');
  
  
        Route::get('msgby', [SettingsController::class,'msg91'])->name('msg91');
        Route::post('msg91/update', [SettingsController::class,'updatemsg91'])->name('updatemsg91');
        Route::post('twilio/update', [TwilioController::class,'updatetwilio'])->name('updatetwilio');
        Route::post('msgoff', [TwilioController::class,'msgoff'])->name('msgoff');
  
        Route::get('map_api', [MapController::class,'mapsettings'])->name('mapapi');
        Route::post('map_api/update', [MapController::class,'updategooglemap'])->name('updatemap');
        Route::post('mapbox/update', [MapController::class,'updatemapbox'])->name('updatemapbox');
  
        Route::get('app_settings', [SettingsController::class,'fcm'])->name('app_settings');
        Route::post('app_settings/update', [SettingsController::class,'updatefcm'])->name('updatefcm');
  

        ////notification
        Route::get('Notification', [NotificationController::class,'adminNotification'])->name('adminNotification');
        Route::post('Notification_to_store/send', [NotificationController::class,'Notification_to_store_Send'])->name('adminNotificationSendtostore');
  
  
        Route::post('currency/update', [SettingsController::class,'updatecurrency'])->name('updatecurrency');
        ///////category////////
        Route::get('category/list', [CategoryController::class,'list'])->name('catlist');
        Route::get('category/add', [CategoryController::class,'AddCategory'])->name('AddCategory');
        Route::post('category/add/new', [CategoryController::class,'AddNewCategory'])->name('AddNewCategory');
        Route::get('category/edit/{category_id}', [CategoryController::class,'EditCategory'])->name('EditCategory');
        Route::post('category/update/{category_id}', [CategoryController::class,'UpdateCategory'])->name('UpdateCategory');
        Route::get('category/delete/{category_id}', [CategoryController::class,'DeleteCategory'])->name('DeleteCategory');
        Route::post('change-postion', [CategoryController::class,'changePostion'])->name('change-postion');


  ///////sub category////////
        Route::get('sub-category/list', [SubController::class,'list'])->name('subcatlist');
        Route::get('sub-category/add', [SubController::class,'AddCategory'])->name('AddsubCategory');
        Route::get('sub-category/edit/{category_id}', [SubController::class,'EditCategory'])->name('EditsubCategory');
        ///////Product////////
        Route::get('product/list', [ProductController::class,'list'])->name('productlist');
        Route::get('product/add', [ProductController::class,'AddProduct'])->name('AddProduct');
        Route::post('product/add/new', [ProductController::class,'AddNewProduct'])->name('AddNewProduct');
        Route::get('product/edit/{product_id}', [ProductController::class,'EditProduct'])->name('EditProduct');
        Route::post('product/update/{product_id}', [ProductController::class,'UpdateProduct'])->name('UpdateProduct');
        Route::get('product/delete/{product_id}', [ProductController::class,'DeleteProduct'])->name('DeleteProduct');
  
  
        //////Product Varient//////////
        Route::get('varient/{id}', [VarientController::class,'varient'])->name('varient');
        Route::get('varient/add/{id}', [VarientController::class,'Addproduct'])->name('add-varient');
        Route::post('varient/add/new', [VarientController::class,'AddNewproduct'])->name('AddNewvarient');
        Route::get('varient/edit/{id}', [VarientController::class,'Editproduct'])->name('edit-varient');
        Route::post('varient/update/{id}', [VarientController::class,'Updateproduct'])->name('update-varient');
        Route::get('varient/delete/{id}', [VarientController::class,'deleteproduct'])->name('delete-varient');

        ///////Delivery Boy////////
        Route::get('d_boy/list', [DeliveryController::class,'list'])->name('d_boylist');
        Route::get('d_boy/add', [DeliveryController::class,'AddD_boy'])->name('AddD_boy');
        Route::post('d_boy/add/new', [DeliveryController::class,'AddNewD_boy'])->name('AddNewD_boy');
        Route::get('d_boy/edit/{id}', [DeliveryController::class,'EditD_boy'])->name('EditD_boy');
        Route::post('d_boy/update/{id}', [DeliveryController::class,'UpdateD_boy'])->name('UpdateD_boy');
        Route::get('d_boy/delete/{id}', [DeliveryController::class,'DeleteD_boy'])->name('DeleteD_boy');
  
        ///////User////////
        Route::get('user/list', [UserController::class,'list'])->name('userlist');
        Route::get('user/block/{id}', [UserController::class,'block'])->name('userblock');
        Route::get('user/unblock/{id}', [UserController::class,'unblock'])->name('userunblock');
        // for city
        Route::get('citylist', [CityController::class,'citylist'])->name('citylist');
        Route::get('city', [CityController::class,'city'])->name('city');
        Route::post('cityadd', [CityController::class,'cityadd'])->name('cityadd');
        Route::get('cityedit/{city_id}', [CityController::class,'cityedit'])->name('cityedit');
        Route::post('cityupdate', [CityController::class,'cityupdate'])->name('cityupdate');
        Route::get('citydelete/{city_id}', [CityController::class,'citydelete'])->name('citydelete');
        // for society
        Route::get('societylist', [SocietyController::class,'societylist'])->name('societylist');
        Route::get('society', [SocietyController::class,'society'])->name('society');
        Route::post('societyadd', [SocietyController::class,'societyadd'])->name('societyadd');
        Route::get('societyedit/{society_id}', [SocietyController::class,'societyedit'])->name('societyedit');
        Route::post('societyupdate', [SocietyController::class,'societyupdate'])->name('societyupdate');
        Route::get('societydelete/{society_id}', [SocietyController::class,'societydelete'])->name('societydelete');
        // for banner
        Route::get('bannerlist', [BannerController::class,'bannerlist'])->name('bannerlist');
        Route::get('banner', [BannerController::class,'banner'])->name('banner');
        Route::post('banneradd', [BannerController::class,'banneradd'])->name('banneradd');
        Route::get('banneredit/{banner_id}', [BannerController::class,'banneredit'])->name('banneredit');
        Route::post('bannerupdate/{banner_id}', [BannerController::class,'bannerupdate'])->name('bannerupdate');
        Route::get('bannerdelete/{society_id}', [BannerController::class,'bannerdelete'])->name('bannerdelete');
 



        // for delivery time
        Route::get('timeslot', [TimeSlotController::class,'timeslot'])->name('timeslot');
        Route::post('timeslotupdate', [TimeSlotController::class,'timeslotupdate'])->name('timeslotupdate');
        Route::get('closehour', [ClosehourController::class,'closehour'])->name('closehour');
        Route::post('closehrsupdate', [ClosehourController::class,'closehrsupdate'])->name('closehrsupdate');
        // for store
        Route::get('admin/store/list', [StoreController::class,'storeclist'])->name('storeclist');
        Route::get('admin/store/add', [StoreController::class,'store'])->name('store');
        Route::post('admin/store/added', [StoreController::class,'storeadd'])->name('storeadd');
        Route::get('admin/store/edit/{store_id}', [StoreController::class,'storedit'])->name('storedit');
        Route::post('admin/store/update/{store_id}', [StoreController::class,'storeupdate'])->name('storeupdate');
        Route::get('admin/store/delete/{store_id}', [StoreController::class,'storedelete'])->name('storedelete');
        //store orders//
        Route::get('admin/store/orders/{id}', [AdminorderController::class,'admin_store_orders'])->name('admin_store_orders');
        Route::get('admin/store/cancelledorders', [AdminorderController::class,'store_cancelled'])->name('store_cancelled');
        //assign store//
        Route::post('admin/store/assign/{id}', [AdminorderController::class,'assignstore'])->name('store_assign');
  
        Route::get('finance', [FinanceController::class,'finance'])->name('finance');
        Route::post('store_pay/{store_id}', [FinanceController::class,'store_pay'])->name('store_pay');
  
  
        /////pages////////
  
        Route::get('about_us', [PagesController::class,'about_us'])->name('about_us');
        Route::post('about_us/update', [PagesController::class,'updateabout_us'])->name('updateabout_us');
   
        Route::get('terms', [PagesController::class,'terms'])->name('terms');
        Route::post('terms/update', [PagesController::class,'updateterms'])->name('updateterms');
   
        Route::get('prv', [SettingsController::class,'prv'])->name('prv');
        Route::post('prv/update', [SettingsController::class,'updateprv'])->name('updateprv');
  
        // for reward
        Route::get('RewardList', [RewardController::class,'RewardList'])->name('RewardList');
        Route::get('reward', [RewardController::class,'reward'])->name('reward');
        Route::post('rewardadd', [RewardController::class,'rewardadd'])->name('rewardadd');
        Route::get('rewardedit/{reward_id}', [RewardController::class,'rewardedit'])->name('rewardedit');
        Route::post('rewardupate', [RewardController::class,'rewardupate'])->name('rewardupate');
        Route::get('rewarddelete/{reward_id}', [RewardController::class,'rewarddelete'])->name('rewarddelete');
 
        // for reedem
        Route::get('reedem', [ReedemController::class,'reedem'])->name('reedem');
        Route::post('reedemupdate', [ReedemController::class,'reedemupdate'])->name('reedemupdate');
  
        ////store payout////
        Route::get('payout_req', [PayoutController::class,'pay_req'])->name('pay_req');
        Route::post('payout_req/{req_id}', [PayoutController::class,'store_pay'])->name('com_payout');
  
        // for  Secondary banner
        Route::get('secbannerlist', [SecondaryBannerController::class,'secbannerlist'])->name('secbannerlist');
        Route::get('secbanner', [SecondaryBannerController::class,'secbanner'])->name('secbanner');
        Route::post('secbanneradd', [SecondaryBannerController::class,'secbanneradd'])->name('secbanneradd');
        Route::get('secbanneredit/{sec_banner_id}', [SecondaryBannerController::class,'secbanneredit'])->name('secbanneredit');
        Route::post('secbannerupdate/{sec_banner_id}', [SecondaryBannerController::class,'secbannerupdate'])->name('secbannerupdate');
        Route::get('secbannerdelete/{sec_banner_id}', [SecondaryBannerController::class,'secbannerdelete'])->name('secbannerdelete');
 
        Route::get('admin/d_boy/orders/{id}', [AdminorderController::class,'admin_dboy_orders'])->name('admin_dboy_orders');
        //assign delivery boy//
        Route::post('admin/d_boy/assign/{id}', [AdminorderController::class,'assigndboy'])->name('dboy_assign');
        ////completed orders/////
        Route::get('admin/completed_orders', [AdminorderController::class,'admin_com_orders'])->name('admin_com_orders');
        ////Pending orders/////
        Route::get('admin/pending_orders', [AdminorderController::class,'admin_pen_orders'])->name('admin_pen_orders');
     
        Route::post('admin/reject/order/{id}', [AdminorderController::class,'rejectorder'])->name('admin_reject_order');
        Route::get('admin/cancelled_orders', [AdminorderController::class,'admin_can_orders'])->name('admin_can_orders');
        Route::get('payment_gateway', [PayController::class,'payment_gateway'])->name('gateway');
        Route::post('payment_gateway/update', [PayController::class,'updatepymntvia'])->name('updategateway');
  
  
        ////approval waiting list////
        Route::get('waiting_for_approval/stores/list', [ApprovalController::class,'storeclist'])->name('storeapprove');
        Route::get('approved/stores/{id}', [ApprovalController::class,'storeapproved'])->name('storeapproved');
  
  


    
        Route::get('user/delete/{id}', [UserController::class,'del_user'])->name('del_userfromlist');
   
        Route::get('changeStatus', [HideController::class,'hideproduct'])->name('hideprod');
        Route::get('app_notice', [NoticeController::class,'adminnotice'])->name('app_notice');
        Route::post('app_notice/update', [NoticeController::class,'adminupdatenotice'])->name('app_noticeupdate');
        Route::get('updatefirebase', [HideController::class,'updatefirebase'])->name('updatefirebase');
        /// for bulk upload
   
        Route::get('bulk/upload', [ImportExcelController::class,'bulkup'])->name('bulkup');
        Route::post('bulk_upload', [ImportExcelController::class,'import'])->name('bulk_upload');
        Route::post('bulk_v_upload', [ImportExcelController::class,'import_varients'])->name('bulk_v_upload');
    
        Route::get('orders/today/all/', [SalesreportController::class,'sales_today'])->name('sales_today');
        Route::post('orders/day-wise/', [SalesreportController::class,'orders'])->name('datewise_orders');
        Route::post('user/list/day-wise/', [UserController::class,'daywise'])->name('daywise_reg');
        Route::get('item_sale_report/by_store/', [RequiredController::class,'storeclist'])->name('item_sale_rep');
  
        Route::get('required/itemlist/today/store/{id}', [RequiredController::class,'reqfortoday'])->name('req_items_today');
        Route::post('required/itemlist/store/day-wise/{id}', [RequiredController::class,'reqdaywise'])->name('datewise_itemsalesreport');
 
        Route::post('storehide/{id}', [StorehideController::class,'off'])->name('storehide');
        Route::get('storeunhide/{id}', [StorehideController::class,'on'])->name('storeunhide');
  
        Route::post('firebase/iso_code', [SettingsController::class,'updatefirebase_iso'])->name('updatefirebase_iso');
        Route::post('update/ref', [SettingsController::class,'updateref'])->name('updateref');
 

        ///////Store Products////////
        Route::get('store_products/list', [ProductapproveController::class,'list'])->name('st_plist');
        Route::get('store_products/approve/{id}', [ProductapproveController::class,'approve'])->name('st_p_approve');
        Route::get('store_products/reject/{id}', [ProductapproveController::class,'reject'])->name('st_p_reject');
        //////incentive////
        Route::post('incentive', [SettingsController::class,'updateincentive'])->name('up_admin_incentive');

        Route::get('dboy_incentive', [FinanceController::class,'boy_incentive'])->name('boy_incentive');
        Route::post('dboy_pay/{dboy_id}', [FinanceController::class,'incentive_pay'])->name('incentive_pay');
        Route::get('store/missed/orders', [AdminorderController::class,'missed_orders'])->name('missed_orders');
        Route::get('status/change/{cart_id}', [OrderstatussController::class,'change'])->name('changeStatus');
        //assign delivery boy//
        Route::post('d_boy/assign/{id}', [OrderstatussController::class,'assigndboy'])->name('ad_dboy_assign');
        Route::get('total-item-sales-report/last-30-days', [RequiredController::class,'ad_reqforthirty'])->name('admin_reqforthirty');
        Route::get('order_report', [DeliveryController::class,'boy_reports'])->name('ad_boy_reports');
  
        ////notification to Driver
        Route::get('Notification-to-driver', [NotificationController::class,'adminNotificationdriver'])->name('adminNotificationdriver');
        Route::post('Notification-to-driver/send', [NotificationController::class,'Notification_to_driver_Send'])->name('adminNotificationSendtodriver');
  
          
        Route::get('cancelling_reasons/list', [ReasonController::class,'can_res_list'])->name('can_res_list');
        Route::get('cancelling_reasons/add', [ReasonController::class,'can_res_add'])->name('can_res_add');
        Route::post('cancelling_reasons/added', [ReasonController::class,'can_res_added'])->name('can_res_added');
        Route::get('cancelling_reasons/edit/{res_id}', [ReasonController::class,'can_res_edit'])->name('can_res_edit');
        Route::post('cancelling_reasons/updated/', [ReasonController::class,'can_res_edited'])->name('can_res_edited');
        Route::get('cancelling_reasons/delete/{res_id}', [ReasonController::class,'can_res_del'])->name('can_res_del');
 
        Route::post('gateway_option/change', [PayController::class,'gateway_status'])->name('gateway_status');
 
        Route::get('user_feedback/list', [FeedbackController::class,'user_feedback'])->name('user_feedback');
        Route::get('store_feedback/list', [FeedbackController::class,'store_feedback'])->name('store_feedback');
        Route::get('driver_feedback/list', [FeedbackController::class,'driver_feedback'])->name('driver_feedback');
 
    
        Route::get('store_callback_requests', [StorecallbackController::class,'storecallbacklist'])->name('store_callback_requests');
 
        Route::get('store_callbackproc/{id}', [StorecallbackController::class,'store_call_proc'])->name('store_callbackproc');
  
        Route::get('driver_callback_requests', [DrivercallbackController::class,'drivercallbacklist'])->name('driver_callback_requests');
 
        Route::get('driver_callbackproc/{id}', [DrivercallbackController::class,'driver_call_proc'])->name('driver_callbackproc');
  
  
        Route::get('user_callback_requests', [UsercallbackController::class,'usercallbacklist'])->name('user_callback_requests');
 
        Route::get('user_callbackproc/{id}', [UsercallbackController::class,'user_call_proc'])->name('user_callbackproc');
        Route::get('updatereferral', [SettingsController::class,'updatereferral'])->name('updatereferral_codes');
        Route::post('app_link', [SettingsController::class,'app_link'])->name('app_link');
        Route::get('user_wallet_recharge_history', [UserwalletController::class,'list'])->name('user_wallet');
        Route::post('usr_recharge/{id}', [UserwalletController::class,'pay'])->name('usr_recharge');
        Route::post('updatespace', [SettingsController::class,'updatespace'])->name('updatespace');
        
        //////notification to user
         Route::get('Notification-to-users', [NotificationController::class,'adminNotificationuser'])->name('adminNotificationuser');
        Route::post('Notification-to-users/send', [NotificationController::class,'userNotificationSend'])->name('userNotificationSend');
        
         Route::get('user/edit/{id}', [UserController::class,'ed_user'])->name('ed_user');
          Route::post('user/update/{id}', [UserController::class,'up_user'])->name('up_user');
          
            Route::get('bulk/upload/city-society', [ImportExcelController::class,'bulkupcity'])->name('bulkupcity');
        Route::post('bulk_upload/city', [ImportExcelController::class,'importcity'])->name('importcity');
        Route::post('bulk_society_upload', [ImportExcelController::class,'importsociety'])->name('importsociety');

    });
});

Route::get('lang/change', [LanguageController::class,'change'])->name('changeLang');


Route::namespace("Store")->prefix('store')->group(function () {

    // for login
    Route::get('/', [StoreLoginController::class,'storeLogin'])->name('storeLogin');
      Route::get('secret-store-login/{id}', [StoreLoginController::class,'secretStoreLogin'])->name('secret-store-login');
     Route::get('secret-store-login1', [StoreLoginController::class,'secretStoreLogin1'])->name('secret-store-login1'); 
    Route::get('store_register/', [StoreregController::class,'register_store'])->name('store_register');
    Route::post('store_registered/', [StoreregController::class,'store_registered'])->name('store_registered');
    Route::post('loginCheck', [StoreLoginController::class,'storeLoginCheck'])->name('storeLoginCheck');

   // Route::auth();

    Route::group(['middleware' => 'auth:store'], function () {    
         Route::get('logout', [StoreLoginController::class,'logout'])->name('storelogout');
        Route::get('home', [StoreHomeController::class,'storeHome'])->name('storeHome');
        Route::get('product/add', [StProductController::class,'sel_product'])->name('sel_product');
        Route::post('product/added', [StProductController::class,'added_product'])->name('added_product');
        Route::get('product/delete/{id}', [StProductController::class,'delete_product'])->name('delete_product');
        Route::post('product/stock/{id}', [StProductController::class,'stock_update'])->name('stock_update');
        Route::get('logout/', [StoreLoginController::class,'logout'])->name('storelogout');
        Route::get('orders/next_day', [AssignorderController::class,'orders'])->name('storeOrders');
        Route::get('orders/today', [AssignorderController::class,'assignedorders'])->name('storeassignedorders');
        Route::post('orders/confirm/{cart_id}', [AssignorderController::class,'confirm_order'])->name('store_confirm_order');
        Route::get('orders/reject/{cart_id}', [OrderController::class,'reject_order'])->name('store_reject_order');
        Route::post('orders/products/cancel/{store_order_id}', [OrderController::class,'cancel_products'])->name('store_cancel_product');
     
        Route::get('update/stock', [StProductController::class,'st_product'])->name('st_product');
        Route::get('payout/request', [StorePayoutController::class,'payout_req'])->name('payout_req');
        Route::post('payout/request/sent', [StorePayoutController::class,'req_sent'])->name('payout_req_sent');

        Route::get('store/invoice/{cart_id}', [InvoiceController::class,'invoice'])->name('invoice');
        Route::get('store/pdf/invoice/{cart_id}', [InvoiceController::class,'pdfinvoice'])->name('pdfinvoice');
        Route::get('products/price', [PriceController::class,'stt_product'])->name('stt_product');
        Route::post('product/price/update/{id}', [PriceController::class,'price_update'])->name('price_update');

        Route::get('bulk/upload', [ImpexcelController::class,'bulkup'])->name('bulkuprice');
        Route::post('bulk_upload/price', [ImpexcelController::class,'import'])->name('bulk_uploadprice');
        Route::post('bulk_upload/stock', [ImpexcelController::class,'importstock'])->name('bulk_uploadstock');


        Route::get('itemlist/requirement/today', [StRequiredController::class,'reqfortoday'])->name('reqfortoday');
        Route::post('itemlist/requirement/datewise', [StRequiredController::class,'reqfordate'])->name('datewise_itemsales');

        Route::get('store_orders/today/all/', [StSalesreportController::class,'sales_today'])->name('store_sales_today');
        Route::post('store_orders/day-wise/', [StSalesreportController::class,'orders'])->name('store_datewise_orders');

        Route::get('store/orderbyphoto/', [ByphotoController::class,'user_list'])->name('storeorder_byphoto');
        Route::get('store/makeorder/{id}', [ByphotoController::class,'sel_product'])->name('store_accept_order');
        Route::post('list/product/added/', [ByphotoController::class,'added_product'])->name('listadded_product');
        Route::get('admin/reject/orderlist/{id}', [ByphotoController::class,'rejectorder'])->name('admin_reject_orderphoto');

        Route::get('list/product/delete_from_cart/{id}', [ByphotoController::class,'delete_product'])->name('delete_product_from_cart');
        Route::post('list/product/add_qty/{id}', [ByphotoController::class,'add_qty'])->name('add_qty_to_cart');
        Route::post('reject/order/{id}', [ByphotoController::class,'rejectorder'])->name('store_reject_orderbyphoto');
        Route::get('order/processed/{ord_id}', [ByphotoController::class,'checkout'])->name('process_orderby');

        Route::get('storebannerlist', [StorebannerController::class,'bannerlist'])->name('storebannerlist');
        Route::get('storebanner', [StorebannerController::class,'banner'])->name('storebanner');
        Route::post('storebanneradd', [StorebannerController::class,'banneradd'])->name('storebanneradd');
        Route::get('storebanneredit/{banner_id}', [StorebannerController::class,'banneredit'])->name('storebanneredit');
        Route::post('storebannerupdate/{banner_id}', [StorebannerController::class,'bannerupdate'])->name('storebannerupdate');
        Route::get('storebannerdelete/{banner_id}', [StorebannerController::class,'bannerdelete'])->name('storebannerdelete');


        Route::get('deal/list', [DealController::class,'list'])->name('deallist');
        Route::get('deal/add', [DealController::class,'AddDeal'])->name('AddDeal');
        Route::post('deal/add/new', [DealController::class,'AddNewDeal'])->name('AddNewDeal');
        Route::get('deal/edit/{id}', [DealController::class,'EditDeal'])->name('EditDeal');
        Route::post('deal/update/{id}', [DealController::class,'UpdateDeal'])->name('UpdateDeal');
        Route::get('deal/delete/{id}', [DealController::class,'DeleteDeal'])->name('DeleteDeal');

  
        Route::get('store/timeslot', [StoreTimeslotController::class,'timeslot'])->name('storetimeslot');
        Route::post('store/timeslotupdate', [StoreTimeslotController::class,'timeslotupdate'])->name('storetimeslotupdate');
        Route::post('amountupdate', [StoreTimeslotController::class,'amountupdate'])->name('amountupdate');
        Route::post('del_charge/update', [StoreTimeslotController::class,'updatedel_charge'])->name('updatedel_charge');

        Route::get('special/product/list', [StoreProductController::class,'list'])->name('storeproductlist');
        Route::get('special/product/add', [StoreProductController::class,'AddProduct'])->name('storeAddProduct');
        Route::post('special/product/add/new', [StoreProductController::class,'AddNewProduct'])->name('storeAddNewProduct');
        Route::get('special/product/edit/{product_id}', [StoreProductController::class,'EditProduct'])->name('storeEditProduct');
        Route::post('special/product/update/{product_id}', [StoreProductController::class,'UpdateProduct'])->name('storeUpdateProduct');
        Route::get('special/product/delete/{product_id}', [StoreProductController::class,'DeleteProduct'])->name('storeDeleteProduct');

        Route::get('special/varient/{id}', [StoreVarientController::class,'varient'])->name('storevarient');
        Route::get('special/varient/add/{id}', [StoreVarientController::class,'Addproduct'])->name('storeadd-varient');
        Route::post('special/varient/add/new', [StoreVarientController::class,'AddNewproduct'])->name('storeAddNewvarient');
        Route::get('special/varient/edit/{id}', [StoreVarientController::class,'Editproduct'])->name('storeedit-varient');
        Route::post('special/varient/update/{id}', [StoreVarientController::class,'Updateproduct'])->name('storeupdate-varient');
        Route::get('special/varient/delete/{id}', [StoreVarientController::class,'deleteproduct'])->name('storedelete-varient');


        Route::get('callback_requests', [CallbackController::class,'callbacklist'])->name('callback_requests');
        Route::get('callbackproc/{id}', [CallbackController::class,'call_proc'])->name('callbackproc');

        Route::get('Notification', [UsrnotificationController::class,'storeNotification'])->name('storeNotification');
        Route::post('Notification/send', [UsrnotificationController::class,'storeNotificationSend'])->name('storeNotificationSend');

        Route::get('couponlist', [CouponController::class,'couponlist'])->name('couponlist');
        Route::get('coupon', [CouponController::class,'coupon'])->name('coupon');
        Route::post('addcoupon', [CouponController::class,'addcoupon'])->name('addcoupon');
        Route::get('editcoupon/{coupon_id}', [CouponController::class,'editcoupon'])->name('editcoupon');
        Route::post('updatecoupon', [CouponController::class,'updatecoupon'])->name('updatecoupon');
        Route::get('deletecoupon/{coupon_id}', [CouponController::class,'deletecoupon'])->name('deletecoupon');

        Route::get('store/completed_orders', [StoreordersController::class,'store_com_orders'])->name('store_com_orders');
        Route::get('store/pending_orders', [StoreordersController::class,'store_pen_orders'])->name('store_pen_orders');
        Route::get('store/cancelled_orders', [StoreordersController::class,'store_can_orders'])->name('store_can_orders');
     

        Route::get('d_boy/list', [DeliveryboyController::class,'list'])->name('store_d_boylist');
        Route::get('d_boy/add', [DeliveryboyController::class,'AddD_boy'])->name('store_AddD_boy');
        Route::post('d_boy/add/new', [DeliveryboyController::class,'AddNewD_boy'])->name('store_AddNewD_boy');
        Route::get('d_boy/edit/{id}', [DeliveryboyController::class,'EditD_boy'])->name('store_EditD_boy');
        Route::post('d_boy/update/{id}', [DeliveryboyController::class,'UpdateD_boy'])->name('store_UpdateD_boy');
        Route::get('d_boy/delete/{id}', [DeliveryboyController::class,'DeleteD_boy'])->name('store_DeleteD_boy');

        Route::get('st_driver_callback_requests', [CallbackController::class,'drivercallbacklist'])->name('st_driver_callback_requests');
        Route::get('st_driver_callbackproc/{id}', [CallbackController::class,'driver_call_proc'])->name('st_driver_callbackproc');

          
        Route::get('d_boy/orders/{id}', [StoreordersController::class,'store_dboy_orders'])->name('store_dboy_orders');
        Route::post('d_boy/assign/{id}', [StoreordersController::class,'assigndboy'])->name('store_dboy_assign');
        Route::get('st/missed/orders', [StoreordersController::class,'missed_orders'])->name('st_missed_orders');

        Route::get('st/status/change/{cart_id}', [StoreordersController::class,'change'])->name('st_changeStatus');
        Route::post('d_boy/assign/{id}', [StoreordersController::class,'assigndboy'])->name('st_dboy_assign');
        Route::get('item-sales-report/last-30-days', [StRequiredController::class,'reqforthirty'])->name('reqforthirty');



        Route::get('order/reports', [DeliveryboyController::class,'boy_reports'])->name('st_boy_reports');
        Route::post('incentive', [StoreTimeslotController::class,'updateincentive'])->name('up_store_incentive');
        Route::get('dboy_incentive', [DriverfinanceController::class,'boy_incentive'])->name('store_boy_incentive');
     

        Route::post('dboy_pay/{dboy_id}', [DriverfinanceController::class,'incentive_pay'])->name('store_incentive_pay');
        Route::post('Orders/Reassign/{cart_id}', [AssignorderController::class,'reassign_order'])->name('store_reassign_order');


        Route::get('driver/Notification', [UsrnotificationController::class,'storeNotificationdriver'])->name('storeNotificationdriver');
        Route::post('driver/Notification/send', [UsrnotificationController::class,'Notification_to_driver_Send'])->name('store_Notification_to_driver_Send');
        Route::get('sendnotificationus', [UsrnotificationController::class,'sendnotificationus'])->name('sendnotificationus');

         Route::get('store/home-category', [StorehomecateController::class,'allhomecate'])->name('storehomecate');
         Route::get('store/home-category/add', [StorehomecateController::class,'AddCategory'])->name('storeAddHomeCategory');
         Route::post('store/home-category/insert', [StorehomecateController::class,'InsertCategory'])->name('storeInsertHomeCategory');
         Route::get('store/home-category/edit/{id}', [StorehomecateController::class,'EditCategory'])->name('storeoHomecateEditCategory');
         Route::post('store/home-category/update/{id}', [StorehomecateController::class,'UpdateCategory'])->name('storeUpdateHomeCategory');
         Route::get('store/home-category/delete/{id}', [StorehomecateController::class,'DeleteCategory'])->name('storeHomecateDeleteCategory');


          Route::get('store/assign-home-category/{id}', [StoreassignHomecateController::class,'assignhomecat'])->name('storeAssignHomeCategory');
         Route::post('store/assign-home-category/insert', [StoreassignHomecateController::class,'InsertAssignHomeCat'])->name('storeInsertAssignHomeCategory');
         Route::get('store/assign-home-category/delete/{id}', [StoreassignHomecateController::class,'DeleteAssignhomecat'])->name('storeDeleteAssignHomeCategory');
    }); 

}); 


}); 
