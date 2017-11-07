<div class="middle full-wdth clearfix">
  <div class="tab-box full-wdth clearfix">
  @php $sub_modules = MrtHelpers::getSubModules(Request::segment(2)?Request::segment(2):'') @endphp
  @php $fullUrl = Request::fullUrl() @endphp

    <ul class="nav nav-tabs responsive-tabs">
	@if($sub_modules)
	@foreach($sub_modules as $k=>$value)
            <li class="{{$k==0?'active':''}}">{{ HTML::link("#tab".$k,$value['name'],['data-id'=>$value['slug']])}} </li>
	@endforeach
	@else
	   
	   @endif
    </ul>
  </div>

