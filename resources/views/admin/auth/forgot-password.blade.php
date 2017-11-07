@extends('layouts.login')
@section('content')
<div class="login-outer">
 <div class="login-inr dis-block clearfix">
  <h1>Password Reset</h1>
   @if (session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
  @endif
    <form class="" role="form" method="POST" action="{{ route('password.email') }}">
                       
                            {{ csrf_field() }}
							 <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} clearfix ">
							 
								<input id="email" type="email" class="form-control"id="email" name="email"  placeholder="Email" >
								@if ($errors->has('email'))
									<span class="help-block">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
								@endif
							  </div>
                           <div class="dis-block padding-top20 text-right clearfix">
							<button class="btn cmn-btn green-btn" type="submit">Send Password Reset Link</button>
							 <a class="reset_pass btn btn-default pull-left" href="{{route('admin.login')}}">Back</a>
						  </div>
                           

                            <div class="clearfix"></div>

                            <div class="separator">

                                <div class="clearfix"></div>
                               
                            </div>
                        </form>
 </div>
</div>
@endsection
