@extends('layouts.master')
@section('shopcontents')

<h1>Checkout</h1>

{!!Form::open(['action'=>['OrderController@create'], 'method'=>'POST'])!!}
{{Form::hidden('user_id', Auth::user()->id)}}
{{Form::text('CheckoutName', '', ['class' => 'form-control', 'required', 'placeholder' => 'Your Name'])}}
{{Form::text('CheckoutEmail', '', ['class' => 'form-control', 'required', 'placeholder' => 'example@domain.com'])}}
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
<br>
{{$totalQuantity}} Items <br>
Total Price: Php. {{$totalPrice}}
@endforeach
@endsection
