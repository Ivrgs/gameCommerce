<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Auth, Redirect, App\ShopModel, App\OrderModel, App\CartModel, App\CMSModel;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $cart = CartModel::where('user_id', Auth::user()->id)->get();
        $shopp = "";
        $single = CartModel::where('user_id', Auth::user()->id)->orderby('id')->get();
        $totalQuantity = $single->sum('cart_quantity');
        $totalPrice = $single->sum('cart_price');
    
        foreach($cart as $item){
            $shop = ShopModel::find($item->product_id);
            $shopp = ShopModel::where('id', $item->product_id)->get();
        } 
       
        return view('checkout', compact('cart','shopp', 'totalQuantity', 'totalPrice'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $arr = OrderModel::join('tbl_shop', 'tbl_shop.id', '=', "tbl_orders.product_id")
        ->where("user_id", Auth::user()->id)->get();
        $grouped = $arr->groupBy('order_number');

        $order = new OrderModel();
        $cart = CartModel::where('user_id', $_POST['user_id'])->get();

        $bytes = random_bytes(5);

       $arr = array();
        foreach ($cart as $shop){
            $temp = array();
            $temp['order_number'] = bin2hex($bytes);
            $temp['user_id'] = $shop->user_id;
            $temp['product_id'] = $shop->product_id;
            $temp['order_quantity'] = $shop->cart_quantity;
            $temp['order_price'] = $shop->cart_price;
            $temp['order_status'] = "0";
            array_push($arr, $temp);
        }
        if($arr == null){
            return Redirect::back()->withErrors(['You dont have any Item on your cart']);
        }else{
            OrderModel::insert($arr);
            $cart->each->delete();
            return redirect('orders')->with('stat', 'Your Item/s has been ordered. Order ID: #' . bin2hex($bytes));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(){
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

        $cartData = CartModel::where('user_id', $request->id)->get();
        $quantity = CartModel::where('user_id', $request->id)->sum('cart_quantity');
        $sum = CartModel::where('user_id', $request->id)->sum('cart_price');

        $productInfo = array();
        $Total = array();

        foreach($productData as $response){
                $temp = array();
                $temp['CartID'] = $response->id;
                $temp['ProductImage'] = $response->product_image;
                $temp['ProductName'] = $response->product_name;
                $temp['ProductPlatform'] = $response->product_platform;
                $temp['ProductPrice'] = $response->product_price;
                $temp['CartQuantity'] = $response->cart_quantity;

                array_push($productInfo, $temp);
        }

        foreach($cartData as $index => $cartData ){
            $temp = array();
            $temp['TotalQuantity']  = $quantity;
            $temp['TotalPrice']  = $sum;
            array_push($Total, $temp);
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
    public function destroy($id){
        CartModel::where('id', $id)->delete();
        return Redirect::back()->withErrors(["The Item in your cart has been Deleted"]);
    }
}
