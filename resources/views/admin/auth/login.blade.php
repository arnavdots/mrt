@extends('layouts.login')
@section('content')
<div class="login-outer">
 <div class="login-inr dis-block clearfix">
  <h1>{{@trans('login.login_heading')}}</h1>
  {{  Form::open(array('route' => 'admin.auth')) }}
    {{ csrf_field() }}
	<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} clearfix ">
		{{ Form::label('email', @trans('login.email')) }}
		{{ Form::text('email', old('email'), array('class' => 'form-control','type'=>'email','id'=>'email', 'autofocus' => 'true')) }}
		@if ($errors->has('email'))
			<span class="help-block">
				<strong>{{ $errors->first('email') }}</strong>
			</span>
		@endif
  </div>
  <div class="form-group clearfix {{ $errors->has('password') ? ' has-error' : '' }}">
   {{ Form::label('password', @trans('login.password')) }}
   {{ Form::password('password', array('class' => 'form-control','id'=>'password')) }}
	@if ($errors->has('password'))
		<span class="help-block">
			<strong>{{ $errors->first('password') }}</strong>
		</span>
	@endif
  </div>
  <div class="dis-block lgn1 clearfix">
  
   <div class="pull-left check-custom chk-lt">
     {{ Form::checkbox('remember', 1, null, ['id'=>'chh1', 'class' => '']) }}
     {{ Form::label('chh1', @trans('login.Remember_me')) }}
    
   </div>
   {{ link_to_route('password.forgot-password', @trans('login.forgot_password'), $parameters = [], $attributes = ['class'=>'pull-right frg-btn'])}}
  </div>
  <div class="dis-block padding-top20 text-right clearfix">
  {{ Form::submit(@trans('login.login_btn'), array('class'=>"btn cmn-btn green-btn"))}}
  </div>
  {{ Form::close() }}
 </div>
</div>
@endsection
