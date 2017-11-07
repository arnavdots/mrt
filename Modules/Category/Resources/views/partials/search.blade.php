
<div class="dashboard-box1 dis-block clearfix">
    
    {{ Form::button(__('category::category.add_category'), ['type' => 'button', 'id' => 'adddPopupForm', 'class'=>'editPopupForm cmn-add-btn pull-left', 'onclick'=>"addEditPopupForm('')", 'data-href' => $url,]) }}
    
    {{ Form::open(['url' => 'admin/category', 'method' => 'post', 'id' => "recordSearch"]) }}
    <div class="dis-inline pull-left top-rt-form">
      
        <div class="wd1 cmn-top-form">
            <label>{{ __('category::category.search_title') }}</label>
            <div class="wd-inr1">
                {{ Form::text('search', null, ['placeholder' => __('category::category.search'), 'class' => 'form-control', 'id' => "search" ]) }}
            </div>
        </div>

        <div class="wd3 cmn-top-form">
            <label>{{ __('category::category.status') }}:</label>
            <div class="wd-inr3">
                {{ Form::select('status', ['' => 'All', '1' => 'Active', '0' => 'Deactive'], null, ['class' => 'form-control']) }}
            </div>
        </div>
         
    </div>
        <div class="pull-right rt-btn2">
            @include('category::partials.export_buttons')
        </div>
         {{ Form::close() }}
</div>