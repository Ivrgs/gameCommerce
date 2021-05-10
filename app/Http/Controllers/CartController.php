<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Auth, Redirect, App\User, App\ShopModel, App\OrderModel, App\CartModel, App\CMSModel;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $productData = ShopModel::join('tbl_cart', 'tbl_cart.product_id', '=', "tbl_shop.id")->where("user_id", Auth::user()->id)->get();
       
            $sum = array();
            $shopp = array();
            $single = CartModel::where('user_id', Auth::user()->id)->orderby('id')->get();

            foreach($productData as $thing){
                $cmsPlatform = CMSModel::where('type', "product_platform")->where('value', $thing->product_platform)->get('title');
                
                foreach($cmsPlatform as $text){
                    $cmsPlatform = $text->title;
                }

                $inner = array();
                $inner['ProductName'] = $thing->product_name;
                $inner['ProductPlatform'] = $cmsPlatform;
                $inner['ProductPrice'] =  $thing->sale != 0 ? number_format((float)$thing->sale_price, 2,'.',',') : number_format((float)$thing->product_price, 2,'.',',');
                $inner['CartQuantity'] = $thing->cart_quantity;
                array_push($shopp, $inner);
            }
            
            foreach($productData as $key=>$value){
                $inner = array();
                $inner = $value->sale != 0 ? number_format((float)$value->sale_price, 2,'.',',') * $value->cart_quantity : number_format((float)$value->product_price, 2,'.',',') * $value->cart_quantity;
                array_push($sum, $inner);
            }

            foreach($single as $index => $single ){
                $ArrayHolder = [
                    'OrderNumber' => self::randomString(),
                    'TotalQuantity' => $single->sum('cart_quantity'),
                    'TotalPrice' => array_sum($sum)
                ];
            }
            return view('checkout', compact('shopp','ArrayHolder'));
    }
    public function randomString(){
        while(OrderModel::where("order_number", bin2hex(random_bytes(5)))->count() > 0){
            return bin2hex(random_bytes(5));
        }
        return bin2hex(random_bytes(5));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $user = User::find($_POST['user_id']);
        if($_POST['CheckoutPassword'] == $_POST['CheckoutConfirm']){
            if(Hash::check($_POST['CheckoutPassword'], $user->password)){
                $cart = CartModel::where('user_id', $_POST['user_id'])->get();

                foreach($cart as $item){
                    $updateShop = ShopModel::find($item->product_id);
        
                    $order = new OrderModel();
                    $order['order_number'] = $_POST['order_number'];
                    $order['user_id'] = $item->user_id;
                    $order['product_id'] = $item->product_id;
                    $order['order_quantity'] = $item->cart_quantity;
                    $order['order_price'] = $item->cart_price;
                    $updateShop['product_quantity'] -= $item->cart_quantity;
                    $updateShop->save();
                    $order->save();
               }
        
                $this->destroy();
                $_POST['CartMethod']  = "Checkout";
                return redirect('orders')->with('stat', 'Your Item/s has been ordered. Order ID: #' . $_POST['order_number']);
            }
            
        }else{
            return CartController::index()->withErrors(['Wrong Password, Try Again']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(){
        if($_POST['purchase_method'] == "Buy Now"){
            $cart = new CartModel();
            $cart->user_id = $_POST['user_id'];
            $cart->product_id = $_POST['product_id'];
            $cart->cart_quantity = $_POST['product_quantity'];
            $cart->cart_price = ($_POST['product_final_price']) *  $_POST['product_quantity'];
            $cart->save();
            return self::index();
            
        }else{
            $cart = CartModel::where('user_id', $_POST['user_id'])->where('product_id', $_POST['product_id'])->get();
            $shop = ShopModel::find($_POST['product_id']);
        
            if($shop->product_quantity >= $_POST['product_quantity']){
                if($cart->count() == 0){
                    $this->cartMethod();
                }else{
                    foreach($cart as $check){
                        $count = $check->cart_quantity + $_POST['product_quantity'];
                        if($count <= $shop->product_quantity){
                            $this->cartMethod();
                        }else{
                            return Redirect::back()->withErrors(["Not Enough Stocks"]);
                        }   
                    }
                }
                return Redirect::back()->withErrors(["Your Item has been added to your cart"]);
            }else{
                return Redirect::back()->withErrors(["Not Enough Stocks"]);
            }
        }
       
    }

    public function cartMethod(){    
            if(CartModel::where('user_id', $_POST['user_id'])->where('product_id', $_POST['product_id'])->first()){
                    $updateCart = CartModel::where('user_id', $_POST['user_id'])->where('product_id', $_POST['product_id'])->first();
                    $updateCart->cart_quantity = $updateCart->cart_quantity + $_POST['product_quantity'];
                    $updateCart->cart_price = ($_POST['product_final_price']) * ($updateCart->cart_quantity);
                    $updateCart->save();
            }else{
                    $cart = new CartModel();
                    $cart->user_id = $_POST['user_id'];
                    $cart->product_id = $_POST['product_id'];
                    $cart->cart_quantity = $_POST['product_quantity'];
                    $cart->cart_price = ($_POST['product_final_price']) *  $_POST['product_quantity'];
                    $cart->save();
            }
             return Redirect::back()->withErrors(["Your Item has been added to your cart"]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request){
        $productData = ShopModel::join('tbl_cart', 'tbl_cart.product_id', '=', "tbl_shop.id")->where("user_id", $request->id)->get();
        $single = CartModel::where('user_id', $request->id)->orderby('id')->get();
       
        $quantity = $single->sum('cart_quantity');

        $sum = array();
        $productInfo = array();
        $Total = array();

        foreach($productData as $response){
            $cmsPlatform = CMSModel::where('type', "product_platform")->where('value', $response->product_platform)->get('title');
            $inner = array();
            $inner['CartID'] = $response->id;
            $inner['ProductImage'] = $response->product_image;
            $inner['ProductName'] = $response->product_name;
            
            foreach($cmsPlatform as $text){
                $cmsPlatform = $text->title;
            }

            $inner['ProductPlatform'] = $cmsPlatform; 
            $inner['ProductPrice'] =  $response->sale != 0 ? number_format((float)$response->sale_price, 2,'.',',') : number_format((float)$response->product_price, 2,'.',',');
            $inner['CartQuantity'] = $response->cart_quantity;
            array_push($productInfo, $inner);
        }
        foreach($productData as $key=>$value){
            $inner = array();
            $inner = $value->sale != 0 ? number_format((float)$value->sale_price, 2,'.',',') * $value->cart_quantity : number_format((float)$value->product_price, 2,'.',',') * $value->cart_quantity;
            array_push($sum, $inner);
        }
        foreach($single as $index => $single ){
            $inner = array();
            $inner['TotalQuantity']  = $quantity;
            $inner['TotalPrice']  = array_sum($sum);
            array_push($Total, $inner);
        }

            $jsonProduct['ProductDetails'] = $productInfo;
            $jsonTotal['Total'] = $Total;

        echo json_encode($jsonProduct  + $jsonTotal);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(){
        if($_POST['CartMethod'] == "Clear Cart"){
            CartModel::where('user_id', $_POST['user_id'])->delete();
            return Redirect::back()->withErrors(["All Cart Items Deleted Successfully"]);
        }else{
            CartModel::where('user_id', $_POST['user_id'])->delete();
        }
        
    }
}
