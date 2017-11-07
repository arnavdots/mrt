// get all states behalf on country id

function getSelectedCountry(){

    var country_id = $('#country option:selected').val();
    var form_id = $('.hidden-form-id').val();

    if (country_id) {
        $.ajax({
            url: 'get-states/' + country_id + '/' + form_id,

        }).done(function (data) {

            $("select[name='state_id'").html('');
            $("select[name='state_id'").html(data);
            var state_id = $('#states option:selected').val();

            if (state_id) {
                $.ajax({
                    url: 'get-cities/' + state_id + '/' + form_id,

                }).done(function (data) {
                    $("select[name='suburb_id'").html('');
                    $("select[name='suburb_id'").html(data);
                });
            }
        });
    }
}

// get all states of selected country
$(document).on('change', '#country', function (event){
    var country_id = $(this).val();

    if (country_id != '') {
        $.ajax({
            url: 'get-states/' + country_id,
        }).done(function (data) {

            $("select[name='state_id'").html('');
            $("select[name='state_id'").html(data);
            $("select[name='suburb_id'").html('<option value="">Select a suburb</option>');
        });
    } else {
        $("select[name='state_id'").html('<option value="">Select a state</option>');
        $("select[name='suburb_id'").html('<option value="">Select a suburb</option>');
    }
});

// get all cities behalf on state id
$(document).on('change', '#states', function (event){

    var state_id = $(this).val();

    if (state_id) {
        $.ajax({
            url: 'get-cities/' + state_id,

        }).done(function (data) {
            $("select[name='suburb_id'").html('');
            $("select[name='suburb_id'").html(data);
        });
    } else {
        $("select[name='suburb_id'").html('<option value="">Select a suburb</option>');
    }
});
