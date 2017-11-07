
function registerSearchTable(formSelector, tableSelector, callback)
{
    $(document).on('input', formSelector, function () {
        loadSearchTable(formSelector, tableSelector, 1, callback);
    });

    $(document).on('change', formSelector, function () {
        loadSearchTable(formSelector, tableSelector, 1, callback);
    });

    $(document).on('click', '.paginate_button ', function (e) {
        e.preventDefault();
        //var page = $(this).data('page');
        var page = $(this).children().attr('data-dt-idx');
        //console.log('page:', page)
        loadSearchTable(formSelector, tableSelector, page, callback);
    });
}

function loadSearchTable(formSelector, tableSelector, page, callback)
{
    var url = $(formSelector).attr('action');

    var data = $(formSelector).serialize() + "&action=" + "search" + "&page=" + page;

    window.currentRequest = $.ajax({
        url: url,
        data: data,
        beforeSend: function () {
            if (window.currentRequest != null) {
                window.currentRequest.abort();
            }
            // start loader 
            $(tableSelector).loading({
                message: '<div class="overlay-page"><div class="overlay-ldr"><img src="' + BASEURL + '/public/images/admin/loader.gif" alt=""></div></div>'
            });
        },
        success: function (html) {


            $(tableSelector).html(html);

            $(tableSelector).loading('stop');

            callback();
        },
        error: function () {
            // SHOW MESSAGE

            $(tableSelector).loading('stop');

        },
        complete: function () {
            // Remove spinning icon

            $(tableSelector).loading('stop');
        },
        dataType: "HTML"
    });
}

$(document).ready(function () {
    registerSearchTable("#recordSearch", '#listRecords', function () {
    });
});

$(document).ready(function ()
{
    $(document).on('click', '.pagination a', function (event)
    {
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        event.preventDefault();
        var url = $(this).attr('href');
        var page = $(this).attr('href').split('page=')[1];

        getData(url, page);
    });

    // Sorting table columns on click   
    $(document).on('click', '#listingTable th a', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        getSortTableData(url);
    });

});

// Get sort table data
function getSortTableData(url) {
    var tableSelector = "#listingTable";
    $.ajax({
        url: url,
        beforeSend: function () {
            // start loader 
            $(tableSelector).loading({
                message: '<div class="overlay-page"><div class="overlay-ldr"><img src="' + BASEURL + '/public/images/admin/loader.gif" alt=""></div></div>'
            });
        },
    }).done(function (data) {
        $(tableSelector).loading('stop');
        $("#listRecords").empty().html(data);
    });
}



function getData(url, page) {

    var tableSelector = "#listingTable";
    var formSelector = "#recordSearch";

    // var url = window.location.href + '?page=' + page;
    var url = url;

    var data = $(formSelector).serialize() + "&action=" + "search" + "&page=" + page;
    $.ajax(
            {
                url: url,
                data: data,
                datatype: "HTML",
                beforeSend: function () {
                    // start loader 
                    $(tableSelector).loading({
                        message: '<div class="overlay-page"><div class="overlay-ldr"><img src="' + BASEURL + '/public/images/admin/loader.gif" alt=""></div></div>'
                    });
                },
            })
            .done(function (data)
            {
                //console.log('data:', data)
                $(tableSelector).loading('stop');

                $("#listRecords").empty().html(data);
            })
            .fail(function (jqXHR, ajaxOptions, thrownError)
            {
                $(tableSelector).loading('stop');
                alertify.error('OOPs!! Something went wrong, Please try again.');
            });
}