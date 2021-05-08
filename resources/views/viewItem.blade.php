@extends('layouts.master')
@section('title', '| '.$shop->product_name)
@section('shopcontents')

@if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif

<!-- Picture -->
@if($shop->product_image == null)
<p> Picture: <img src="{{ url('images/imageholder.png') }}" style="width:100px;"></img</p>
@else
<p> Picture: <img src="{{ $shop->product_image }}" style="width:100px;"></img</p>
@endif
<!-- Sale Or Not -->
<p>Php. @if($shop->sale == 1) 
          <del>{{number_format((float)$shop->product_price, 2,'.',',') }}</del> {{ $final_price = number_format((double)$shop->sale_price, 2,'.',',')}} </p>  
          <!-- JS Function to disable Buy now and Add to cart button-->     
        @else
       {{ $final_price = number_format((float)$shop->product_price, 2,'.',',') }}</p>
          <!-- JS Function to enable Buy now and Add to cart button-->     
        @endif

@if(Auth::user() == '')
  <input type="button" value="Login First"></input>
  <!-- Product Title -->
  <p>Game Title: {{ $shop->product_name }}</p>
  <!-- Product Status -->
  <p>{{$CMSPack['cmsStatus']}}</p>
  <!-- To Cart / Buy Now -->
@else

  <!-- Wishlist -->
  @if(Auth::user() == '')
    {{Form::button('Wishlist', ['class'=>'btn btn-info'])}}
  @else
    @if($wish == true)
      {!!Form::open(['action'=>['WishController@destroy'], 'method'=>'POST'])!!}
    @else
      {!!Form::open(['action'=>['WishController@store'], 'method'=>'POST'])!!}
  @endif

    {{Form::hidden('user_id', Auth::user()->id)}}
    {{Form::hidden('product_id', $shop->id)}}

    @if($wish == true)
      {{Form::submit('Remove Wishlist', ['class'=>'btn btn-info'])}}
    @else
      {{Form::submit('Wishlist', ['class'=>'btn btn-info'])}}
    @endif
      {!! Form::close()!!}
  @endif


  @if($shop->product_status == 0)

  @else
    {!!Form::open(['action'=>['CartController@store'], 'method'=>'POST'])!!}
    {{Form::hidden('user_id', Auth::user()->id)}}
    {{Form::hidden('product_id', $shop->id)}}
    {{Form::hidden('product_quantity', '1')}}
    {{Form::hidden('product_final_price', $final_price )}}
    {{Form::submit('Buy Now', ['class'=>'btn btn-warning', 'name'=> 'purchase_method'])}}
    {!! Form::close()!!}
  @endif

  <!-- Product Title -->
  <p>Game Title: {{ $shop->product_name }}</p>
  <!-- Product Status -->
  <p>{{$CMSPack['cmsStatus']}}</p>
  <!-- To Cart / Buy Now -->

  @if($shop->product_status == 0)

  @else
    {!!Form::open(['action'=>['CartController@store'], 'method'=>'POST'])!!}
    {{Form::hidden('user_id', Auth::user()->id)}}
    {{Form::hidden('product_id', $shop->id)}}
    {{Form::text('product_quantity', '1', ['class' => 'form-control', 'required'])}}
    {{Form::hidden('product_final_price', $final_price )}}
    {{Form::submit('Add to cart', ['class'=>'btn btn-primary', 'name'=> 'purchase_method'])}}
    {!! Form::close()!!}
  @endif
@endif

<!-- Description -->
<p>Description: {{ $shop->product_description }}</p>
<!-- Platform -->
<p> Platform: {{ $CMSPack['cmsPlatform'] }}</p>
<!-- Product Quantity -->
<p>{{ $shop->product_quantity }} Available</p>

<!-- Next Section -->
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
