<table id="listingTable" table-model="Enquiry" class="table table-bordered">
    <thead>
        <tr>
            <th>@sortablelink('created_at', __('enquiry::enquiry.title.date')) </th>
            <th>@sortablelink('contact_name', __('enquiry::enquiry.title.customer'))</th>
            <th>{!! __('enquiry::enquiry.title.consultant')!!}</th>
            <th>@sortablelink('note', __('enquiry::enquiry.title.notes'))</th>
        </tr>
    </thead>
    <tbody>
        @forelse($results as $enquiry)
        <tr>
            <td>{!! MrtHelpers::date_format(@$enquiry->created_at) !!}</td>
            <td>{!! ucfirst(@$enquiry->contact_name) !!}</td>
            <td>{!! MrtHelpers::concnate(@$enquiry->users->first_name,@$enquiry->users->last_name) !!}</td>
            <td>{!! @$enquiry->note !!}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" align="center">{{__('enquiry::enquiry.title.record-not-found')}}</td>
        </tr>
        @endforelse
    </tbody>
</table>
@include('elements.pagination')