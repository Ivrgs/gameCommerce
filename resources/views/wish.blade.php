@extends('layouts.master')

@section('content')
    <h1 style="text-align: center; padding-top:1vw;"> My Wishlist </h1>

    <style>
        p{
            font-size:20px;
            margin-bottom:0px;
        }
    </style>
    @if(empty($sample))
        <p style="text-align: center;">You have no wish, make a wish.</p>
    @else
        <div class="container" style="width: 50%;">
         @foreach($sample as $test)
            @foreach($test['ProductData'] as $tru)
               @if($tru['product_image'] == null)
               <img src="{{ url('images/imageholder.png') }}" style="width:200px">
               @else
                    <img src="{{ $tru['product_image']}}"  style="width:200px">
               @endif
                {{ $tru['product_name']}}
                {{ $tru['product_price']}}
                <a href="/viewItem/{{ $tru['product_slug']}}"><input type='button' value='View Game'></a>
                {!!Form::open(['action'=>['WishController@destroy'], 'method'=>'POST'])!!}
                {{Form::hidden('user_id', Auth::user()->id)}}
                {{Form::hidden('product_id', $tru['id'])}}
                {{Form::submit('Remove Wishlist', ['class'=>'btn btn-danger'])}}
                {!! Form::close()!!}
            @endforeach
        @endforeach 
        </div>
    @endif
@endsection
