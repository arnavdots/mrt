
<div class="dashboard-box1 dis-block clearfix">   
    {{ Form::button(__('user::user.add_user'), ['type' => 'button', 'id' => 'adddPopupForm', 'class'=>'editPopupForm cmn-add-btn pull-left', 'onclick'=>"addEditPopupForm('')", 'data-href' => $url]) }}
    
    {{ Form::open(['url' => 'admin/users', 'method' => 'post', 'id' => "recordSearch"]) }}
    <div class="dis-inline pull-left top-rt-form">      
        <div class="wd1 cmn-top-form">
            <label>{{ __('user::user.search_title') }}</label>
            <div class="wd-inr1">
                {{ Form::text('search', null, ['placeholder' => __('user::user.search'), 'class' => 'form-control', 'id' => "search" ]) }}
            </div>
        </div>
<!--        <div class="wd2 cmn-top-form">
            <label>{{ __('user::user.role') }}:</label>
            <div class="wd-inr2">
                {{ Form::select('role', $roles, null, ['class' => 'form-control']) }}
            </div>
        </div>-->
        <div class="wd3 cmn-top-form">
            <label>{{ __('user::user.status') }}:</label>
            <div class="wd-inr3">
                {{ Form::select('status', ['' => 'All', '1' => 'Active', '0' => 'Deactive'], null, ['class' => 'form-control']) }}
            </div>
        </div>            
    </div>
        <div class="pull-right rt-btn2">
            @include('user::partials.export_buttons')
        </div>
         {{ Form::close() }}
</div>