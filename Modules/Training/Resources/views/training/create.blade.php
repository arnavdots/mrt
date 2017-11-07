<!--Add New Popup-->
<div id="new-training-popup" class="modal fade custom-popup2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::button(__('training::training.title.close'), ['type' => 'button', 'class'=>'close-btn', 'data-dismiss'=>'modal']) !!}
            <div class="pop-inr-box1 dis-block clearfix">  
                <!--ajax response div-->
                <div class="ajaxResponse"></div>
                {{ Form::model($training, ['id' => 'addEditForm', 'route' => $url, 'method' => 'post']) }}
                {{ Form::hidden('id') }}
                <div class="popup-form-box dis-block clearfix">
                    <div class="frm-wd-full cmn-popup-form">
                        <div class="form-group clearfix">
                            {!! Form::label(__('training::training.label.section')) !!}
                            <div class="field1">
                                {!! Form::select('section', $sections, @$training->section_id, ['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {!! Form::label(__('training::training.label.topic')) !!}
                            <div class="field1">
                                {!! Form::select('topic', $topics, @$training->topic_id, ['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {!! Form::label(__('training::training.label.title')) !!}
                            <div class="field1">
                                {{ Form::text('title', null, ['placeholder' => __('training::training.placeholder.title'), 'class' => 'form-control', 'required']) }}
                                @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {!! Form::label(__('training::training.label.description')) !!}
                            <div class="field1">
                                {{ Form::textarea('description', null, ['size' => '50x8', 'placeholder' => __('training::training.placeholder.description'), 'class' => 'form-control', 'required']) }}
                                @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {{ Form::label(__('training::training.label.status')) }}
                            <div class="check-custom chk-lt">
                                {{ Form::checkbox('is_active', null, ($training->is_active) ? true : (!isset($training->is_active) ? true : false), ['id'=>'is_active']) }}
                                <label for="is_active"></label>
                            </div>                            
                        </div>
                        <div class="dis-block text-right clearfix">
                            {{ Form::button(__('training::training.title.submit'), ['type' => 'button', 'id' => 'submitForm', 'onclick' => "addEditForm()", 'class'=>'btn cmn-btn green-btn margin-right5']) }}
                            {{ Form::button(__('training::training.title.cancel'), ['type' => 'cancel', 'id' => 'cancelForm', 'class'=>'btn cmn-btn red-btn', "data-dismiss"=>"modal"]) }}
                        </div>
                    </div>
                {{ Form::close() }}
                </div> 
            </div>
        </div>
    </div>
</div>