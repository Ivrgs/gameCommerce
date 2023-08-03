@if(Auth::user() == null)
@else
    <script type="text/javascript">

        function viewcart(){
            $('#modal').modal('show');
            $('.cart-title').text('My Cart');
                //Ajax Load data from ajax
            $(document).ready(function() {
                $.ajax({
                    url :'{{ route('Show Cart', Auth::user()->id) }}',
                    type: "GET",
                    dataType: "JSON",
                    success: function(response){
                        if(response.ProductDetails == 0 || response.Total == 0){
                            $(".cart-body").html("<b>You don't have any items in your cart, Shop now.</b>");
                            $('.cart-footer').hide();  
                        }else{
                            $.each(response.ProductDetails, function(){
                                var e = this['CartID'];
                                if(this['ProductImage'] == null){
                                    document.getElementsByClassName("temp")[0].innerHTML +="<div class='row'><img src='{{ url('images/imageholder.png') }}' style='width:100px;'>";
                                }else{
                                    document.getElementsByClassName("temp")[0].innerHTML +="<div class='row'><img src='"+this['ProductImage']+"' style='width:100px;'>";
                                }
                                document.getElementsByClassName("temp")[0].innerHTML +="<div class='col-md-6'><p class='GameTitle'> Game Title: " + this['ProductName'] + "</p></div><div class='col-md-6'>Product Price: " + this['ProductPrice'] + "</div>";
                                // document.getElementsByClassName("temp")[0].innerHTML +="<p class='GamePrice'>Product Price: " + this['ProductPrice'] + "</p></div>";
                                document.getElementsByClassName("temp")[0].innerHTML +="<div class='row'><div class='col-md-12'><p class='GamePlatform'>Game Platform: " + this['ProductPlatform'] + "</p></div>";
                                document.getElementsByClassName("temp")[0].innerHTML += "<div class='row'><div class='col-md-6'><p class='GameQuantity'>Product Quantity: " + this['CartQuantity'] + "</p></div><div class='col-md-6'><form method='GET' action='/deleteItem/' accept-charset='UTF-8'><input type='hidden' name='userID' value=' "+ this['UserID'] +"'><input type='hidden' name='itemID' value=' "+ e +"'><input type='submit' value='Delete'></form></div></div></div><br>";
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

    $( ".ViewOrder" ).submit(function( event ) {
        $('#viewOrder').modal('show');
        var orderNum = $(this).serializeArray();

        $.each(orderNum, function(i, field){
            orderNum = field.value + " ";
        });

        $.ajax({
            url :'{{ route('View Order', 'orderNum')}}',
            type: "GET",
            data: {"id" : orderNum}, 
            dataType: "JSON",
            success: function(response){
                $.each(response.OrderData, function(){
                    $('.modal-title').text("Order #: " + this['order_number']); 
                        if(this['product_image'] == null){
                        document.getElementsByClassName("temp2")[0].innerHTML +=  "<div class='col-md-4'><img src='{{ url('images/imageholder.png') }}' style='width:100px;'></img></div>";
                        }else{
                        document.getElementsByClassName("temp2")[0].innerHTML +=  "<div class='col-md-4'><img src='" + this['product_image'] + "' style='width:100px;'></img></div>";
                                                                                
                        }
                        document.getElementsByClassName("temp2")[0].innerHTML += "<div class='col-md-4'><div class=''>"+ this['product_name'] +"</div>" + 
                                                                                "<div class=''>Platform: " + this['product_platform'] + "</div>" + 
                                                                                "<div class=''>"+ this['order_quantity'] + "x</div></div>" + 
                                                                                "<div class='col-md-4'><div class=''>" + this['order_status'] +"</div>" + 
                                                                                "<div class=''>Php. " +  this['order_price']+"</div></div>";
                         $('.OrderFooter').text("Date: " + this['order_date']); 
                });

                $.each(response.TotalOrder, function(){
                    document.getElementsByClassName("OrderTotal")[0].innerHTML = this['TotalQuantity'] + " Item/s";
                    document.getElementsByClassName("OrderPrice")[0].innerHTML = "Php." + this['TotalPrice'];
                });

                $("#viewOrder").on("hidden.bs.modal", function(){
                    $('.temp2').empty();
                    $('.OrderPrice').empty();
                    $('.OrderTotal').empty();
                });
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Data not Found');
            }
        });
        event.preventDefault();
    });
    </script>
 @endif