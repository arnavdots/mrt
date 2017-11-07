@extends('test::layouts.master')

@section('content')
    
    {{ Form::open(['method' => 'post', 'files' => true]) }}
    
    
    {{ Form::text('product_id') }}
    {{ Form::file('image') }}
        
    
    {{ Form::button('Submit', ['type' => 'submit']) }}
    {{ Form::button('Cancel', ['type' => 'cancel']) }}
    
    {{ Form::close() }}
    
    
@stop
