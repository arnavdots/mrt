
/**
 * ajax function for status-change 
 */
function changeStatus(RecordID) {

    console.log('RecordID:', RecordID);

    // start loader 
    $('#RecordID_' + RecordID).loading({
        message: '<img src="' + BASEURL + '/public/loading.gif" style="max-height: 100%;" alt="loader-img">'
    });

    //var tableModel = $('#listingTable').attr('table-model');
    //console.log('tableModel:', tableModel)

    alertify.confirm(
            'Status Change', // confirmbox title
            'Are you sure? you want to change this record status.', // message
            function () {
                // success 
                
                //var url = BASEURL + '/admin/status-change/' + tableModel + '/' + RecordID;
                var url = $('#RecordID_' + RecordID + ' span.changeStatus').attr('data-href');
                console.log('url:', url)
                
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function (response) {
                        console.log('response:', response);
                        if (response.status == 'success') {
                            alertify.success(response.message);

                            // change text & stop loader 
                            $('#RecordID_' + RecordID + ' span.changeStatus').text(response.text);
                            $('#RecordID_' + RecordID).loading('stop');
                        } else if (response.status == 'error') {
                            $('#RecordID_' + RecordID).loading('stop');
                            alertify.error(response.message);
                        } else {
                            $('#RecordID_' + RecordID).loading('stop');
                            alertify.error('Error in post, Please try again.');
                        }
                    }
                })
            },
            function () {
                // cancel 
                $('#RecordID_' + RecordID).loading('stop');
            }
    );
}

/**
 * ajax function for (soft) delete record
 */
function deleteRecord(RecordID) {

    //console.log('RecordID:', RecordID);

    // start loader 
    $('#RecordID_' + RecordID).loading({
        message: '<img src="' + BASEURL + '/public/loading.gif" style="max-height: 100%;" alt="loader-img">'
    });

    //var tableModel = $('#listingTable').attr('table-model');
    //console.log('tableModel:', tableModel)
    
    alertify.confirm(
            'Delete Confirmation', // confirmbox title
            'Are you sure? you want to delete this record.', // message
            function () {
                // success 
                
                //var url = BASEURL + '/admin/delete-record/' + tableModel + '/' + RecordID;
                var url = $('#RecordID_' + RecordID + ' a.deleteRecord').attr('data-href');
                console.log('url:', url)

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function (response) {
                        //console.log(response);
                        if (response.status == 'success') {
                            alertify.success(response.message);

                            // stop loader & hide row 
                            $('#RecordID_' + RecordID).loading('stop');
                            $('#RecordID_' + RecordID).addClass('hide');
                        } else if (response.status == 'error') {
                            $('#RecordID_' + RecordID).loading('stop');
                            alertify.error(response.message);
                        } else {
                            $('#RecordID_' + RecordID).loading('stop');
                            alertify.error('Error in post, Please try again.');
                        }
                    }
                });
            },
            function () {
                // cancel 
                $('#RecordID_' + RecordID).loading('stop');
            }
    );
}

// LIST SUBMODULES
function getListingSubmodulesData(activeSubmodule,appendDiv){
    
    $.ajax({
        url: activeSubmodule,
        beforeSend: function () {
            // start loader 
            $(appendDiv).html('');
//            $(appendDiv).loading({
//                message: '<div class="overlay-page"><div class="overlay-ldr"><img src="' + BASEURL + '/public/images/admin/loader.gif" alt=""></div></div>'
//            });
        },
        success: function (response) {
            $(appendDiv).html(response);
            //datePicker();
        }

    });
}

function getListing(activeText) {
    var appendDiv = $('.appent-data');
    $.ajax({
        url: activeText,
        beforeSend: function () {
            // start loader 
            appendDiv.html('');
        },
        success: function (response) {
            appendDiv.html(response);
            datePicker();
        }

    })
}

// daterangepicker
function datePicker() {
    $('.daterangeinput').daterangepicker({
        autoUpdateInput: true,
        startDate: moment().subtract(6, 'days'),
        endDate: moment(),
        maxDate: moment(),
        showDropdowns: true,
        opens: 'left',
        drops: 'down',
        locale: {
            cancelLabel: 'Clear',
            format: 'D MMMM, YYYY'
        },
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    });
}


$(document).ready(function () {
    $('.select2-single').select2();
    $('[data-toggle=confirmation]').confirmation({
        rootSelector: '[data-toggle=confirmation]',
        onConfirm: function (event, element) {
            element.closest('form').submit();
        }
    });

    // Daterange script
    datePicker();


});


