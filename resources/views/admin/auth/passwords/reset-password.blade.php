@extends('layouts.login')
@section('content')
<div class="login-outer">
 <div class="login-inr dis-block clearfix">
 <h1>{{@trans('forgot-password.reset_password')}}</h1>
   @if (session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
  @endif
  {{  Form::open(array('route' => 'password.reset')) }}
   <form role="form" method="POST" action="{{ route('password.reset') }}">
    {{ csrf_field() }}
	{{ Form::hidden('token', $token) }}   
	<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} clearfix ">
		{{ Form::label('email', @trans('forgot-password.email')) }}
		{{ Form::text('email',  $email or old('email'), array('class' => 'form-control','type'=>'email','id'=>'email')) }}
		@if ($errors->has('email'))
			<span class="help-block">
				<strong>{{ $errors->first('email') }}</strong>
			</span>
		@endif
  </div>
	<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
		{{ Form::label('password', @trans('forgot-password.password')) }}
		{{ Form::password('password', array('class' => 'form-control','id'=>'password')) }}
		@if ($errors->has('password'))
		<span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
		@endif
	</div>

	<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
		{{ Form::label('confirm_password', @trans('forgot-password.confirm_password')) }}
		{{ Form::password('password_confirmation', array('class' => 'form-control','id'=>'password_confirmation')) }}
		@if ($errors->has('password_confirmation'))
			<span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
		@endif
	</div>
    <div class="dis-block padding-top20 text-right clearfix">
	  {{ Form::submit(@trans('forgot-password.reset_btn'), array('class'=>"btn cmn-btn green-btn"))}}
    </div>
    <div class="clearfix"></div>
 {{ Form::close() }}    
  
 </div>
</div>
@endsection
