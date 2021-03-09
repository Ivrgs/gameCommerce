@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h1>{{ __('Dashboard') }}</h1></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <a href="{{ url('mail') }}" ><button > Send Mail </button></a>

                    <p> {{{Auth::user()->id}}}</p>
                    <p> {{{Auth::user()->username}}}</p>
                    <p> {{{Auth::user()->email}}}</p>
                    <p> {{{Auth::user()->status}}}</p>
                    <p> {{{Auth::user()->created_at}}}</p>


                @if (session('status-error'))
                <div class="alert alert-danger">
                    {{ session('status-error') }}
                </div>
            @endif
            <a href="{{ url('orders') }}" ><button > Order History </button></a>
                    <button data-toggle="modal" data-target="#exampleModal">Change Password</button>
                    <a href="{{ url('wishlist') }}" ><button > My Wishlist </button></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          {!!Form::open(['action'=>['HomeController@updatePassword', Auth::user()->id], 'method'=>'POST'])!!}
            <div class="form-group">
                {{Form::label('password','Old Password')}}
                {{Form::password('old_password', ['class'=>'form-control'])}}
                {{Form::label('new_password','New Password')}}
                {{Form::password('new_password', ['class'=>'form-control'])}}
                {{Form::label('confirm_password','Confirm Password')}}
                {{Form::password('confirm_password', ['class'=>'form-control'])}}
            </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{Form::hidden('_method','POST')}}
          {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
          {!! Form::close()!!}
        </div>
      </div>
    </div>
  </div>

@endsection
