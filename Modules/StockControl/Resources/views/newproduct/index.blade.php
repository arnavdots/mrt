<div class="tab-content">
    <div class="tab-pane active" id="tab1">
        <div class="stock-control-box dis-block clearfix padding40">
            <div class="tab-box full-wdth clearfix">
                <ul class="nav nav-tabs responsive-tabs form-tab">
                    <li class="active base-tab-button"><a  href="javascript:;" >{{__('stockcontrol::stockcontrol.base_form')}}</a></li>
                    <li class="bom-tab-button"><a href="javascript:;" >{{__('stockcontrol::stockcontrol.bom_form')}}</a></li>
                </ul>
                <div class="tab-content">
                    @include('stockcontrol::newproduct.create')
                </div>
            </div>
        </div>
    </div>
</div>
