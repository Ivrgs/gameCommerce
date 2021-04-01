@extends('layouts.master')
@section('title', '| '.$shop->product_name)
@section('shopcontents')

<p> {{ $shop->product_image }}</p>
<p>Game Title: {{ $shop->product_name }}</p>
<p>Description: {{ $shop->product_description }}</p>
<p> Platform: {{ $shop->product_platform }}</p>
<p>
    @if ($shop->product_quantity == 0 || $shop->product_status == 0)
    Out of Stock
   @else
In Stock
   @endif


<p>Php. @if($shop->sale_price == 0.00)
          {{ $final_price = $shop->product_price }}.00</p>
        @else
          {{ $final_price = $shop->sale_price }}.00</p>
        @endif
<p>






  @if(Auth::user() == '')
  {{Form::button('Wishlist', ['class'=>'btn btn-info'])}}
  @else
  @if($wish == true)
  {!!Form::open(['action'=>['ShopController@wishdestroy'], 'method'=>'POST'])!!}
  @else
  {!!Form::open(['action'=>['ShopController@wishstore'], 'method'=>'POST'])!!}
  @endif



  {{Form::hidden('user_id', Auth::user()->id)}}
  {{Form::hidden('product_id', $shop->id)}}

    @if($wish == true)
    {{Form::submit('Remove Wishlist', ['class'=>'btn btn-info'])}}

    @elseif($wish == false)
    {{Form::submit('Wishlist', ['class'=>'btn btn-info'])}}
    @else
    @endif
    {!! Form::close()!!}

  @endif

@if(Auth::user() == '')
{{Form::button('Add to cart', ['class'=>'btn btn-primary'])}}
@else
{!!Form::open(['action'=>['ShopController@store'], 'method'=>'POST'])!!}
{{Form::hidden('user_id', Auth::user()->id)}}
{{Form::hidden('product_id', $shop->id)}}
{{Form::text('product_quantity', '1', ['class' => 'form-control', 'required'])}}
{{Form::hidden('product_final_price', $final_price )}}
{{Form::hidden('_method','POST')}}
{{Form::hidden('purchase_method', 'to_cart')}}
{{Form::submit('Buy Now', ['class'=>'btn btn-warning', 'name'=> 'purchase_method'])}}
{{Form::submit('Add to cart', ['class'=>'btn btn-primary', 'name'=> 'purchase_method'])}}
{!! Form::close()!!}
@endif

{{-- <button  data-toggle="modal" data-target="#exampleModal">Review</button></a>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">{{ $shop->product_name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {!!Form::open(['action'=>['HomeController@updatePassword', Auth::user()->id], 'method'=>'POST'])!!}
          <div class="form-group">
              <p>{{Form::label('Review Item','Review Item')}}</p>
                <p>{{Form::textarea('textarea', 'asd', ['class'=>'form-control', 'rows'=>4, 'style' => 'resize:none'])}}</p>
                  <p>{{Form::label('Rating','Rating')}}</p>
                <p>1 {{Form::radio('rating', '1', false)}}</p>
                <p>2 {{Form::radio('rating', '2', false)}}</p>
              <p>3 {{Form::radio('rating', '3', false)}}</p>
                <p>4 {{Form::radio('rating', '4', false)}}</p>
                  <p>5 {{Form::radio('rating', '5', true)}}</p>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        {{Form::hidden('_method','POST')}}
        {{Form::submit('Rate', ['class'=>'btn btn-primary'])}}
        {!! Form::close()!!}
      </div>
    </div>
  </div>
</div> --}}


 <!-- Tab links -->
 <div class="tab">
    <button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen">System Requirements</button>
    <button class="tablinks" onclick="openCity(event, 'Paris')">Reviews</button>

  </div>

  <!-- Tab content -->
  <div id="London" class="tabcontent">
    @if($system == 'error')
    Not Specified
    @else
      @foreach($system as $sys)

      @if ($sys->category == "Minimum")
        <h3>{{ $sys->category }}</h3>
        <p>Processor: {{ $sys->processor}} </p>
        <p>Graphics Card: {{ $sys->graphics_card}} </p>
        <p>Memory: {{ $sys->memory}} </p>
        <p>Disk Space: {{ $sys->disk_space}} </p>
        <p>Platform: {{ $sys->platform}} </p>

      @elseif ($sys->category == "Recomended")
      <h3>{{ $sys->category }}</h3>
      <p>Processor: {{ $sys->processor}} </p>
      <p>Graphics Card: {{ $sys->graphics_card}} </p>
      <p>Memory: {{ $sys->memory}} </p>
      <p>Disk Space: {{ $sys->disk_space}} </p>
      <p>Platform: {{ $sys->platform}} </p>

      @else
      @endif

      @endforeach
  @endif

  </div>

  <div id="Paris" class="tabcontent">
    @if($review == 'error')
      No Reviews Found
    @else

      @foreach($user as $u)
        <p> {{ $u->username }}</p>
      @endforeach

       @foreach($review as $rev)

        <p>{{ $rev->review_notes }}</p>
        <p>{{ $rev->review_rating }}</p>
        @endforeach
    @endif
  </div>

@endsection
