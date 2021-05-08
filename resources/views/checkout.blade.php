@extends('layouts.master')
@section('shopcontents')

<h1>Checkout</h1>
@if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif
{!!Form::open(['action'=>['CartController@create'], 'method'=>'POST'])!!}
{{Form::label('order_number', $ArrayHolder['OrderNumber'])}}
{{Form::hidden('order_number', $ArrayHolder['OrderNumber'])}}
{{Form::hidden('user_id', Auth::user()->id)}}
{{Form::text('CheckoutName', Auth::user()->name, ['class' => 'form-control', 'required', 'placeholder' => 'Your Name'])}}
{{Form::text('CheckoutEmail', Auth::user()->email, ['class' => 'form-control', 'required', 'placeholder' => 'example@domain.com'])}}
{{Form::password('CheckoutPassword', ['class' => 'form-control', 'required', 'placeholder' => 'Your Password'])}}
{{Form::password('CheckoutConfirm', ['class' => 'form-control', 'required', 'placeholder' => 'Confirm your Password'])}}
{{Form::submit('Checkout', ['class'=>'btn btn-info'])}}
{!! Form::close()!!}


@foreach($cart as $shop)
@foreach($shopp as $a)
<div>
<div>{{ $shop->product_id }}</div>
{{$a->product_name}}
<div>{{ $shop->cart_quantity }}x</div>
<div>Php. {{ $shop->cart_price }}</div>

</div>

@endforeach
@endforeach
<br>

{{$ArrayHolder['TotalQuantity']}} Items <br>
Total Price: Php. {{$ArrayHolder['TotalPrice']}}

@endsection
