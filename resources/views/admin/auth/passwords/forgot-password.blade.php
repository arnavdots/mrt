@extends('layouts.login')
@section('content')
<div class="login-outer">
 <div class="login-inr dis-block clearfix">
  <h1>{{@trans('forgot-password.Forgot_heading')}}</h1>
   @if (session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
  @endif
   {{  Form::open(array('route' => 'password.email')) }}
     {{ csrf_field() }}
	   <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} clearfix ">
		 {{ Form::label('email', @trans('forgot-password.email')) }}
		 {{ Form::text('email', old('email'), array('class' => 'form-control','type'=>'email','id'=>'email')) }}
		@if ($errors->has('email'))
			<span class="help-block">
				<strong>{{ $errors->first('email') }}</strong>
			</span>
		@endif
	  </div>
	   <div class="dis-block padding-top20 text-right clearfix">
		{{ link_to_route('admin.login', @trans('forgot-password.back'), $parameters = [], $attributes = ['class'=>'btn cmn-btn grey-btn margin-right5'])}}
		{{ Form::submit(@trans('forgot-password.forgot_password'), array('class'=>"btn cmn-btn green-btn"))}}
	  </div>
      <div class="clearfix"></div>
    {{ Form::close() }}     
         
 </div>
</div>
@endsection
