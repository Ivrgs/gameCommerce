<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Auth, Redirect ,App\ShopModel, App\WishModel, App\CMSModel;

class WishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
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
    public function show($id)
    {
        //
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
    public function destroy(Request $request){
        $wishdelete = WishModel::where('product_id', $request->product_id)->where('user_id', $request->user_id)->delete();
        return Redirect::back()->withErrors(["Wish has been Deleted"]);
    }
}
