<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>GameCommerce @yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{URL::to('/')}}/css/app.css">
        <link rel="stylesheet" href="{{URL::to('/')}}/css/custom.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark sticky-top">
            <div class="container-fluid">
                <div class="row" style="width: 100%;">
                    <div class="col-md-9">
                        <div class="navbar-header">
                        <a class="navbar-brand" href="{{ url('/') }}">gameCommerce</a>
                        </div>
                    </div>

                    <div class="col-md-1">
                    <a onclick=viewcart()>
                        <i class="fa fa-shopping-cart" aria-hidden="true">

                            <span class="num">99+</span>
                        </i>
                    </a>

                    </div>
                    <div class="col-md-2">
                        @if (Route::has('login'))

                        <div class="top-right links">
                            <div class="UpperOption">
                            @auth
                            @if($errors->any())
                            <h4>{{$errors->first()}}</h4>
                            @endif
                                <a href="{{ url('/home') }}">  {{{ isset(Auth::user()->id) ? Auth::user()->username : Auth::user()->username }}}</a>
                            @else

                            @if (session('status-success'))
                            <span class="alert alert-success">
                                {{ session('status-success') }}
                            </span>
                            @endif


                                <a href="{{ route('login') }}">Login</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}">Register</a>
                                @endif
                            @endauth


                        </div>
                    @endif
                        </div>
                    </div>
                </div>



                <ul class="nav navbar-nav">



                </ul>
            </div>
        </nav>


            @yield('shopcontents')

            <footer class="InputFullWidth">
                <div class="row">
                    <div class="col-md-12">
                    <div class="BelowDivider"></div>
                    </div>
                </div>
                <div class="row FooterColor">
                    <div class="col-md-9"></div>
                </div>

                <div class="FooterCopyright">©2021 gameCommerce by
                    <a href="https://www.youtube.com/channel/UC8RDEeP-XQjgBgJFsJ8lgrg"> iVrgsTECH.</a>
                    <span> All Right Reserved.</span>
                </div>
            </footer>
            @if(Auth::user() == null)
            @else
            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <div class="temp"></div>
                        <div class="Total"></div>
                        <div class="Price"></div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <a href="{{ url("viewCart/".Auth::user()->id) }}"><button type="button" class="btn btn-info">Checkout</button></a> --}}
                    {!!Form::open(['action'=>['ShopController@checkout'], 'method'=>'POST'])!!}
                    {{Form::hidden('user_id', Auth::user()->id)}}
                    {{Form::hidden('_method','POST')}}
                    {{Form::submit('Checkout', ['class'=>'btn btn-info'])}}
                    {!! Form::close()!!}
                </div>
                  </div>
                </div>
              </div>
              @endif
    </body>
{{--AJAX Modal --}}

 @if(Auth::user() == null)
@else
    <script type="text/javascript">
        function viewcart(){
            $('#modal').modal('show');
            $('.modal-title').text('My Cart');
                //Ajax Load data from ajax
            $(document).ready(function() {
                $.ajax({
                    url :'{{ route('ShopViewCart', Auth::user()->id) }}',
                    type: "GET",
                    dataType: "JSON",
                    success: function(response){
                        if(response.ProductDetails == 0 || response.Total == 0){
                            $(".modal-body").html("<b>You don't have any items in your cart, Shop now.</b>");
                        }else{
                            $.each(response.ProductDetails, function(){

                                document.getElementsByClassName("temp")[0].innerHTML +="<div class='row'><img src=''><div class='col-md-6'><p class='GameTitle'> Game Title: " + this['ProductName'] + "</p></div><div class='col-md-6'>Product Price: " + this['ProductPrice'] + "</div>";
                                // document.getElementsByClassName("temp")[0].innerHTML +="<p class='GamePrice'>Product Price: " + this['ProductPrice'] + "</p></div>";
                                document.getElementsByClassName("temp")[0].innerHTML +="<div class='row'><div class='col-md-12'><p class='GamePlatform'>Game Platform: " + this['ProductPlatform'] + "</p></div>";
                                document.getElementsByClassName("temp")[0].innerHTML += "<div class='col-md-6'><p class='GameQuantity'>Product Quantity: " + this['CartQuantity'] + "</p></div><div class='col-md-6'></div></div><br>";
                            });

                            $.each(response.Total, function(){
                                document.getElementsByClassName("Total")[0].innerHTML ="Total Quantity:" +  this['TotalQuantity'] + "";
                                document.getElementsByClassName("Price")[0].innerHTML ="Total Price: " + this['TotalPrice'] + "";
                            });

                            $("#modal").on("hidden.bs.modal", function(){
                                $('.temp').empty();
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown){
                        alert('Data not Found');
                    }
                });
            });
        }
    </script>
 @endif
    <script type="text/javascript" src="{{URL::to('/')}}/js/popper.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/js/app.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/js/custom.js"></script>
</html>
