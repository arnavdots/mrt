$(document).ready(function () {
    permissionForm();
})
/**
 * ajax function for create update user permissions
 */
function permissionForm() {
    $('#permissionForm').on('submit', function (e) {
        var formSelector = '#permissionForm';

        $.ajaxSetup({
            header: $('meta[name="_token"]').attr('content')
        })
        e.preventDefault(e);
        var url = $(formSelector).attr('action');
        var data = $(this).serialize();
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: 'json',
            beforeSend: function () {

                // start loader 
                $(formSelector).loading({
                    message: '<div class="overlay-page"><div class="overlay-ldr"><img src="' + BASEURL + '/public/images/admin/loader.gif" alt=""></div></div>'
                });
            },
            success: function (response) {
                $(formSelector).loading('stop');
                alertify.success(response.message);
                //var body = $("html, body");
                //body.stop().animate({scrollTop:0}, 1000, function() { 

                //	});

            },
            error: function (jqXhr, json, errorThrown) {// this are default for ajax errors 

                alertify.error(response.message);

                $(formSelector).loading('stop');
            }
        })
    });
}
/**
 * ajax function for create/update records
 */
function addEditForm() {

    var formSelector = '#addEditForm';   
    
    var url = $(formSelector).attr('action');
    console.log('url:', url);

    //var data = $(formSelector).serialize();
    //var data = new FormData($(formSelector).submit());
        
    $.ajax({
        //type: "POST",
        url: $(formSelector).attr('action'),
        //data: fd,
        //dataType: 'json',
        data: new FormData($(formSelector)[0]),
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        beforeSend: function () {

            $('.ajaxResponse').html('');
            // start loader 
            $(formSelector).loading({
                message: '<div class="overlay-page"><div class="overlay-ldr"><img src="' + BASEURL + '/public/images/admin/loader.gif" alt=""></div></div>'
            });
        },
        success: function (response) {
            var html = '<span style="color:green;">' + response.message + '</span>';
            $(formSelector).loading('stop');
            //$('.ajaxResponse').html(html);
            alertify.success(html);
            var page = 1;
            //console.log('page:', page)
            loadSearchTable("#recordSearch", '#listRecords', page, function () {
                $('.ajaxResponse').html('');
                $('.custom-popup1').modal('toggle');
                $('.custom-popup2').modal('toggle');
            });
        },
        error: function (jqXhr, json, errorThrown) {// this are default for ajax errors 
            var errors = jqXhr.responseJSON;
            console.log('errors:', errors);
            var html = '<span style="color:red;"><ul>';
            $.each(errors['errors'], function (index, value) {
                html += '<li>' + value + '</li>';
            });
            html += '</ul></span>';

            $('.ajaxResponse').html(html);

            $(formSelector).loading('stop');
        }
    })
}



$(document).on('submit','form.addEditForm',function(e){
    
    e.preventDefault();
  
    var formSelector =  this;
    var url = $(formSelector).attr('action');
     
    console.log('url:', url)

    //var data = $(formSelector).serialize();
    var data = new FormData($(formSelector)[0]);
    //console.log('data:', data)

    $.ajax({
        type: "POST",
        url: $(formSelector).attr('action'),
        data: data,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {

            $('.ajaxResponse').html('');

            // start loader 
            $(formSelector).loading({
                message: '<div class="overlay-page"><div class="overlay-ldr"><img src="' + BASEURL + '/public/images/admin/loader.gif" alt=""></div></div>'
            });
        },
        success: function (response) {

            console.log('response:', response);
            var html = '<span style="color:green;">' + response.message + '</span>';

            $(formSelector).loading('stop');

            //$('.ajaxResponse').html(html);
            alertify.success(html);

            var page = 1;

            //console.log('page:', page)
            loadSearchTable("#recordSearch", '#listRecords', page, function () {
                $('.ajaxResponse').html('');
                $('.custom-popup1').modal('toggle');
                $('.custom-popup2').modal('toggle');
            });

        },
        error: function (jqXhr, json, errorThrown) {// this are default for ajax errors 
            var errors = jqXhr.responseJSON;
            console.log('errors:', errors);

            var html = '<span style="color:red;"><ul>';
            $.each(errors['errors'], function (index, value) {
                html += '<li>' + value + '</li>';
            });
            html += '</ul></span>';

            $('.ajaxResponse').html(html);

            $(formSelector).loading('stop');
        }
    })
});

/**
 * ajax update popup form
 */
function addEditPopupForm(RecordID) {
    // start loader 
    $('body').loading({
        message: '<div class="overlay-page"><div class="overlay-ldr"><img src="' + BASEURL + '/public/images/admin/loader.gif" alt=""></div></div>'
    });
    var editButton = this;
    var url = '';
    if (RecordID != '') {
        url = $('#RecordID_' + RecordID + ' a.editPopupForm').attr('data-href');
    } else {
        url = $('#adddPopupForm').attr('data-href');
    }
    console.log('url:', url)

    $.ajax({
        type: "GET",
        url: url,
        dataType: 'HTML',
        success: function (response) {
            //console.log('response:', response);

            $('#addNewRecord').html(response);

            $('.custom-popup1').modal('toggle');
            $('.custom-popup2').modal('toggle');

            $('body').loading('stop');

            getSelectedCountry();

        },
        error: function (error) {
            // this are default for ajax errors 
            console.log('errors:', error);
            $('body').loading('stop');

            alertify.error('OOPs!! Something went wrong, Please try again.');
        }
    })
}