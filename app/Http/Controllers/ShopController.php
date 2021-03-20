<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use \Mailjet\Resources;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

use Auth, App\User, Redirect;
use App\ShopModel, App\SysReqModel, App\CartModel, App\OrderModel, App\WishModel, App\ReviewModel, App\CartDetails;


class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $shop = ShopModel::all();
        return view('index',  ['shop' => $shop]);
    }
    public function about(){
        return view('about');
    }

    public function sendEmail(){
        $to_name ='Ivrgs';
        $to_email ='ivargasrodel@gmail.com';
        $data = array('name'=>"gameCommerce", "body" => "Welcome to gameCommerce");

        Mail::send('email',
            $data, function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)->subject('Laravel Test Mail');
                $message->from(env("MAIL_USERNAME"),'gameCommerce Admin');
            });

        // $mj = new \Mailjet\Client('561f80e0460466295fe63b7d96be352d', 'c63a61fa9a1da8524df9ce993c40c13f', true, ['version' => 'v3.1']);
        // $body = [
        //     'Messages' => [
        //         [
        //             'From' => [
        //                 'Email' => "kazneechan@gmail.com",
        //                 'Name' => "Eleanor"
        //             ],
        //             'To' => [
        //                 [
        //                     'Email' => "kazneechan@gmail.com",
        //                     'Name' => "Eleanor"
        //                 ]
        //             ],
        //             'Subject' => "Greetings from Mailjet.",
        //             'TextPart' => "My first Mailjet email",
        //             'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href='https://www.mailjet.com/'>Mailjet</a>!</h3><br />May the delivery force be with you!",
        //             'CustomID' => "AppGettingStartedTest"
        //         ]
        //     ]
        // ];
        // $response = $mj->post(Resources::$Email, ['body' => $body]);
        // $response->success() && var_dump($response->getData());

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        if($request->purchase_method == "Buy Now"){
            $bytes = random_bytes(5);

            $order = new OrderModel();
            $order->order_number = bin2hex($bytes);
            $order->user_id = $_POST['user_id'];
            $order->product_id = $_POST['product_id'];
            $order->order_quantity = 1;
            $order->order_quantity = $_POST['product_quantity'];
            $order->order_price = $_POST['product_final_price'];
            $order->order_status = '0';
            $order->save();
            return redirect('orders')->with('stat', 'Your Item/s has been ordered. Order ID: #' . bin2hex($bytes));
        }else{
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
                $cart->cart_price = $_POST['product_final_price'] * $_POST['product_quantity'];
                $cart->save();
            }
            return Redirect::back()->withErrors(["Your Item has been added to your cart"]);
        }
       
    }
    public function checkout(){
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

    public function wishstore(Request $request){
        $wish = new WishModel();
        $wish->user_id = $_POST['user_id'];
        $wish->product_id = $_POST['product_id'];
        $wish->save();

        return Redirect::back()->withErrors(["Item has been wish"]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $wish = '';
        $shop = ShopModel::find($id);

        if ($system = SysReqModel::get()) {
            $system = "error";
        }else if ($system = SysReqModel::where('product_id', $id)->get() == "0") {
            $system = "error";
        }else {
            $system = SysReqModel::where('product_id', $id)->get();
        }

        if ($review = ReviewModel::get()) {
            $review = "error";
        }else if ($review = ReviewModel::where('product_id', $id)->get() == "0") {
            $review = "error";
        }else {
            $review = ReviewModel::where('product_id', $id)->get();
        }

        if ($user = User::get()) {
            $user = "error";
        }else if ($user = ReviewModel::where('product_id', $id)->get() == "0") {
            $user = "error";
        }else {
            foreach ($review as $rev) {
                $user = User::find($rev->user_id)->get();
            }
        }

        if(isset(Auth::user()->id)){
            if ($wish = WishModel::where('product_id', $id)->where('user_id', Auth::user()->id)->first()) {
                $wish = true;
            } else {
                $wish = false;
            }
        }else{
            $wish = null;
        }

        return view('viewItem', compact('shop', 'system', 'review', 'user', 'wish'));
    }

    //View Cart Ajax Modal
    public function showcart(Request $request){
        $productData = ShopModel::join('tbl_cart', 'tbl_cart.product_id', '=', "tbl_shop.id")
       ->where("user_id", $request->id)->get();

        $cartData = CartModel::where('user_id', $request->id)->get();
        $quantity = CartModel::where('user_id', $request->id)->sum('cart_quantity');
        $sum = CartModel::where('user_id', $request->id)->sum('cart_price');

        $productInfo = array();
        $third = array();

        foreach($productData as $response){
                $temp = array();
                $temp['ProductName'] = $response->product_name;
                $temp['ProductPlatform'] = $response->product_platform;
                $temp['ProductPrice'] = $response->product_price;
                $temp['CartQuantity'] = $response->cart_quantity;

                array_push($productInfo, $temp);
        }

        foreach($cartData as $index => $cartData ){
            $temp3 = array();
            $temp3['TotalQuantity']  = $quantity;
            $temp3['TotalPrice']  = $sum;
            array_push($third, $temp3);
        }

            $jsonProduct['ProductDetails'] = $productInfo;
            $jsonThird['Total'] = $third;

        echo json_encode($jsonProduct + $jsonThird);
    }
    public function orderhistory(){
        $system = true;

        if(OrderModel::where('user_id', Auth::user()->id)->get() == null){
            $system = false;
        }else{
            $system = true;
            $arr = OrderModel::join('tbl_shop', 'tbl_shop.id', '=', "tbl_orders.product_id")
            ->where("user_id", Auth::user()->id)->get();
            $grouped = $arr->groupBy('order_number');
            $sample = array();

            foreach($arr as $a){
                $temp = array();
                $temp['jk'] = $a->order_number;
                array_push($sample, $temp);
            }
            if(isset($a) == ""){

            }else{
                $totalPrice = OrderModel::where('order_number', $a->order_number)->sum('order_price');
                $totalQuantity = OrderModel::where('order_number', $a->order_number)->sum('order_quantity');
                return view('order', compact('grouped','totalPrice', 'totalQuantity','system'));
            }
        }
        return view('order', compact('system'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //
    }
    public function wishlist(){
        if(empty(WishModel::where('user_id', Auth::user()->id)->get())){
            //
        }else{
            $mywish =  WishModel::where("user_id", Auth::user()->id)->get();
            $grouped = $mywish->groupBy('id');
        
            $sample = array();
            foreach($mywish as $wish){
                $productData = ShopModel::select('id','product_image','product_name', 'product_price')->where('id', $wish->product_id)->get();
                $temp = array();
                $temp['WishID'] = $wish->id;
                $temp['ProductData'] = $productData;
                array_push($sample, $temp);
            }
        }
        return view('wish', compact('sample'));
    }
    public function wishdestroy(Request $request){
        $wishdelete = WishModel::where('product_id', $request->product_id)->where('user_id', $request->user_id)->delete();
        return Redirect::back()->withErrors(["Wish has been Deleted"]);
    }
}
