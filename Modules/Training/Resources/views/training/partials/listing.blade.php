<table id="listingTable" class="table table-bordered">
    <thead>
        <tr>
            <th>@sortablelink('created_at', __('training::training.title.date')) </th>
            <th>@sortablelink('sections.name', __('training::training.title.section')) </th>
            <th>@sortablelink('topics.name', __('training::training.title.topic')) </th>
            <th>@sortablelink('title', __('training::training.title.title')) </th>
            <th>@sortablelink('description', __('training::training.title.description')) </th>            
            <th>@sortablelink('is_active', __('training::training.title.status')) </th>            
            <th>{!! __('training::training.title.actions') !!}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($results as $value)
        <tr id="RecordID_{{$value->id}}">
            <td>{!! MrtHelpers::date_format(@$value->created_at) !!}</td>
            <td>{!! ucfirst(@$value->sections->name) !!}</td>
            <td>{!! ucfirst(@$value->topics->name) !!}</td>
            <td>{!! ucfirst(@$value->title) !!}</td>
            <td>{!! str_limit(@$value->description, 50) !!}</td>
            <td><span class="changeStatus" data-href="{{ route('training.changeStatus', $value->id) }}" onclick="changeStatus('{{$value->id}}');">{!! ($value->is_active) ? __('training::training.title.active') : __('training::training.title.deactive') !!}</span></td>            
            <td>
                <a class="editPopupForm" href="javascript:;" data-href="{{ route('training.edit', $value->id) }}" title="{{ __('training::training.title.edit') }}" onclick="addEditPopupForm('{{$value->id}}');"><i class="fa fa-edit"></i></a>
                <a class="deleteRecord" href="javascript:;" data-href="{{ route('training.destroy', $value->id) }}" title="{{ __('training::training.title.delete') }}" onclick="deleteRecord('{{$value->id}}');"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" align="center">{{__('training::training.title.record-not-found')}}</td>
        </tr>
        @endforelse
    </tbody>
</table>
@include('elements.pagination')