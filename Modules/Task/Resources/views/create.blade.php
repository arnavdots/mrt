<!--New-Task-Popup-->
<div id="new-task-popup" class="modal fade custom-popup1" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::button(__('task::task.title.close'), ['type' => 'button', 'class'=>'close-btn', 'data-dismiss'=>'modal']) !!}

            <div class="pop-inr-box1 dis-block clearfix">
                <!--ajax response div-->
                <div class="ajaxResponse"></div>
                {{ Form::model($task,['id' => 'addEditForm', 'route' => $url, 'method' => 'post','files'=>'true']) }}
                {{ Form::hidden('sender_id',$current_userid) }}
                {{ Form::hidden('is_completed','0') }}
                {{ Form::hidden('id') }}
                <div class="new-task-box-outer dis-block clearfix">
                    <div class="new-task-box1 dis-block clearfix">
                        <div class="task-wd1 cmn-value cmn-popup-form pull-left">
                            <div class="form-group clearfix">
                                {!! Form::label(__('task::task.label.send-to')) !!}
                                <div class="t-wd1">
                                    {!! Form::select('receiver_id', $consultants , $current_userid, ['class'=>'form-control text-right']) !!}

                                </div>
                            </div>
                        </div>
                        <div class="task-wd2 cmn-value cmn-popup-form pull-left">
                            <div class="form-group clearfix">
                                {!! Form::label(__('task::task.label.priority')) !!}
                                <div class="t-wd1">
                                    {!! Form::select('priority', $priorities, 'low', ['class'=>'form-control text-right']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="task-wd3 pull-left">
                            @foreach($views as $key=>$view)
                            <div class="radio-custom dis-inline">
                                {!! Form::radio('is_public', $key,$key == 0, ['class'=>'form-control','id'=>'task'.$view]) !!}
                                <label for="task{{ $view }}">{!! Form::label(__($view.':')) !!}</label>
                            </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="new-task-box2 dis-block clearfix">
                        <label class="dis-block notes">Notes:</label>
                        <div class="cmn-white-box1 form-box2 dis-block clearfix">
                            <div class="form-group clearfix">
                                {{ Form::textarea('description',null,['class'=>'form-control']) }}
                            </div>
                            <div class="form-group clearfix">
                                <div class="pull-left file-btn-lt">
                                    <label>File</label>
                                    <div class="file-upload-box dis-block">
                                        {{ Form::file('media_name',['class'=>'fld1']) }}
                                    </div>
                                </div>
                                <div class="pull-right rt-btn2">
                                    {{ Form::button(__('task::task.title.send-task'), ['type' => 'button', 'id' => 'submitForm', 'onclick' => "addEditForm()", 'class'=>'btn cmn-btn green-btn margin-right5']) }}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>