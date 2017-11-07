<table id="listingTable" class="table table-bordered">
    <thead>
        <tr>
            <th>@sortablelink('created_at', __('training::section.title.date')) </th>
            <th>@sortablelink('name', __('training::section.title.name')) </th>
            <th>@sortablelink('is_active', __('training::section.title.status')) </th>
            <th>{!! __('training::section.title.actions') !!}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($results as $value)
        <tr id="RecordID_{{$value->id}}">
            <td>{!! MrtHelpers::date_format(@$value->created_at) !!}</td>
            <td>{!! ucfirst(@$value->name) !!}</td>
            <td><span class="changeStatus" data-href="{{ route('section.changeStatus', $value->id) }}" onclick="changeStatus('{{$value->id}}');">{!! ($value->is_active) ? __('training::section.title.active') : __('training::section.title.deactive') !!}</span></td>
            <td>
                <a class="editPopupForm" href="javascript:;" data-href="{{ route('section.edit', $value->id) }}" title="{{ __('training::section.title.edit') }}" onclick="addEditPopupForm('{{$value->id}}');"><i class="fa fa-edit"></i></a>
                <a class="deleteRecord" href="javascript:;" data-href="{{ route('section.destroy', $value->id) }}" title="{{ __('training::section.title.delete') }}" onclick="deleteRecord('{{$value->id}}');"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" align="center">{{__('training::section.title.record-not-found')}}</td>
        </tr>
        @endforelse
    </tbody>
</table>
@include('elements.pagination')