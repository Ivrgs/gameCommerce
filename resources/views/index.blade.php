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
                                                            {{ $items->product_name }}
                        </p></p>
                        Php. {{ $items->product_price }}.00
 </p><p><a href="{{ route('ShopViewItem', $items->id) }}"><button >View</button></a></p>


                    </div>
                                                         </div>
                        @endforeach

                @else
                <p>No inventory found</p>
                @endif

            </div>

@endsection
