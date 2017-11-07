






// add more product fields
//$(document).on('click', '.image-search-tag', function () {
//    productImageSuggest();
//});


$('.image-search-tag').on('beforeItemAdd', function (event) {
    var tag = event.item;
    // Do some processing here

    alert('good job')

//        if (!event.options || !event.options.preventPost) {
//            $.ajax('/ajax-url', ajaxData, function (response) {
//                if (response.failure) {
//                    // Remove the tag since there was a failure
//                    // "preventPost" here will stop this ajax call from running when the tag is removed
//                    $('#tags-input').tagsinput('remove', tag, {preventPost: true});
//                }
//            });
//        }
});

// add more product fields
$(document).on('click', '.add-more', function () {
    var html = $(".copy-fields").html();
    $(".after-add-more").after(html);
    productAutoSuggest();
});

//here it will remove the current value of the remove button which has been pressed
$("body").on("click", ".remove", function () {
    $(this).parents(".control-group").remove();
});



// product search by auto suggetion
function productImageSuggest() {

    $('.image-search-tag').typeahead({
        source: function (query, result) {
            $.ajax({
                url: "new_product/productsearch",
                data: 'query=' + query,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                type: "POST",
                success: function (data) {
                    console.log('data:', data);


                }
            });
        }
    });
}

/**
 * ajax function for create/update product 
 */
function addEditProductForm(is_completed) {

    var formSelector = '#addEditProductForm';

    var url = $(formSelector).attr('action');
    console.log('url:', url)

    var data = $(formSelector).serialize();
    console.log(data);

    data += '&is_completed=' + is_completed;

    $.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: 'json',
        beforeSend: function () {
            $(".ajaxResponse").html('');
            // start loader 
            $(formSelector).loading({
                message: '<div class="overlay-page"><div class="overlay-ldr"><img src="' + BASEURL + '/public/images/admin/loader.gif" alt=""></div></div>'
            });

        },
        success: function (response) {

            console.log('response:', response);
            var html = '<span style="color:green;">' + response.message + '</span>';

            $(formSelector).loading('stop');

            //here it will remove the current value of the remove button which has been pressed
            $("span.bom-product-input-boxs .remove").parents(".control-group").remove();

            alertify.success(html);
            $('#addEditProductForm')[0].reset();


        },
        error: function (jqXhr, json, errorThrown) {// this are default for ajax errors 
            var errors = jqXhr.responseJSON;
            console.log('errors:', errors);

            var html = '<span style="color:red;"><ul>';
            $.each(errors['errors'], function (index, value) {
                html += '<li>' + value + '</li>';
                return false;
            });
            html += '</ul></span>';

            $('.ajaxResponse').html(html);

            $(formSelector).loading('stop');
        }
    })
}

// product search by auto suggetion
function productAutoSuggest() {

    $('.product_search').typeahead({
        source: function (query, result) {
            $.ajax({
                url: "new_product/productsearch",
                data: 'query=' + query,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                type: "POST",
                success: function (data) {
                    console.log(data);
                    result($.map(data, function (item) {
                        return item;
                    }));
                }
            });
        }
    });
}



