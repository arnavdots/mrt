
<table id="listingTable" class="table table-bordered">
    <thead>
        <tr>
            <th>@sortablelink('name', __('category::category.name'))</th>
            <th>@sortablelink('is_active', __('category::category.status'))</th>
            <th>{{ __('category::category.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($results as $value)
        <tr id="RecordID_{{$value->id}}">
            <td>{!! $value->name !!}</td>
            <td>
                <span class="changeStatus" data-href="{{ route('category.changeStatus', $value->id) }}" onclick="changeStatus('{{$value->id}}');">{!! ($value->is_active) ? __('category::category.active') : __('category::category.deactive') !!}</span>
            </td>
            <td>
                <a class="editPopupForm" href="javascript:;" data-href="{{ route('category.edit', $value->id) }}" title="{{ __('category::category.edit') }}" onclick="addEditPopupForm('{{$value->id}}');"><i class="fa fa-edit"></i></a>
                <a class="deleteRecord" href="javascript:;" data-href="{{ route('category.destroy', $value->id) }} "title="{{ __('user::user.delete') }}" onclick="deleteRecord('{{$value->id}}');"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">{{__('category::category.record_not_found')}}</td>
        </tr>
        @endforelse
    </tbody>
    
</table>

@include('elements.pagination')
