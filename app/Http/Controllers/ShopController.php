<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use \Mailjet\Resources;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

use Auth, Redirect, 
App\User,
App\ShopModel, 
App\SysReqModel, 
App\CartModel, 
App\OrderModel, 
App\WishModel, 
App\ReviewModel, 
App\CartDetails,
App\CMSModel;


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


    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(){

       
    }
    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug){
        $wish = '';
        // $shop = ShopModel::find($id);
        $shop = ShopModel::where('product_slug', $slug)->first();

        $cmsStatus = CMSModel::where('type', "Product Status")->where('title', $shop->product_status)->get('title');
        $cmsPlatform = CMSModel::where('type', "Product Platform")->where('title', $shop->product_platform)->get('title');

        foreach($cmsStatus as $text){
            $cmsStatus = $text->title;
        }
        foreach($cmsPlatform as $text){
            $cmsPlatform = $text->title;
        }

        $CMSPack = array(
            'cmsStatus' => $cmsStatus,
            'cmsPlatform' => $cmsPlatform
        );
      
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
            if ($wish = WishModel::where('product_id', $shop->id)->where('user_id', Auth::user()->id)->first()) {
                $wish = true;
            } else {
                $wish = false;
            }
        }else{
            $wish = null;
        }

        return view('viewItem', compact('shop', 'system', 'review', 'user', 'wish', 'CMSPack'));
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
   
}
