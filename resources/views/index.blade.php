@extends('layouts.master')
@section('shopcontents')
<div class="container">
                <div class="title m-b-md">

                    Laravel
                </div>

                @if(count($shop) >0)
                    @foreach ($shop as $items)
                                                         <div class="row">
                        <div class="col-md-2"><p>
                                                        <div>
                                                         @if($items->product_image =="")
                                                         <img src="/images/imageholder.png" style="width:250px;">
                                                         @else
                                                         <img src="{{$items->product_image}}" style="width:250px;">
                                                         @endif
                                                         </div>
                                                            {{ $items->product_name }}
                                                            {{ $items->product_slug }}
                        </p></p>
                        Php. {{ $items->product_price }}.00
 </p><p><a href="{{ route('View Item', $items->product_slug) }}"><button >View</button></a></p>


                    </div>
                                                         </div>
                        @endforeach

                @else
                <p>No inventory found</p>
                @endif

            </div>

@endsection
