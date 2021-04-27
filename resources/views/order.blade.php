@extends('layouts.master')

@section('content')
    <h1 style="text-align: center; padding-top:1vw;"> My Order History </h1>

    <style>
        p{
            font-size:20px;
            margin-bottom:0px;
        }
    </style>
    @if (session('stat'))
    <div class="alert alert-success">
        {{ session('stat') }}
    </div>
@endif
        <div class="container" style="width: 50%;">
            @foreach($holder as $one)
                <div class="row" style="padding: 0vw 1vw 1vw 1vw; border: 1px solid black; margin: 1vw 0vw;">
                    <div class="row" style="border: 1px solid black; padding:20px; margin:0.5vw;">
                        <div class="col-md-6"><h2 style="margin:0px !important;">Order #: {{ $one['order_number']}}</h2></div>
                        <div class="col-md-6" style="text-align:right;"><p> {{ $one['order_status'] }}</p></div>
                    </div>

                  
                        <div class='row' style="padding-bottom: 1vw;">

                            <div><p>{{ $one['created_at'] }}</p></div>
                            <div class="col-md-4" style="float:left;"><p>{{ $one['total_quantity'] }}x</p></div>
                        <div class="col-md-4" style="text-align:right;"><p> Php. {{ $one['total_price'] }}</p></div>
                        <div class="col-md-4" >{{Form::submit("View Order", ["class='btn btn-primary' style='width:100%;'"])}}</div>
                     
                        </div>
                   
                </div>
            @endforeach
        </div>
@endsection
