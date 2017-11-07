
<div class="">

    <div class="dataTables_info">
        Showing 
            @if ( $results->lastPage() == $results->currentPage() )
                {{ (($results->perPage() * ($results->currentPage()-1)) + 1) }}
            @elseif ( $results->currentPage() == 1)
                {{ $results->currentPage() }}
            @else
                {{ (($results->perPage() * ($results->currentPage()-1)) + 1) }}
            @endif
        to 
            @if ( $results->lastPage() == $results->currentPage() )
                {{ $results->total() }}
            @else
                {{ $results->perPage() * $results->currentPage() }}
            @endif
        of
            {{ $results->total() }}
        records
    </div>

    <div class="dataTables_paginate">
        {{ $results->render() }}
    </div>

</div>
