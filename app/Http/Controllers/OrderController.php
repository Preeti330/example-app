<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Useraddress;
use App\Models\Paymenttransction;
use App\Models\Ordershipping;
use Illuminate\Support\Facades\DB;
use App\Models\Cartitem;

class OrderController extends Controller
{
    public function placeorder(Request $request){
        $cart_id = $request->input('cart_id');
        $pincode = $request->input('pincode');
        $city    = $request->input('city');
        $address = $request->input('address');
        $state   = $request->input('state');
        DB::beginTransaction();

        try {
            $pincode    =   
                            (!empty($pincode) && $pincode != null) ? $pincode :    throw new \Exception('Pincode is missing', 400);
            $city       =
                            (!empty($city) && $city != null) ? $city :    throw new \Exception('city is missing ', 400);
            $address    =
                            (!empty($address) && $address != null) ? $address :    throw new \Exception('address is missing ', 400);
            $state      =
                            (!empty($state) && $state != null) ? $state :    throw new \Exception('state is missing ', 400);

            $pattern = "/^[a-zA-Z\s]{1,25}+$/"; // state,city conatins only laters and max length will be 25

            // Your validation code
            if (!preg_match('/^\d{6}$/', $pincode)) {
                throw new \Exception('Invalid Picode number /pincode should contains 6 degits ',422);
            }
            if (!preg_match($pattern, $state)) {

                throw new \Exception('Invalid state/should not conatins any digits or special character', 422);
            }
            if (!preg_match($pattern, $city)) {

                throw new \Exception('Invalid city/should not conatins any digits or special character', 422);
            }

            if (!empty($cart_id)) {

                $cartItem = Cartitem::find($cart_id);
                

                if (!empty($cartItem) && $cartItem != null) {

                    //customer address details 
                    $useraddreesmodel=new Useraddress();
                    $useraddreesmodel->customer_id  = 
                                                      $cartItem->customer_id;     
                                                       
                    $useraddreesmodel->address      = $address;  
                    $useraddreesmodel->status  = 1;  
                    $useraddreesmodel->city_name  = $city;  
                    $useraddreesmodel->state_name = $state;  
                    $useraddreesmodel->pincode  = $pincode;  
                    $useraddreesmodel->updated_at  = date('Y-m-d H:i:s'); 
                    $useraddreesmodel->created_at  = date('Y-m-d H:i:s'); 

                    if($useraddreesmodel->save()){
                        $address_id=$useraddreesmodel->id;

                        $order = DB::table('orders')
                                ->where('cart_items_id',$cart_id)
                                ->first();

                        if(empty($order) && $order ==null){
                            $odermodel= new Order();

                            $odermodel->customer_id=$cartItem->customer_id;
                            $odermodel->cart_items_id=$cartItem->id;
                            $odermodel->total_price=$cartItem->total_price;
                            $odermodel->shpping_id=$address_id;
                            $odermodel->status=1;
                            $odermodel->delivery_partner='Online';
                            $odermodel->updated_at=date('Y-m-d H:i:s');
                            $odermodel->created_at=date('Y-m-d H:i:s');

                            if($odermodel->save()){

                                $order_id=$odermodel->id;
                                $orderitem=new Orderitem();
                                $orderitem->order_id=$order_id;
                                $orderitem->qty=$order_id;
                                $orderitem->total_price=$order_id;
                                $orderitem->unit_price=$order_id;
                                $orderitem->status=$order_id;
                                $orderitem->processing_fee_per=$order_id;
                                $orderitem->tax=$order_id;
                                $orderitem->created_at=date('Y-m-d H:i:s');
                                $orderitem->updated_at=date('Y-m-d H:i:s');

                                if($orderitem->save()){
                                    $itmeid=$orderitem->id;
                                    $shppingmodel=new Ordershipping();
                                    $shppingmodel->customer_id=$cartItem->customer_id;
                                    $shppingmodel->customer_address_id=$cartItem->customer_id;
                                    $shppingmodel->delivery_partner_id=$cartItem->customer_id;
                                    $shppingmodel->updated_at=date('Y-m-d H:i:s');
                                    $shppingmodel->created_at=date('Y-m-d H:i:s');
                                    $cartItem->is_delivered=1;
                                    $cartItem->save();
                                    if($shppingmodel->save()){
                                       // save details in tarnsction ()
                                       $modal=new Paymenttransction();
                                       $modal->order_id=$order_id;
                                       $modal->qty=$cartItem->qty;
                                       $modal->total_price=$cartItem->total_price;
                                       $modal->customer_id=$cartItem->customer_id;
                                       $modal->cart_items_id=$cartItem->id;
                                       $modal->status=1;
                                       $modal->credited_date=date('Y-m-d');
                                       $modal->processing_fee=0;
                                       $modal->tax=0;
                                       
                                       $modal->total_amt=$cartItem->total_price;
                                       $modal->payment_method_type=1;
                                       $modal->updated_at=date('Y-m-d H:i:s');
                                       $modal->created_at=date('Y-m-d H:i:s');

                                       if($modal->save()){

                                       $redirectUrl = route('thankyou');
                                       DB::commit();
                                        return response()->json(['message'=>"Order Placed Successfully","url"=>$redirectUrl]);
                                       }


                                    }



                                }else{
                                    return response()->json(['error' => 'Failedto save data in order item'], 500);
                                }


                            }else{
                                return response()->json(['error' => 'Failed to save data in orders'], 500);
                            }


                        }else{
                            throw new \Exception('Order has already been processed', 422);
                        }       

                    }else{
                        return response()->json(['error' => 'Failed to save data in orders'], 500);
                    } 
                
                } else {
                    throw new \Exception('Cart is empty / invalid cart request ',422);
                }

            } else {
                throw new \Exception('cart id is missing in request');
            }

        } catch (\Exception $e) {
            // Pass the error message to the view
            // return View::make('product')->with('errorMessage', $e->getMessage());
            DB::rollback();
            throw new \Exception($e,422);
        }
    }

    public function getorder($user_id,$product_id){

       $user_id     = 
                        (!empty($user_id) && $user_id != null) ? $user_id :    throw new \Exception('User Id  is missing', 400);
       $product_id  =  
                        (!empty($product_id) && $user_id != null) ? $product_id :    throw new \Exception('Product Id  is missing', 400);

        

    }
}
