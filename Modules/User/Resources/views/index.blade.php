@extends('layouts.backend')

@section('content')
            
<!--search form start-->
<div class='searchForm'>
    @include('user::partials.search')
</div>
<!--end search form -->

<!--listing table start-->
<div class="dashboard-box2 dis-block clearfix">
    <div class="table-responsive custom-table1">
        
        <div id="listRecords" class=''>
            @include('user::partials.listing')
        </div>
        
    </div>
</div>
<!--end listing table-->

@stop