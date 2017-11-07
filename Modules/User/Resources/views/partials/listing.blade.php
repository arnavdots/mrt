
<table id="listingTable" class="table table-bordered">
    <thead>
        <tr>
            <th>@sortablelink('first_name', __('user::user.name'))</th>
            <th>@sortablelink('email', __('user::user.email'))</th>
            <th>@sortablelink('mobile', __('user::user.mobile'))</th>
            <th>{{ __('user::user.role') }}</th>
            <th>@sortablelink('is_active', __('user::user.status'))</th>
            <th>{{ __('user::user.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($results as $value)
        <tr id="RecordID_{{$value->id}}">
            <td>
                {!! $value->first_name !!}
                {!! $value->last_name !!}
            </td>
            <td>{!! $value->email !!}</td>
            <td>{!! $value->mobile !!}</td>
            <td>
                @forelse($value->roles as $role)
                    {!! $role->display_name !!} 
                @empty
                    
                @endforelse
            </td>
            <td>
                <span class="changeStatus" data-href="{{ route('users.changeStatus', $value->id) }}" onclick="changeStatus('{{$value->id}}');">{!! ($value->is_active) ? __('user::user.active') : __('user::user.deactive') !!}</span>
            </td>
            <td>
                <a class="editPopupForm" href="javascript:;" data-href="{{ route('users.edit', $value->id) }}" title="{{ __('user::user.edit') }}" onclick="addEditPopupForm('{{$value->id}}');"><i class="fa fa-edit"></i></a>
                <a class="deleteRecord" href="javascript:;" data-href="{{ route('users.destroy', $value->id) }} title="{{ __('user::user.delete') }}" onclick="deleteRecord('{{$value->id}}');"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">{{__('user::user.record_not_found')}}</td>
        </tr>
        @endforelse
    </tbody>
    
</table>

@include('elements.pagination')
