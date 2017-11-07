<!--New-Task-Popup-->
<div id="new-task-popup" class="modal fade custom-popup1" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::button(__('task::task.title.close'), ['type' => 'button', 'class'=>'close-btn', 'data-dismiss'=>'modal']) !!}

            <div class="pop-inr-box1 dis-block clearfix">


                <div class="new-task-box-outer dis-block clearfix">
                    <!--ajax response div-->
                    <div class="ajaxResponse"></div>
                    @if($task->receiver_id == $current_userid)
                    <div class="new-task-box1 dis-block clearfix">
                        {{ Form::model($task,['id' => 'addEditFormTask', 'class'=>'addEditForm', 'route' => $url, 'method' => 'post']) }}
                        {{ Form::hidden('sender_id',$task->sender_id) }}
                        {{ Form::hidden('id') }}
                        {{ Form::hidden('is_completed','0') }}
                        <div class="task-wd1 cmn-value cmn-popup-form pull-left">
                            <div class="form-group clearfix">
                                {!! Form::label(__('task::task.label.send-to')) !!}
                                <div class="t-wd1">
                                    {!! Form::select('receiver_id', $consultants , $task->receiver_id, ['class'=>'form-control text-right']) !!}

                                </div>
                            </div>
                        </div>
                        <div class="task-wd2 cmn-value cmn-popup-form pull-left">
                            <div class="form-group clearfix">
                                {!! Form::label(__('task::task.label.priority')) !!}
                                <div class="t-wd1">
                                    {!! Form::select('priority', $priorities, $task->priority, ['class'=>'form-control text-right']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="task-wd3 pull-left">
                            @foreach($views as $key=>$view)
                            <div class="radio-custom dis-inline">
                                {!! Form::radio('is_public', $key, $task->is_public, ['class'=>'form-control','id'=>'task'.$view]) !!}
                                <label for="task{{ $view }}">{!! Form::label(__($view.':')) !!}</label>
                            </div>
                            @endforeach

                        </div>
                        <div class="frm-wd2 pull-left">
                            <div class="dis-block clearfix btn-outer1">
                                <div class="cmn-btn-wd">
                                    {{ Form::button(__('task::task.title.send-task'), ['type' => 'submit', 'class'=>'btn cmn-btn green-btn margin-right5']) }}
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}

                        {{ Form::model($task,['id' => 'completeFormTask', 'class'=>'addEditForm', 'route' => $task_complete_url, 'method' => 'post']) }}
                        {{ Form::hidden('id',$task->id) }}
                        {{ Form::hidden('is_completed','1') }}

                        <div class="frm-wd2 pull-right">
                            <div class="dis-block clearfix btn-outer1">
                                <div class="cmn-btn-wd">
                                    {{ Form::button(__('task::task.title.completed-task'), ['type' => 'submit', 'class'=>'btn cmn-btn green-btn margin-right5']) }}
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                    @else
                    <p>Send To : {!! ucfirst(MrtHelpers::concnate(@$task->users->first_name,@$task->users->last_name)) !!}</p>
                    <p>Priority : {!! $priorities[$task->priority] !!}</p>
                    <p>Public/Private : {!! $views[$task->is_public] !!}</p>
                    @endif
                    <div class="new-task-box2 dis-block clearfix">

                        <label class="dis-block notes">Notes:</label>
                        <div class="cmn-white-box1 form-box2 dis-block clearfix">
                            {{ Form::model($task,['id' => 'addEditForm', 'class'=>'addEditForm','route' => $note_url, 'method' => 'post','files'=>'true']) }}
                            {{ Form::hidden('user_id',$current_userid) }}
                            {{ Form::hidden('task_id',$task->id) }}
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
                                    {{ Form::button(__('task::task.title.save-note'), ['type' => 'submit', 'id' => 'submitForm', 'class'=>'btn cmn-btn grey-btn margin-right5']) }}

                                </div>
                            </div>
                            {{ Form::close() }}
                            <div class="scroll-box dis-block clearfix">
                                <div class="scroll-inr-box dis-block clearfix">
                                    @forelse($task->notes as $notes)
                                    <div class="task-loop-box dis-block clearfix">
                                        <div class="task-date"> {!! MrtHelpers::dateFormat(@$notes->created_at) !!} <span>{!! MrtHelpers::timeFormat(@$notes->created_at) !!}</span> </div>
                                        <div class="task-dtl">
                                            <p><strong>{!! ucfirst(MrtHelpers::concnate(@$notes->users->first_name,@$notes->users->last_name)) !!}:</strong> {!! $notes->description !!}</p>
                                            @if(!empty($notes->taskMedia[0]->media_name))
                                            <div class="docx-file-box dis-block clearfix">
                                                <div class="doc-name dis-block">Document name</div>
                                                <ul class="dis-block clearfix">
                                                    <li>{!! @$notes->taskMedia[0]->media_name !!}</li>
                                                </ul>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @empty

                                    @endforelse
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>