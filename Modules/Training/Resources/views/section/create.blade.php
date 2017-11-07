<!--Add Popup-->
<div id="new-topic-popup" class="modal fade custom-popup2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::button(__('training::section.title.close'), ['type' => 'button', 'class'=>'close-btn', 'data-dismiss'=>'modal']) !!}
            <div class="pop-inr-box1 dis-block clearfix">  
                <!--ajax response div-->
                <div class="ajaxResponse"></div>
                {{ Form::model($section, ['id' => 'addEditForm', 'route' => $url, 'method' => 'post']) }}
                {{ Form::hidden('id') }}
                <div class="popup-form-box dis-block clearfix">
                    <div class="frm-wd-full cmn-popup-form">
                        <div class="form-group clearfix">
                            {!! Form::label(__('training::section.label.name')) !!}
                            <div class="field1">
                                {{ Form::text('name', null, ['placeholder' => __('training::section.placeholder.name'), 'class' => 'form-control', 'required']) }}
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {{ Form::label(__('training::section.label.status')) }}
                            <div class="check-custom chk-lt">
                                {{ Form::checkbox('is_active', null, ($section->is_active) ? true : (!isset($section->is_active) ? true : false), ['id'=>'is_active']) }}
                                <label for="is_active"></label>
                            </div>                            
                        </div>
                        <div class="dis-block text-right clearfix">
                            {{ Form::button(__('training::section.title.submit'), ['type' => 'button', 'id' => 'submitForm', 'onclick' => "addEditForm()", 'class'=>'btn cmn-btn green-btn margin-right5']) }}
                            {{ Form::button(__('training::section.title.cancel'), ['type' => 'cancel', 'id' => 'cancelForm', 'class'=>'btn cmn-btn red-btn', "data-dismiss"=>"modal"]) }}
                        </div>
                    </div>
                {{ Form::close() }}
                </div> 
            </div>
        </div>
    </div>
</div>