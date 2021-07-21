<?php

namespace App\Http\Controllers\Storeapi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class StproductController extends Controller
{
       public function list(Request $request)
    {
    
         $store_id=$request->store_id;
         
       $prodsssss = DB::table('product')
                    ->join('categories','product.cat_id','=','categories.cat_id')
                    ->join('categories as catttt','categories.parent','=','catttt.cat_id')
                    ->select('product.*')
                    ->where('product.added_by', $store_id)
                    ->get();
       
       
     
         
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
            foreach ($prod as $prods) {
                array_push($result, $prods);

                $app = json_decode($prods->product_id);
                $apps = array($app);
                $app =  DB::table('product_varient')
                 ->Leftjoin('deal_product','product_varient.varient_id','=','deal_product.varient_id')
                         ->select('product_varient.ean','product_varient.added_by','product_varient.varient_id', 'product_varient.description', 'product_varient.base_price as price', 'product_varient.base_mrp as mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','deal_product.deal_price', 'deal_product.valid_from', 'deal_product.valid_to')
                         ->where('product_varient.added_by', $store_id)
                        ->whereIn('product_varient.product_id', $apps)
                        ->get();
                $tag = DB::table('tags')
                 ->whereIn('product_id', $apps)
                ->get();
                $result[$j]->tags = $tag;  
                $j++;
                $result[$i]->varients = $app;
                $i++; 
             
            }

    
        	$message = array('status'=>'1', 'message'=>'Store Products', 'data'=>$prod);
	        return $message;
              }
    	else{
    		$message = array('status'=>'0', 'message'=>'Products not found', 'data'=>[]);
	        return $message;
    	} 
       
    }

       public function category_list(Request $request)
    {
     $cat = DB::table('categories')
                   ->select('parent')
                   ->get();
                   
        if(count($cat)>0){           
        foreach($cat as $cats) {
            $a = $cats->parent;
           $aa[] = array($a); 
        }
        }
        else{
            $a = 0;
           $aa[] = array($a);
        }
        
         $category = DB::table('categories')
                  ->where('level', '!=', 0)
                  ->WhereNotIn('cat_id',$aa)
                    ->get();
        if(count($category)>0){
        	$message = array('status'=>'1', 'message'=>'Category List', 'data'=>$category);
	        return $message;
              }
    	else{
    		$message = array('status'=>'0', 'message'=>'Category not found', 'data'=>[]);
	        return $message;
    	} 
       
    }
     
    
     public function st_addproduct(Request $request)
    {
        $store_id = $request->store_id;
        $category_id=$request->cat_id;
        $product_name = $request->product_name;
        $quantity = $request->quantity;
        $unit = $request->unit;
        $price = $request->price;
        $description = $request->description;
        $date=date('d-m-Y');
        $mrp = $request->mrp;
        $ean = $request->ean;
    
        


         $tags = explode(",", $request->tags);


        if($request->hasFile('product_image')){
            $product_image = $request->product_image;
            $fileName = $product_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $product_image->move('images/product/'.$date.'/', $fileName);
            $product_image = 'images/product/'.$date.'/'.$fileName;
        }
        else{
            $product_image = 'N/A';
        }

        $insertproduct = DB::table('product')
                            ->insertGetId([
                                'cat_id'=>$category_id,
                                'product_name'=>$product_name,
                                'product_image'=>$product_image,
                                'added_by'=>$store_id,
                                'approved'=>0
                               
                            ]);
        
         if($insertproduct){
        
            $id = DB::table('product_varient')
            ->insertGetId([
                'product_id'=>$insertproduct,
                'quantity'=>$quantity,
                'varient_image'=>'N/A',
                'unit'=>$unit,
                'ean'=>$ean,
                'base_price'=>$price,
                'base_mrp'=>$mrp,
                'description'=>$description,
                'approved'=>0,
                'added_by'=>$store_id
               
            ]);
            
            foreach($tags as $tag){
             DB::table('tags')
            ->insertGetId([
                'product_id'=>$insertproduct,
                'tag'=>$tag
            ]);
             }
             
          
            $message = array('status'=>'1', 'message'=>trans('keywords.Added Successfully'));
	        return $message;
          
        }
        else{
             $message = array('status'=>'0', 'message'=>trans('keywords.Something Wents Wrong'));
	        return $message;
        }
      
    }
    
    public function St_updateproduct(Request $request)
    {
         $product_id = $request->product_id;
        $product_name = $request->product_name;
        $date=date('d-m-Y');
        $product_image = $request->product_image;
         $tags = explode(",", $request->tags);
    
        
       $getProduct = DB::table('product')
                    ->where('product_id',$product_id)
                    ->first();

        $image = $getProduct->product_image;

        if($request->hasFile('product_image')){
            $product_image = $request->product_image;
            $fileName = $product_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $product_image->move('images/product/'.$date.'/', $fileName);
            $product_image = 'images/product/'.$date.'/'.$fileName;
        }
        else{
            $product_image = $image;
        }

        $insertproduct = DB::table('product')
                       ->where('product_id', $product_id)
                            ->update([
                                'product_name'=>$product_name,
                                'product_image'=>$product_image,
                               
                            ]);
                            
         if($request->tags != NULL){
               $deleteold = DB::table('tags')
               ->where('product_id', $product_id)
               ->delete();

            foreach($tags as $tag){
            $enternew =  DB::table('tags')
                    ->insert([
                        'product_id'=>$product_id,
                        'tag'=>$tag
                    ]);
             }
            }
        
        
        if($insertproduct || $enternew){
            $message = array('status'=>'1', 'message'=>trans('keywords.Added Successfully'));
	        return $message;
          
        }
        else{
             $message = array('status'=>'0', 'message'=>trans('keywords.Something Wents Wrong'));
	        return $message;
        }
       
       
       
       
    }
    
    
    
 public function DeleteProduct(Request $request)
    {
        $product_id=$request->product_id;

        $delete=DB::table('product')->where('product_id',$request->product_id)->delete();
        if($delete)
        {
         $delete=DB::table('product_varient')->where('product_id',$request->product_id)->delete();  
       
           $deleteold = DB::table('tags')
               ->where('product_id', $product_id)
               ->delete();
         
         
            $message = array('status'=>'1', 'message'=>trans('keywords.Deleted Successfully'));
	        return $message;
          
        }
        else{
             $message = array('status'=>'0', 'message'=>trans('keywords.Something Wents Wrong'));
	        return $message;
        }
    }

    
}
