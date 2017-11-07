@extends('layouts.backend')
@section('content')

<div id="append-training-data"></div>

<script>
    $(document).ready(function () {
        var activeSubmodule = $('.responsive-tabs-container ul li.active a').data('id');
        var appendDiv = '#append-training-data';
        getListingSubmodulesData(activeSubmodule,appendDiv);

        $('.responsive-tabs-container ul li a').on('click', function () {
            getListingSubmodulesData($(this).data('id'),appendDiv);
        })
    });
    
</script>

@endsection
