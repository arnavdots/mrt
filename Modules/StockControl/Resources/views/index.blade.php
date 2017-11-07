@extends('layouts.backend')
@section('content')

<div id="append-stock-control-data">
</div>


<script>
    $(document).ready(function () {
     
        var activeSubmodule = $('.responsive-tabs-container ul li.active a').data('id');
        var appendDiv = '#append-stock-control-data';
        getListingSubmodulesData(activeSubmodule, appendDiv);
       
        $('.responsive-tabs-container ul li a').on('click', function () {
            getListingSubmodulesData($(this).data('id'),appendDiv);
        })
       
    });
    
</script>
@endsection
