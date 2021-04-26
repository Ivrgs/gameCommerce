@extends('layouts.master')

@section('content')
    <h1 style="text-align: center; padding-top:1vw;"> My Order History </h1>

    <style>
        p{
            font-size:20px;
            margin-bottom:0px;
        }
    </style>
    @if($system == false || isset($grouped) == "" )
    <p style="text-align: center;">No Orders Yet</p>
    @else
    @if (session('stat'))
    <div class="alert alert-success">
        {{ session('stat') }}
    </div>
@endif
        <div class="container" style="width: 50%;">
            @foreach($grouped as $product => $grouped)
                <div class="row" style="padding: 0vw 1vw 1vw 1vw; border: 1px solid black; margin: 1vw 0vw;">
                    <div class="row" style="border: 1px solid black; padding:20px; margin:0.5vw;">
                        <div class="col-md-6"><h2 style="margin:0px !important;">{{ $product }}</h2></div>
                        <div class="col-md-6" style="text-align:right;"><p> {{-- {{ $product->order_status }} --}} Pending</p></div>
                    </div>

                    @foreach($grouped as $product)
                        <div class='row' style="padding-bottom: 1vw;">
                            <div class="row">
                            </div>
                        <div class="row">
                            <div class="col-md-2" style="width:100%;"><img src="asd.jpg" style="width:100%;"></div>
                            <div class="col-md-5"><p>Game Title: {{ $product->product_name }}</p><div><p>Platform: {{ $product->product_platform }}</p></div>
                            <div><p>{{ $product->order_quantity }}x</p></div>
                        </div>
                        <div class="col-md-5" style="text-align:center;"><div><p>Price: {{ $product->product_price }}</p></div>
                            <div>{{Form::submit("Review", ["class='btn btn-outline-danger' style='width:100%;'"])}}</div></div>
                        </div>
                    </div>
                    @endforeach
                        {{-- @foreach($totprice as $s)
                        {{$s}}
                        @endforeach --}}

                    <div class="row" style="border-top: 1px solid black; width:100%;">
                        <div class="col-md-6" style="float:left;"><p>{{$totalQuantity}} Items </p></div>
                        <div class="col-md-6" style="text-align:right;"><p> Php. {{$totalPrice}}</p></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">{{{ Form::submit("Gcash", ['class="btn btn-primary"']) }}}
                                                {{{ Form::submit("Paypal", ['class="btn btn-info"']) }}}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
