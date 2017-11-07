@php $allStatus = MrtHelpers::getStatus() @endphp
@php $addBtn = __('training::training.title.new-training') @endphp
<div class="dashboard-box1 dis-block clearfix">    
    @include('elements.new_add_button')
    <div class="dis-inline pull-left top-rt-form">
        {{ Form::open(['route' => 'training', 'method' => 'post', 'id' => "recordSearch"]) }}
        <div class="wd1 cmn-top-form">
            {!! Form::label(__('training::training.label.search')) !!}     
            <div class="wd-inr1">
                {{ Form::text('search', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="wd3 cmn-top-form">
            {!! Form::label(__('training::training.label.status')) !!}
            <div class="wd-inr1">
                {!! Form::select('status', $allStatus, null, ['class'=>'form-control']) !!}
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>

