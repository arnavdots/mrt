

<div id="new-branch-popup" class="modal fade custom-popup2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <button type="button" class="close-btn" data-dismiss="modal">{{ __('branch::branch.close') }}</button>
            <div class="pop-inr-box1 dis-block clearfix">
                
                <!--ajax response div-->
                <div class="ajaxResponse"></div>
                
                {{ Form::model($branch, ['id' => 'addEditForm', 'route' => $url, 'method' => 'post']) }}
                
                {{ Form::hidden('id') }}
                {{ Form::hidden('id',$branch->id,array('class'=>'hidden-form-id')) }}
                
                <div class="popup-form-box dis-block clearfix">
                    <div class="frm-wd-full cmn-popup-form">
                        <div class="form-group clearfix">
                            {{ Form::label(null, __('branch::branch.name').' *') }}
                            <div class="field1">
                                {{ Form::text('name', null, ['placeholder' => __('branch::branch.name'), 'class' => 'form-control', 'required']) }}
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {{ Form::label(null, __('branch::branch.branch_code').' *') }}
                            <div class="field1">
                                {{ Form::text('branch_code', null, ['placeholder' => __('branch::branch.branch_code'), 'class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {{ Form::label(null, __('branch::branch.address_line_1').' *') }}
                            <div class="field1">
                                {{ Form::text('address_line_1', null, ['placeholder' => __('branch::branch.address_line_1'), 'class' => 'form-control', 'required']) }}
                            </div>
                        </div>
						 <div class="form-group clearfix">
                            {{ Form::label(null, __('branch::branch.address_line_2')) }}
                            <div class="field1">
                                {{ Form::text('address_line_2', null, ['placeholder' => __('branch::branch.address_line_2'), 'class' => 'form-control']) }}
                            </div>
                        </div>
						
                        <div class="form-group clearfix">
                            {!! Form::label(__('branch::branch.country')) !!}
                            <div class="field1">
                                {!! Form::select('country_id', $country, $selected_country, ['placeholder' => 'Select a country','class'=>'form-control text-right','id'=>'country']) !!}
                            </div>
                        </div>
						 <div class="form-group clearfix">
                            {!! Form::label(__('branch::branch.state')) !!}
                            <div class="field1 states">
							
                                {!! Form::select('state_id',[''=>'Select a state'], $selected_state, ['class'=>'form-control text-right ','id'=>'states']) !!}
                            </div>
                        </div>
						 <div class="form-group clearfix ">
                            {!! Form::label(__('branch::branch.suburb')) !!}
                            <div class="field1 cities">
                                 {!! Form::select('suburb_id',  [ ''=>'Select a suburb'], $selected_suburb, ['placeholder' => 'Select a suburb','class'=>'form-control text-right']) !!}
                            </div>
                        </div>
						 <div class="form-group clearfix">
                            {{ Form::label(null, __('branch::branch.postcode').' *') }}
                            <div class="field1">
                                {{ Form::text('postcode', null, ['placeholder' => __('branch::branch.postcode'), 'class' => 'form-control']) }}
                            </div>
                        </div>
						 <div class="form-group clearfix">
                            {{ Form::label(null, __('branch::branch.branch_ip').' *') }}
                            <div class="field1">
                                {{ Form::text('branch_ip', null, ['placeholder' => __('branch::branch.branch_ip_exp'), 'class' => 'form-control']) }}
                            </div>
                        </div>
						  <div class="form-group clearfix">
                            {{ Form::label(__('branch::branch.status')) }}
                            <div class="check-custom chk-lt">
                                {{ Form::checkbox('is_active', null, ($branch->is_active) ? true : (!isset($branch->is_active) ? true : false), ['id'=>'is_active']) }}
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
