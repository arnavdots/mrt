@extends('layouts.backend')
@section('content')

<div class="global-form-page dis-block clearfix padding30">
    <h1>{{__('permission::permission.title.assign-permission')}}</h1>
<div class="form-line dis-block clearfix">
    {{ Form::open(array('route' => 'permission', 'method' => 'post' ,'id' => "permissionSearch")) }}
	

	<div class="row">
<div class="col-md-4">
            <div class="form-group global-form clearfix">

                {!! Form::select('user_id', ['' => 'Select user'] +$users, '0', ['class' => 'form-control select2-single']) !!}
                @if ($errors->has('user_id'))
                <span class="help-block">
                    <strong style="color:red;">{{ $errors->first('user_id') }}</strong>
                </span>
                @endif
            </div>
</div>
   <div class="col-md-4">
   
            <div class="form-group">
                {{ Form::submit('Go', ['name' => 'submit','class'=>'btn cmn-btn green-btn margin-right']) }}
            </div>
            </div>

    </div>


    {{ Form::close() }}
	</div>
	{{ Form::model('permission', ['id' => 'permissionForm', 'route' => $url, 'method' => 'post']) }}
    {{ Form::hidden('userId', $userId) }}
    <div class="row" >
        @if($permissions)
        <div class="col-md-12">
            <div class="full-wdth padding-bottom15 clearfix">                
                <div class="check-custom chk-lt">
                    <div class="row">
                    @foreach($permissions->groupBy('module_id') as $k=>$permission_module)
                    @if(++$k%3 == 0)
                        <div class="clearfix padding-bottom15"></div>
                    @endif
                    <div class="col-md-4 {{$k==2 ? 'clearfix padding-bottom15' : ''}}">
                        <h4>{{@$permission_module[0]->display_name}}</h4>
                        <div class="row">
                            @foreach($permission_module as $permission)
                            <div class="col-md-12 padding-bottom10">
                                @if(in_array(@$permission->id,$user_per)) 
                                {{ Form::checkbox('permissions[]', @$permission->id, true  ,array('id'=>@$permission->name)) }}
                                {{ Form::label(@$permission->name, @$permission->display_name) }}    
                                @else
                                {{ Form::checkbox('permissions[]', @$permission->id, false  ,array('id'=>@$permission->name)) }}
                                {{ Form::label(@$permission->name, @$permission->display_name) }}    
                                @endif
                            </div>	
                            @endforeach 
                        </div>
                    </div>	
                    @if(++$k%3 == 0)
                        <div class="clearfix padding-bottom15"></div>
                    @endif
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {{ Form::submit('Submit', ['name' => 'submit','class'=>'btn cmn-btn green-btn margin-right','id'=>'permissionFormUpdate']) }}
            </div>
        </div>
        @endif
    </div>    
    {{ Form::close() }}

</div>

@stop



