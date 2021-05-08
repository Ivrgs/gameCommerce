<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Auth, Redirect, App\User, App\ShopModel, App\OrderModel, App\CartModel, App\CMSModel;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if(OrderModel::where('user_id', Auth::user()->id)->get() == null){
            $system = "No Orders Yet";
            return view('order', compact('system'));
        }else{
            $system = true;
            $orders = OrderModel::where("user_id", Auth::user()->id)->groupBy('order_number')->get();
            $holder = array();

            foreach($orders as $order){
                $totalPrice = OrderModel::where('order_number',  $order->order_number)->sum('order_price');
                $totalQuantity = OrderModel::where('order_number',  $order->order_number)->sum('order_quantity');
                $cmsStatus = CMSModel::where('type', "order_status")->where('value', $order->order_status)->get('title');

                $inner = array();
                $inner['order_number'] = $order->order_number;
                $inner['total_quantity'] = $totalQuantity;
                $inner['total_price'] = $totalPrice;
                $inner['order_status'] = $cmsStatus;
                $inner['created_at'] = $order->created_at;

                foreach($cmsStatus as $text){
                    $cmsStatus = $text->title;
                }

                $inner['order_status'] = $cmsStatus;
                array_push($holder, $inner);
            }
                return view('order', compact('holder','system'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(){
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request){
        $orders = OrderModel::where('order_number', $request->id)->where('user_id', Auth::user()->id)->get();
        $holder = array();
        $totalPrice = $orders->sum('order_price');
        $totalQuantity = $orders->sum('order_quantity');
        $Total = array();

        foreach($orders as $order){
            $inner = array();
            $product = ShopModel::find($order->product_id);
            $OrderNumber = OrderModel::where('order_number', $order->order_number)->where("user_id", Auth::user()->id)->groupBy('order_number')->get();

            $cmsPlatform = CMSModel::where('type', "product_platform")->where('value', $product->product_platform)->get('title');
            $cmsOrderStatus = CMSModel::where('type', "order_status")->where('value', $order->order_status)->get('title');
            foreach($cmsPlatform as $text){
                $cmsPlatform = $text->title;
            }
            foreach($cmsOrderStatus as $text){
                $cmsOrderStatus = $text->title;
            }
            foreach($OrderNumber as $text){
                $OrderNumber = $text->order_number;
                $OrderDate = $text->updated_at;
            }
          
            $inner['order_number'] = $OrderNumber;
            $inner['product_image'] = $product->product_image;
            $inner['product_name'] = $product->product_name;
            $inner['product_platform'] = $cmsPlatform ;
            $inner['order_price'] = $order->order_price;
            $inner['order_quantity'] = $order->order_quantity;
            $inner['order_status'] = $cmsOrderStatus;
            $inner['order_date'] = $OrderDate;
            array_push($holder, $inner);
        }
        foreach($orders as $index => $orders ){
            $temp = array();
            $temp['TotalPrice']  = $totalPrice;
            $temp['TotalQuantity']  = $totalQuantity;
            array_push($Total, $temp);
        }

        $jsonTotal['TotalOrder'] = $Total;
        $jsonData['OrderData'] = $holder;

        echo json_encode($jsonData + $jsonTotal);
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
        CartModel::where('user_id', $_POST['user_id'])->delete();
    }
}
