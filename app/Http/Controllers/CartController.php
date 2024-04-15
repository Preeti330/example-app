<?php

namespace App\Http\Controllers;

use App\Models\Cartitem;
use App\Models\Product;
use yii\base\Exception;
use Illuminate\Support\Facades\View;
use App\Models\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function addcart(Request $request)
    {
        $product_id = $request->input('product_id');
        $username   = $request->input('username');
        $mobile = $request->input('mobile');
        $email = $request->input('email');
        DB::beginTransaction();

        try {
            (!empty($username) && $username != null) ? $username :    throw new \Exception('User name is missing', 400);
            (!empty($mobile) && $mobile != null) ? $username :    throw new \Exception('Mobile number is missing ', 400);
            $pattern = "/^[a-zA-Z\s]{1,25}+$/"; // username conatins only laters and max length will be 25

            // Your validation code
            if (!preg_match('/^\d{10}$/', $mobile)) {
                throw new \Exception('Invalid mobile number / mobile number should be of 10 digits',422);
            }
            if (!preg_match($pattern, $username)) {

                throw new \Exception('Invalid username/username length should be within 25 chars and should not conatins any digits', 422);
            }

            $checkUser      =   DB::table('users')
                                   ->where('mobile', $mobile)
                                   ->first();

            if(!empty($checkUser) && $checkUser != null){

                $id = $checkUser->id;
            }else{
                $usermodel = new Users();
            $usermodel->username = $username;
            $usermodel->mobile = $mobile;
            $usermodel->created_at = date('Y-m-d H:i:s');
            $usermodel->updated_at = date('Y-m-d H:i:s');

            if ($usermodel->save()) {
                $id = $usermodel->id;
            } else {
                return "error";
            }

            }
            

            if (!empty($product_id)) {

                $checkProduct = 
                                DB::table('products')
                                    ->select('id', 'product_name', 'product_code', 'category_id', 'price')
                                    ->where('id', $product_id)
                                    ->first();
                

                if (!empty($checkProduct) && $checkProduct != null && $checkProduct->price != null) {

                    //user can add only one cart item , and he can add item when is_delivered=1 i.e order placed 
                    $cartmodel=new Cartitem();
                    $cartItem = DB::table('cart_items')
                                    ->where('customer_id', $id)
                                    ->where('product_id',$checkProduct->id)
                                    ->where('is_delivered', 0)
                                    ->first();

                    if(!empty($cartItem) && $cartItem != null){
                        $msg = "Sorry, You have ".$checkProduct->product_name." in your cart. Please place an order and then continue to the cart.";
                    //    throw new \Exception($msg,422);
                    return response()->json(['error' => $msg], 500);
                    }
                    
                    //calculate for tax, with 18%
                    // $gst=(($checkProduct->price)*18)/100;
                    // $total_amt = $gst+$checkProduct->price;

                    $cartmodel->customer_id=$id;
                    $cartmodel->product_id=$checkProduct->id;
                    $cartmodel->qty=1;
                    $cartmodel->unit_price=$checkProduct->price;
                    $cartmodel->status=1;
                    $cartmodel->total_price=$checkProduct->price;
                    $cartmodel->is_delivered=0;
                    $cartmodel->created_at=date('Y-m-d H:i:s');
                    $cartmodel->updated_at=date('Y-m-d H:i:s');

                    if ($cartmodel->save()) {
                        $cart_id=$cartmodel->id;

                    $redirectUrl = route('getcart', ['user_id' => $id, 'cart_id' => $cart_id]);
                    DB::commit();
                    return response()->json(['cart_id'=>$cart_id,"user_id"=>$cart_id,"url"=>$redirectUrl]);
                    
                        
                    }else{
                        return response()->json(['error' => 'Failed to add item to cart'], 500);
                    } 
                
                } else {
                    throw new \Exception('Product not found / price for this product is missing ',422);
                }

            } else {
                throw new \Exception('Product id is missing in request');
            }

        } catch (\Exception $e) {
            // Pass the error message to the view
            // return View::make('product')->with('errorMessage', $e->getMessage());
            DB::rollback();
            throw new \Exception($e,422);
        }
    }

    public function getcartitem($user_id,$cart_id){
        $user_id     = 
                        (!empty($user_id) && $user_id != null) ? $user_id :    throw new \Exception('User Id  is missing', 400);
        $cart_id  =  
                        (!empty($cart_id) && $user_id != null) ? $cart_id :    throw new \Exception('Product Id  is missing', 400);


        $getCartdetails =   DB::table('cart_items as c1')
                            ->select(
                                'c1.id as cart_id',
                                'c1.customer_id',
                                'c1.qty',
                                'c1.unit_price',
                                'c1.total_price',
                                'u.username',
                                'u.mobile',
                                'c1.product_id',
                                'p.product_name',
                                'p.product_code',
                                'p.image_path',
                                'p.price',
                                'p.terms_and_conditions',
                                'p.desc'
                            )
                            ->join('users as u', 'u.id', '=', 'c1.customer_id')
                            ->join('products as p', 'p.id', '=', 'c1.product_id')
                            ->where('c1.customer_id',$user_id )
                            ->where('c1.id', $cart_id)
                            ->get()
                            ->toArray();

         if(!empty($getCartdetails) && $getCartdetails != null){
            return view('order',['getCartdetails'=>$getCartdetails]);
         }else{
            throw new \Exception('No data found..!!', 400);
         }                   

        // return $getCartdetails;

            
        
    }
}
