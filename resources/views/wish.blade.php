@extends('layouts.user')

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
                <img src="{{ $tru['product_image']}}">
                {{ $tru['product_name']}}
                {{ $tru['product_price']}}

                {!!Form::open(['action'=>['ShopController@wishdestroy'], 'method'=>'POST'])!!}
                {{Form::hidden('user_id', Auth::user()->id)}}
                {{Form::hidden('product_id', $tru['id'])}}
                {{Form::submit('Remove Wishlist', ['class'=>'btn btn-danger'])}}
                {!! Form::close()!!}
            @endforeach
        @endforeach 
        </div>
    @endif
@endsection
