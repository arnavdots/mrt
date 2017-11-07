@extends('layouts.backend')

@section('content')

<div class="box">

    <div class="box-header">
        <h3 class="box-title">{{ __('permission::permission.title.edit') }}</h3>
    </div><!-- /.box-header -->

    <div class="box-body">
 
        {{ Form::model($permission, ['url' => 'permission/update/'.$permission->id, 'method' => 'patch']) }}
   
        <div class="form-group">

            {{ Form::label(__('permission::permission.label.name')) }}
            {{ Form::text('name', null, ['placeholder' => __('permission::permission.label.name'), 'class' => 'form-control', 'value'=>$permission->name]) }}
            @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
        </div>


        <div class="form-group">
            {{ Form::label(__('permission::permission.label.display_name')) }}
            {{ Form::text('display_name', null, ['placeholder' => __('permission::permission.label.display_name'), 'class' => 'form-control']) }}
            @if ($errors->has('display_name'))
            <span class="help-block">
                <strong>{{ $errors->first('display_name') }}</strong>
            </span>
            @endif

        </div>

        <div class="form-group">
            {{ Form::label(__('permission::permission.label.description')) }}
            {{ Form::text('description', null, ['placeholder' => __('permission::permission.label.description'), 'class' => 'form-control']) }}
            @if ($errors->has('display_name'))
            <span class="help-block">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
            @endif

        </div>

        <div class="form-group">
            {{ Form::hidden('id') }}
            {{ Form::submit('Submit', ['name' => 'submit']) }}
        </div>

        {{ Form::close() }}

    </div>
</div>             

@stop