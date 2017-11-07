<div id="new-user-popup" class="modal fade custom-popup2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <button type="button" class="close-btn" data-dismiss="modal">{{ __('user::user.close') }}</button>
            <div class="pop-inr-box1 dis-block clearfix">
                
                <!--ajax response div-->
                <div class="ajaxResponse"></div>
                
                {{ Form::model($user, ['id' => 'addEditForm', 'route' => $url, 'method' => 'post']) }}
                
                {{ Form::hidden('id') }}
                
                <div class="popup-form-box dis-block clearfix">
                    <div class="frm-wd-full cmn-popup-form">
                        <div class="form-group clearfix">
                            {{ Form::label(null, __('user::user.first_name').' *') }}
                            <div class="field1">
                                {{ Form::text('first_name', null, ['placeholder' => __('user::user.first_name'), 'class' => 'form-control', 'required']) }}
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {{ Form::label(null, __('user::user.last_name').' *') }}
                            <div class="field1">
                                {{ Form::text('last_name', null, ['placeholder' => __('user::user.last_name'), 'class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {{ Form::label(null, __('user::user.email').' *') }}
                            <div class="field1">
                                {{ Form::text('email', null, ['placeholder' => __('user::user.email'), 'class' => 'form-control', $disabled, 'required', 'type' => 'email']) }}
                            </div>
                        </div>
                 
                        <div class="form-group clearfix">
                            {{ Form::label(__('user::user.mobile')) }}
                            <div class="field1">
                                {{ Form::text('mobile', null, ['placeholder' => __('user::user.mobile'), 'class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {{ Form::label(__('user::user.role')) }}
                            <div class="field1">
                                {{ Form::select('role', $roles, $userRole, ['class'=>'form-control text-right']) }}
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {{ Form::label(__('user::user.status')) }}
                            <div class="check-custom chk-lt">
                                {{ Form::checkbox('is_active', null, ($user->is_active) ? true : (!isset($user->is_active) ? true : false), ['id'=>'is_active']) }}
                                <label for="is_active"></label>
                            </div>                            
                        </div>
					  <div class="form-group clearfix">
						{{ Form::label(__('user::user.remote_access')) }}
						<div class="check-custom chk-lt">
							{{ Form::checkbox('remote_access', null, ($user->remote_access) ? true : (!isset($user->remote_access) ? true : false), ['id'=>'remote_access']) }}
							<label for="remote_access"></label>
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
