
@php 
$consultants = MrtHelpers::getAllConsultants() 
@endphp
@php
$branches = MrtHelpers::getAllBranches() 
@endphp
@php
$status = MrtHelpers::getEnquiryStatus() 
@endphp

<!--search form start-->
<div class='searchForm'>
    @include('enquiry::partials.search')
</div>
<!--end search form -->
<!--listing table start-->
<div class="dashboard-box2 dis-block clearfix">
    <div class="table-responsive custom-table1">        
        <div id="listRecords">
            @include('enquiry::partials.listing')
        </div>        
    </div>
</div>
<!--end listing table-->


<!--Enquiry Popup-->
<div id="addNewRecord">
    @include('enquiry::create')
</div>

