<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>GameCommerce @yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{URL::to('/')}}/css/app.css" >
    <link rel="stylesheet" href="{{URL::to('/')}}/css/custom.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Styles -->
        <style>


        </style>
         <script type="text/javascript" src="{{URL::to('/')}}/jquery/jquery-3.5.1.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark sticky-top">
            <div class="container-fluid">
                <div class="navbar-header">
                <a class="navbar-brand" href="{{ url('/') }}">gameCommerce</a>
                </div>
                <ul class="nav navbar-nav">
                <div class="UpperOption">
                   <li class="nav-item">

                   <a class="fa fa-shopping-cart" aria-hidden="true" onclick=viewcart() }}>
                    <span class="fa fa-comment"></span>
                        <span class="num">99+</span>

                      </a>

                   </li>
                  <!-- Authentication Links -->
                  @guest
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
                  @if (Route::has('register'))
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                      </li>
                  @endif
              @else
                  <li class="nav-item dropdown">
                      <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          {{ Auth::user()->name }}
                      </a>

                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="{{ route('logout') }}"
                             onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                              {{ __('Logout') }}
                          </a>

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                              @csrf
                          </form>
                      </div>
                  </li>
              @endguest
                    </div>
                </ul>
            </div>
        </nav>


            @yield('shopcontents')
            @yield('content')
            @yield('try')

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
                        <div class="temp" id="sample"></div>
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
                                console.log(response)
                                var e = this['CartID'];
                                document.getElementsByClassName("temp")[0].innerHTML +="<div class='row'><div class='col-md-6'><p class='GameTitle'> Game Title: " + this['ProductName'] + "</p></div><div class='col-md-6'>Product Price: " + this['ProductPrice'] + "</div>";
                                // document.getElementsByClassName("temp")[0].innerHTML +="<p class='GamePrice'>Product Price: " + this['ProductPrice'] + "</p></div>";
                                document.getElementsByClassName("temp")[0].innerHTML +="<div class='row'><div class='col-md-12'><p class='GamePlatform'>Game Platform: " + this['ProductPlatform'] + "</p></div>";
                                document.getElementsByClassName("temp")[0].innerHTML += "<div class='row'><div class='col-md-6'><p class='GameQuantity'>Product Quantity: " + this['CartQuantity'] + "</p></div><div class='col-md-6'><form method='POST' action='http://localhost:8000/deletecart/"+ e +"'><input type='submit' value='Delete'></form></div></div></div><br>";
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
