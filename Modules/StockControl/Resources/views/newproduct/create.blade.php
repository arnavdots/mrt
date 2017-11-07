<div class="ajaxResponse"></div>
<div class="tab-pane active" id="base">
    <!-- hide fields-->   
             <div class="copy-fields hide">
               <div class="form-group clearfix control-group">
                  {{ Form::label(null, __('stockcontrol::stockcontrol.component').' *') }}
                  <div class="field11">
                    {{ Form::text('bom_product_id[]', null, [ 'class' => 'form-control product_search', 'disabled', 'autocomplete' => 'off']) }}
                  </div>
                  <button type="button" class="remove-btn remove">Remove</button>
              </div>
              </div>
    
    
    @include('stockcontrol::newproduct.partials.product_form')
        
</div>


<script>
// show bom or base form
    $('ul.form-tab li').on('click', function () {

        $(".ajaxResponse").html('');

        var form_type = $(this).text();
        if (form_type == 'BOM') {
            $('#is_bom_value').val(1);
            $('.bom_element').removeClass('hide');
            $('.bom-tab-button').addClass('active');
            $('.base-tab-button').removeClass('active');
            $('.product_search').attr('disabled', false);
        } else {
            $('.base-tab-button').addClass('active');
            $('.bom-tab-button').removeClass('active');
            $('#is_bom_value').val(0);
            $('.bom_element').addClass('hide');
            $('.product_search').attr('disabled', true);
        }
    })
    
    productAutoSuggest();
    productImageSuggest();
</script>