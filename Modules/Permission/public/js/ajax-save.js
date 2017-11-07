$(document).ready(function(){
	permissionForm();
})
/**
 * ajax function for create update user permissions
 */
function permissionForm() {
    $('#permissionForm').on('submit',function(e) {
		alert("hi");
        var formSelector = '#permissionForm';

        $.ajaxSetup({
            header:$('meta[name="_token"]').attr('content')
        })
        e.preventDefault(e);
        var url = $(formSelector).attr('action');
        var data = $(this).serialize();
        $.ajax({
            type:"POST",
            url:url,
            data: data,
            dataType: 'json',
            beforeSend: function () {
                
                // start loader 
                $(formSelector).loading({
                    message: '<div class="overlay-page"><div class="overlay-ldr"><img src="'+BASEURL+'/public/images/admin/loader.gif" alt=""></div></div>'
                });
            },
            success: function(response){
				$(formSelector).loading('stop');
				alertify.success(response.message);
				//var body = $("html, body");
				//body.stop().animate({scrollTop:0}, 1000, function() { 
				   
			//	});
              
            },
            error: function(jqXhr, json, errorThrown){// this are default for ajax errors 
              
				alertify.error(response.message);
				
				$(formSelector).loading('stop');
            }
        })
    });
}