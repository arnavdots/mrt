

<div id="new-category-popup" class="modal fade custom-popup2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <button type="button" class="close-btn" data-dismiss="modal">{{ __('category::category.close') }}</button>
            <div class="pop-inr-box1 dis-block clearfix">
                
                <!--ajax response div-->
                <div class="ajaxResponse"></div>
                
                {{ Form::model($category, ['id' => 'addEditForm', 'route' => $url, 'method' => 'post']) }}
                
                {{ Form::hidden('id') }}
                
                <div class="popup-form-box dis-block clearfix">
                    <div class="frm-wd-full cmn-popup-form">
                        <div class="form-group clearfix">
                            {{ Form::label(null, __('category::category.name').' *') }}
                            <div class="field1">
                                {{ Form::text('name', null, ['placeholder' => __('category::category.name'), 'class' => 'form-control', 'required']) }}
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {{ Form::label(__('category::category.status')) }}
                            <div class="check-custom chk-lt">
                                {{ Form::checkbox('is_active', null, ($category->is_active) ? true : (!isset($category->is_active) ? true : false), ['id'=>'is_active']) }}
                                <label for="is_active"></label>
                            </div>                            
                        </div>
                       <div class="dis-block text-right clearfix">
                            {{ Form::button('Submit', ['type' => 'button', 'id' => 'submitForm', 'onclick' => "addEditForm()", 'class'=>'btn cmn-btn green-btn margin-right5']) }}
                            {{ Form::button('Cancel', ['type' => 'cancel', 'id' => 'cancelForm', 'class'=>'btn cmn-btn red-btn', "data-dismiss"=>"modal"]) }}
                        </div>
                    </div>
                    
                </div>
                {{ Form::close() }}
                
            </div>
        </div>
    </div>
</div>
