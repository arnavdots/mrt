<div id="new-gallery-popup" class="modal fade custom-popup2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">  
            {{ Form::button( __('gallery::gallery.close'), ['type' => 'button', 'data-dismiss' => "modal", 'class'=>'close-btn']) }}
            <div class="pop-inr-box1 dis-block clearfix">                
                <!--ajax response div-->
                <div class="ajaxResponse"></div>                
                {{ Form::model($gallery, ['id' => 'addEditForm1', 'route' => $url, 'method' => 'post', 'files'=>true]) }}                
                {{ Form::hidden('id') }}                
                <div class="popup-form-box dis-block clearfix">
                    <div class="frm-wd-full cmn-popup-form">
                        <div class="form-group clearfix">                            
                            {!! Form::label(null,__('gallery::gallery.label.product-code')) !!}
                            <div class="field1">
                                {{ Form::text('product_code', null, ['placeholder' => __('gallery::gallery.placeholder.product-code'), 'class' => 'form-control']) }}
                                @if ($errors->has('product_code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('product_code') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group clearfix">                            
                            {!! Form::label(null, __('gallery::gallery.label.image')) !!}
                            <div class="field1">
                                {{ Form::file('image[]', ['multiple'=>true,'class' => 'form-control']) }}
                                @if ($errors->has('image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="dis-block text-right clearfix">
                            {{ Form::button(__('gallery::gallery.title.submit'), ['type' => 'submit', 'id' => 'submitForm', 'class'=>'btn cmn-btn green-btn margin-right5']) }}
                            {{ Form::button(__('gallery::gallery.title.cancel'), ['type' => 'cancel', 'id' => 'cancelForm', 'class'=>'btn cmn-btn red-btn', "data-dismiss"=>"modal"]) }}
                        </div>
                    </div>                    
                </div>
                {{ Form::close() }}                
            </div>
        </div>
    </div>
</div>

<script>           
    $('form#addEditForm1').submit(function (e) {
        e.preventDefault();
        var formSelector = this;
        var url = $(formSelector).attr('action');
        var formData = new FormData($(this)[0]);
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
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
                //console.log('page:', page);
                loadSearchTable("#recordSearch", '#listRecords', page, function () {
                    $('.ajaxResponse').html('');
                    $('.custom-popup1').modal('toggle');
                    $('.custom-popup2').modal('toggle');
                });
            },
            error: function (jqXhr, json, errorThrown) {    // this are default for ajax errors                 
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
        });
    });

</script>
