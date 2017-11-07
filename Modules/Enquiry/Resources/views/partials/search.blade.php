<div class="dashboard-box1 dis-block clearfix">
    {!! Form::button(__('enquiry::enquiry.title.new-enquiry'), ['type' => 'button', 'class'=>'cmn-add-btn pull-left', 'data-toggle'=>'modal', 'data-target'=>'#new-enq-popup']) !!}
    <div class="dis-inline pull-left top-rt-form">
        {{ Form::open(['url' => 'admin/enquiries', 'method' => 'post', 'id' => "recordSearch"]) }}
        <div class="wd1 cmn-top-form">
            {!! Form::label(__('enquiry::enquiry.label.search')) !!}     
            <div class="wd-inr1">
                {{ Form::text('search', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="wd2 cmn-top-form">
            {!! Form::label(__('enquiry::enquiry.label.consultant')) !!}
            <div class="wd-inr2">
                {!! Form::select('consultant', $consultants, null, ['placeholder' => 'Select a consultant...','class'=>'form-control']) !!}                
            </div>
        </div>
        <div class="wd2 cmn-top-form">
            {!! Form::label(__('enquiry::enquiry.label.status')) !!}
            <div class="wd-inr2">
                {!! Form::select('status', $status, null, ['placeholder' => 'Select a status...','class'=>'form-control']) !!}
            </div>
        </div>
        <div class="wd2 cmn-top-form">
            {!! Form::label(__('enquiry::enquiry.label.branch')) !!}
            <div class="wd-inr2">
                {!! Form::select('branch', $branches, null, ['placeholder' => 'Select a branch...','class'=>'form-control']) !!}
            </div>
        </div>
        <div class="wd8 cmn-top-form margin0">
            <div class="wd-inr1">
                {{ Form::text('date_range', null, ['placeholder'=>'Select Date Range','class' => 'daterangeinput form-control pull-right']) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>

