@extends('layouts.login')
@section('content')
<div class="login-outer">
 <div class="login-inr dis-block clearfix">

   @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif
   <form role="form" method="POST" action="{{ route('password.reset') }}">
                            <h3>Reset Password</h3>

                            {{ csrf_field() }}

                            <input type="hidden" name="token" value="{{ $token }}">

                          
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                @if ($errors->has('password'))
                                <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                                @endif
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password"/>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                @if ($errors->has('password_confirmation'))
                                <span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
                                @endif
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password"/>
                            </div>
						  <div class="dis-block padding-top20 text-right clearfix">
							 <button class="btn cmn-btn green-btn" type="submit">Reset Password</button>
						  </div>
                           

                            <div class="clearfix"></div>

                           
                        </form>
  
 </div>
</div>
@endsection
