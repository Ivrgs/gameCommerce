@if(Auth::user() == null)
            @else
            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title cart-title" id="exampleModalLabel">
                      <div class="Numb"></div>
                    </h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body cart-body">
                        <div class="temp"></div>
                        <div class="Total"></div>
                        <div class="Price"></div>

                    </div>
                    <div class="cart-footer modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <a href="{{ url("viewCart/".Auth::user()->id) }}"><button type="button" class="btn btn-info">Checkout</button></a> --}}
                    {!!Form::open(['action'=>['CartController@destroy'], 'method'=>'POST'])!!}
                    {{Form::hidden('user_id', Auth::user()->id)}}
                    {{Form::hidden('_method','POST')}}
                    {{Form::submit('Clear Cart', ['class'=>'btn btn-danger','name'=>'CartMethod'])}}
                    {!! Form::close()!!}

                    {!!Form::open(['action'=>['CartController@index'], 'method'=>'POST'])!!}
                    {{Form::hidden('user_id', Auth::user()->id)}}
                    {{Form::hidden('_method','POST')}}
                    {{Form::submit('Checkout', ['class'=>'btn btn-info'])}}
                    {!! Form::close()!!}
                </div>
                  </div>
                </div>
              </div>
              @endif

              <div class="modal fade" id="viewOrder" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> </h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                      <div class="row temp2"></div>
                      <div class="OrderTotal"></div>
                      <div class="OrderPrice"></div>

                    </div>
                    <div class="modal-footer OrderFooter">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                  </div>
                </div>
              </div>