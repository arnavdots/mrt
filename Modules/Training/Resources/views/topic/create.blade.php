<!--Add New Popup-->
<div id="new-topic-popup" class="modal fade custom-popup2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::button(__('training::topic.title.close'), ['type' => 'button', 'class'=>'close-btn', 'data-dismiss'=>'modal']) !!}
            <div class="pop-inr-box1 dis-block clearfix">  
                <!--ajax response div-->
                <div class="ajaxResponse"></div>
                {{ Form::model($topic, ['id' => 'addEditForm', 'route' => $url, 'method' => 'post']) }}
                {{ Form::hidden('id') }}
                <div class="popup-form-box dis-block clearfix">
                    <div class="frm-wd-full cmn-popup-form">
                        <div class="form-group clearfix">
                            {!! Form::label(__('training::topic.label.section')) !!}
                            <div class="field1">
                                {!! Form::select('section', $sections, @$topic->section_id, ['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {!! Form::label(__('training::topic.label.name')) !!}
                            <div class="field1">
                                {{ Form::text('name', null, ['placeholder' => __('training::topic.placeholder.name'), 'class' => 'form-control', 'required']) }}
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {{ Form::label(__('training::topic.label.status')) }}
                            <div class="check-custom chk-lt">
                                {{ Form::checkbox('is_active', null, ($topic->is_active) ? true : (!isset($topic->is_active) ? true : false), ['id'=>'is_active']) }}
                                <label for="is_active"></label>
                            </div>                            
                        </div>
                        <div class="dis-block text-right clearfix">
                            {{ Form::button(__('training::topic.title.submit'), ['type' => 'button', 'id' => 'submitForm', 'onclick' => "addEditForm()", 'class'=>'btn cmn-btn green-btn margin-right5']) }}
                            {{ Form::button(__('training::topic.title.cancel'), ['type' => 'cancel', 'id' => 'cancelForm', 'class'=>'btn cmn-btn red-btn', "data-dismiss"=>"modal"]) }}
                        </div>
                    </div>
                {{ Form::close() }}
                </div> 
            </div>
        </div>
    </div>
</div>