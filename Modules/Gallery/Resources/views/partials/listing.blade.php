<table id="listingTable" class="table table-bordered">
    <thead>
        <tr>
            <th>@sortablelink('created_at', __('gallery::gallery.title.date')) </th>
            <th>@sortablelink('product_code', __('gallery::gallery.title.product-code')) </th>
            <th>@sortablelink('image', __('gallery::gallery.title.image')) </th>
            <th>@sortablelink('is_active', __('gallery::gallery.title.status')) </th>
            <th>{!! __('gallery::gallery.title.actions') !!}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($results as $value)
        <tr id="RecordID_{{$value->id}}">
            <td>{!! MrtHelpers::date_format(@$value->created_at) !!}</td>
            <td>{!! ucfirst(@$value->product_code) !!}</td>
            <td>{!! HTML::image(asset("uploads/gallaries/".$value->product_code."/".@$value->image), "",['style'=>'width:50px;height:50px !important']) !!}</td>
            <td><span class="changeStatus" data-href="{{ route('gallery.changeStatus', $value->id) }}" onclick="changeStatus('{{$value->id}}');">{!! ($value->is_active) ? __('training::section.title.active') : __('training::section.title.deactive') !!}</span></td>
            <td>                
                <a class="deleteRecord" href="javascript:;" data-href="{{ route('gallery.destroy', $value->id) }}" title="{{ __('gallery::gallery.title.delete') }}" onclick="deleteRecord('{{$value->id}}');"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" align="center">{{__('gallery::gallery.title.record-not-found')}}</td>
        </tr>
        @endforelse
    </tbody>
</table>
@include('elements.pagination')
