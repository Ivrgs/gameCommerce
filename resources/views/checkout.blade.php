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
{{Form::submit('Checkout', ['class'=>'btn btn-info','name'=>'CartMethod'])}}
{!! Form::close()!!}




@foreach($shopp as $t)
<div>{{ $t['ProductName'] }}</div>
<div>Platform: {{ $t['ProductPlatform'] }}</div>
    <div>{{ $t['CartQuantity'] }}x</div>
    <div>Php. {{ $t['ProductPrice'] }}</div>

    @endforeach




<br>

{{ $ArrayHolder['TotalQuantity'] }} Items <br>
Total Price: Php. {{ $ArrayHolder['TotalPrice']}}<br><br>


@endsection
