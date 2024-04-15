<?php

namespace App\Http\Controllers;
use App\Models\Product;
use yii\base\Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function getproductbyid($id){
       
    
       $productDetails= DB::select("SELECT p.id AS product_id,p.category_id,p.product_name,p.product_code,p.terms_and_conditions,p.how_to_redeem,p.desc,p.sku,p.image_path,p.price FROM products AS p 
        JOIN product_categories AS p1 ON (p1.id=p.category_id)
        WHERE p.id=$id");
        if(!empty($productDetails) && $productDetails != null){
        
            $getVariations=DB::select("
            SELECT 
                    p1.id AS variation_id,p1.product_id,p1.variation_name,p1.price 
            FROM product_variations AS p1 
            WHERE p1.product_id=$id AND p1.status=1");

            if(!empty($getVariations) && $getVariations != null){
               
                $productDetails[0]->variations=$getVariations;
             
            }else{
             //   $productDetails[0]->variations='';
            }
            return view('productdetail', [
                'productDetails' => $productDetails
            ]);
        }else{
            throw new \Exception('Requested product not found ..!');

        }                

      
    }

    public function getproducts(){
        return view('product',['product'=>Product::all()]);
    }

    
}
