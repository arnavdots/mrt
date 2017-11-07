
<table id="listingTable" table-model="Task" class="table table-bordered">
    <thead>
        <tr>
            <th>@sortablelink('created_at', __('task::task.title.date'))</th>
            <th>@sortablelink('users.first_name', __('task::task.title.from'))</th>
            <th>@sortablelink('is_public', __('task::task.title.view'))</th>
            <th>@sortablelink('priority', __('task::task.title.priority'))</th>
            <th>{!! __('task::task.title.notes') !!}</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody>     
        @forelse($results as $task)
        @if(MrtHelpers::exceedTime(@$task->created_at) && !$task->is_completed)
         @php $timeline = 'exceedTime' @endphp
        @else
            @php $timeline = '' @endphp
        @endif
        <tr id="RecordID_{{$task->id}}" class='{{@$timeline}}'>
            <td>{!! MrtHelpers::date_format(@$task->created_at) !!}</td>
            <td>{!! MrtHelpers::concnate(@$task->users->first_name,@$task->users->last_name) !!}</td>
            <td>{!! $views[$task->is_public] !!}</td>
            <td>{!! $priorities[$task->priority] !!} </td>
            <td>@if($task->notes){!! @$task->notes[0]->description !!}@endif</td>
            <td>
                <a class="editPopupForm" href="javascript:;" data-href="{{ route('task.edit', $task->id) }}" title="{{ __('View') }}" onclick="addEditPopupForm('{{$task->id}}');"><i class="fa fa-eye"></i></a>
            </td>
        </tr>
        </a>
        @empty
        <tr>
            <td colspan="6">{{__('task::task.title.record-not-found')}}</td>
        </tr>
        @endforelse
    </tbody>
</table>
@include('elements.pagination')