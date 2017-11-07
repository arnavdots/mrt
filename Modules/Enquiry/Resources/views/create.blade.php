<!--Enquiry Popup-->
<div id="new-enq-popup" class="modal fade custom-popup1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            {!! Form::button(__('enquiry::enquiry.title.close'), ['type' => 'button', 'class'=>'close-btn', 'data-dismiss'=>'modal']) !!}
            <div class="pop-inr-box1 dis-block clearfix">                
                <div class="popup-form-box dis-block clearfix">
                    {{ Form::open(array('url' => 'enquiry/store', 'method' => 'post')) }}
                    <div class="frm-wd1 cmn-popup-form pull-left">
                        <div class="form-group clearfix">
                            {!! Form::label(__('enquiry::enquiry.label.customer-name')) !!}            
                            <div class="field1">
                                {{ Form::text('customer_name', null, ['class' => 'form-control']) }}
                                @if ($errors->has('customer_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('customer_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {!! Form::label(__('enquiry::enquiry.label.business-name')) !!}
                            <div class="field1">
                                {{ Form::text('business_name', null, ['class' => 'form-control']) }}
                                @if ($errors->has('business_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('business_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {!! Form::label(__('enquiry::enquiry.label.contact-ph')) !!}
                            <div class="field1">
                                {{ Form::text('contact_number', null, ['class' => 'form-control']) }}
                                @if ($errors->has('contact_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_number') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {!! Form::label(__('enquiry::enquiry.label.email-address')) !!}
                            <div class="field1">
                                {{ Form::text('contact_email', null, ['class' => 'form-control']) }}
                                @if ($errors->has('contact_email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {!! Form::label(__('enquiry::enquiry.label.enquired-how')) !!}
                            <div class="field2">
                                {{ Form::text('how_enquiry_was_taken', null, ['class' => 'form-control']) }}
                                @if ($errors->has('how_enquiry_was_taken'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('how_enquiry_was_taken') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="field3">
                                {!! Form::select('branch', ['1' => 'Tray/Canopy Combo'], null, ['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {!! Form::label(__('enquiry::enquiry.label.referral-type')) !!}
                            <div class="field1">
                                {!! Form::select('referral_type', ['1' => 'White Pages'], null, ['class'=>'form-control text-right']) !!}
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="field4">
                                {!! Form::select('branch1', ['wholesale' => 'Wholesale'], null, ['class'=>'form-control sltd1']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="frm-wd1 cmn-popup-form pull-left">
                        <div class="form-group clearfix">
                            {!! Form::label(__('enquiry::enquiry.label.branch')) !!}
                            <div class="field1">
                                {!! Form::select('branch', ['brisben' => 'Brisben', '2' => 'sydny'], null, ['placeholder' => 'Select a branch...','class'=>'form-control text-right']) !!}
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {!! Form::label(__('enquiry::enquiry.label.address')) !!}
                            <div class="field1">
                                {{ Form::textarea('contact_address', null, ['class' => 'form-control']) }}
                                @if ($errors->has('contact_address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_address') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {!! Form::label(__('enquiry::enquiry.label.suburb-postcode')) !!}
                            <div class="field1">
                                {{ Form::text('contact_postcode', "Miami, 4220", ['class' => 'form-control inpt1']) }}
                                @if ($errors->has('contact_postcode'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_postcode') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {!! Form::label(__('enquiry::enquiry.label.re-assign')) !!}
                            <div class="field5">
                                {!! Form::select('re_assign_to', ['1' => 'Lynley Guthrie', '2' => 'Small'], null, ['placeholder' => 'Pick a person...','class'=>'form-control text-right']) !!}
                            </div>                            
                            {{ Form::button(__('enquiry::enquiry.title.submit'), ['type' => 'submit','class'=>'arrow-btn']) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                    <div class="frm-wd2 cmn-popup-form pull-left">
                        <div class="dis-block clearfix btn-outer1">
                            <div class="cmn-btn-wd">                                
                                {{ Form::button(__('enquiry::enquiry.title.start-quote'), ['type' => 'submit','class'=>'btn cmn-btn green-btn']) }}
                            </div>
                            <div class="cmn-btn-wd">
                                {{ Form::button(__('enquiry::enquiry.title.start-order'), ['type' => 'submit','class'=>'btn cmn-btn green-btn']) }}
                            </div>
                        </div>
                        <div class="dis-block clearfix btn-outer1">
                            <div class="cmn-btn-wd">
                                {{ Form::button(__('enquiry::enquiry.title.add-new-note'), ['type' => 'submit','class'=>'btn cmn-btn grey-btn']) }}
                            </div>
                            <div class="cmn-btn-wd">
                                {{ Form::button(__('enquiry::enquiry.title.end-enquiry'), ['type' => 'submit','class'=>'btn cmn-btn red-btn']) }}
                            </div>
                        </div>
                        <div class="dis-block clearfix btn-outer1">
                            <div class="cmn-btn-wd">
                                {{ Form::button(__('enquiry::enquiry.title.send-mail'), ['type' => 'submit','class'=>'btn cmn-btn grey-btn']) }}
                            </div>
                            <div class="cmn-btn-wd">
                                {{ Form::button(__('enquiry::enquiry.title.email-history'), ['type' => 'submit','class'=>'btn cmn-btn grey-btn']) }}
                            </div>
                        </div>
                    </div>
                </div>                
                <div class="table-responsive custom-table2">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{!! __('enquiry::enquiry.title.date') !!}</th>
                                <th>{!! __('enquiry::enquiry.title.consultant') !!}</th>
                                <th>{!! __('enquiry::enquiry.title.actions') !!}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>