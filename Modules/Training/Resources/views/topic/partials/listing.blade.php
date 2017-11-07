<table id="listingTable" class="table table-bordered">
    <thead>
        <tr>
            <th>@sortablelink('created_at', __('training::topic.title.date')) </th>
            <th>@sortablelink('name', __('training::topic.title.name')) </th>
            <th>@sortablelink('sections.name', __('training::topic.title.section')) </th>
            <th>@sortablelink('is_active', __('training::topic.title.status')) </th>
            <th>{!! __('training::topic.title.actions') !!}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($results as $value)
        <tr id="RecordID_{{$value->id}}">
            <td>{!! MrtHelpers::date_format(@$value->created_at) !!}</td>
            <td>{!! ucfirst(@$value->name) !!}</td>
            <td>{!! ucfirst(@$value->sections->name) !!}</td>
            <td><span class="changeStatus" data-href="{{ route('topic.changeStatus', $value->id) }}" onclick="changeStatus('{{$value->id}}');">{!! ($value->is_active) ? __('training::topic.title.active') : __('training::topic.title.deactive') !!}</span></td>            
            <td>
                <a class="editPopupForm" href="javascript:;" data-href="{{ route('topic.edit', $value->id) }}" title="{{ __('training::topic.title.edit') }}" onclick="addEditPopupForm('{{$value->id}}');"><i class="fa fa-edit"></i></a>
                <a class="deleteRecord" href="javascript:;" data-href="{{ route('topic.destroy', $value->id) }}" title="{{ __('training::topic.title.delete') }}" onclick="deleteRecord('{{$value->id}}');"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" align="center">{{__('training::topic.title.record-not-found')}}</td>
        </tr>
        @endforelse
    </tbody>
</table>
@include('elements.pagination')