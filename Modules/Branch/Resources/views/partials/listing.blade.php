
<table id="listingTable" class="table table-bordered">
    <thead>
        <tr>
            <th>@sortablelink('name', __('branch::branch.name'))</th>
            <th>@sortablelink('branch_code', __('branch::branch.branch_code'))</th>
            <th>@sortablelink('postcode', __('branch::branch.postcode'))</th>
            <th>@sortablelink('address_line_1', __('branch::branch.address_line_1'))</th>
            <th>@sortablelink('suburb.name', __('branch::branch.suburb'))</th>
            <th>@sortablelink('states.name', __('branch::branch.state'))</th>
            <th>@sortablelink('is_active', __('branch::branch.status'))</th>
            <th>{{ __('branch::branch.actions') }}</th>
        </tr>
    </thead>
    <tbody>
	
        @forelse($results as $value)
        <tr id="RecordID_{{$value->id}}">
            <td>{!! $value->name !!}</td>
            <td>{!! $value->branch_code !!}</td>
            <td>{!! $value->postcode !!}</td>
            <td>{!! $value->address_line_1 !!} {!! $value->address_line_2 !!}</td>
            <td>{!! $value['Suburb']->name !!} </td>
            <td>{!! $value['States']->name !!} </td>
            <td>
                <span class="changeStatus" data-href="{{ route('branch.changeStatus', $value->id) }}" onclick="changeStatus('{{$value->id}}');">{!! ($value->is_active) ? __('branch::branch.active') : __('branch::branch.deactive') !!}</span>
            </td>
            <td>
                <a class="editPopupForm" href="javascript:;" data-href="{{ route('branch.edit', $value->id) }}" title="{{ __('branch::branch.edit') }}" onclick="addEditPopupForm('{{$value->id}}');"><i class="fa fa-edit"></i></a>
                <a class="deleteRecord" href="javascript:;" data-href="{{ route('branch.destroy', $value->id) }}" title="{{ __('branch::branch.delete') }}" onclick="deleteRecord('{{$value->id}}');"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">{{__('branch::branch.record_not_found')}}</td>
        </tr>
        @endforelse
    </tbody>
    
</table>

@include('elements.pagination')
