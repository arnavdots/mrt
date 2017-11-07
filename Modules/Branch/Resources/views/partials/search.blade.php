
<div class="dashboard-box1 dis-block clearfix">
    
    <!--{{ Form::button(__('user::user.add_user'), ['type' => 'button', 'class'=>'new-enquiry-btn pull-left', 'data-toggle'=>'modal', 'data-target'=>'#new-user-popup']) }}-->
    {{ Form::button(__('branch::branch.add_branch'), ['type' => 'button', 'id' => 'adddPopupForm', 'class'=>'editPopupForm cmn-add-btn pull-left', 'onclick'=>"addEditPopupForm('')", 'data-href' => $url,]) }}
    
    {{ Form::open(['url' => 'admin/branch', 'method' => 'post', 'id' => "recordSearch"]) }}
    <div class="dis-inline pull-left top-rt-form">
      
        <div class="wd1 cmn-top-form">
            <label>{{ __('branch::branch.search_title') }}</label>
            <div class="wd-inr1">
                {{ Form::text('search', null, ['placeholder' => __('branch::branch.search'), 'class' => 'form-control', 'id' => "search" ]) }}
            </div>
        </div>

        <div class="wd3 cmn-top-form">
            <label>{{ __('branch::branch.status') }}:</label>
            <div class="wd-inr3">
                {{ Form::select('status', ['' => 'All', '1' => 'Active', '0' => 'Deactive'], null, ['class' => 'form-control']) }}
            </div>
        </div>
        
      
        
     
        
            
    </div>
        
         {{ Form::close() }}
</div>