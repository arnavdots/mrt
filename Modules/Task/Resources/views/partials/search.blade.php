@php $addBtn = __('task::task.title.new-task') @endphp
<div class="dashboard-box1 dis-block clearfix">
    @include('elements.new_add_button')
    <div class="dis-inline pull-left top-rt-form">
        {{ Form::open(['route' => 'task', 'method' => 'post', 'id' => "recordSearch"]) }}        
        <div class="wd2 cmn-top-form">
            {!! Form::label(__('task::task.label.priority')) !!}
            <div class="wd-inr2">
                {!! Form::select('priority', $priorities, null, ['placeholder' => 'Select a priority...','class'=>'form-control']) !!}
            </div>
        </div>
        <div class="wd2 cmn-top-form">
            {!! Form::label(__('task::task.label.consultant')) !!}
            <div class="wd-inr2">
                {!! Form::select('consultant', $consultants, null, ['placeholder' => 'Select a consultant...','class'=>'form-control']) !!}                
            </div>
        </div>
        <div class="wd2 cmn-top-form">
            {!! Form::label(__('task::task.label.status')) !!}
            <div class="wd-inr2">
                {!! Form::select('is_completed', $status, null, ['placeholder' => 'Select a status...','class'=>'form-control']) !!}
            </div>
        </div>
        <div class="wd2 cmn-top-form">
            {!! Form::label(__('task::task.label.view')) !!}
            <div class="wd-inr2">
                {!! Form::select('view', $views, null, ['placeholder' => 'Select a view...','class'=>'form-control']) !!}
            </div>
        </div>
      <div class="wd5 cmn-top-form">
            <div class="wd-inr5">
              {{ Form::text('date_range', null, ['placeholder'=>'Select Date Range','class' => 'daterangeinput form-control pull-right']) }} 
            </div>
        </div>
        
        {{ Form::close() }}
    </div>
</div>

