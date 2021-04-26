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
                                var e = this['CartID'];
                                document.getElementsByClassName("temp")[0].innerHTML +="<div class='row'><img src=''><div class='col-md-6'><p class='GameTitle'> Game Title: " + this['ProductName'] + "</p></div><div class='col-md-6'>Product Price: " + this['ProductPrice'] + "</div>";
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