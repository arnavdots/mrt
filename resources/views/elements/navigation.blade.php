<div class="menu">
    <ul>
        @php $menus = MrtHelpers::navigationMenus() @endphp        
        @if(Auth::guard('admin')->check())	
        @if($menus)
        @foreach($menus as $k=>$menu)
        <li>
            <a class="{{$menu->slug==Request::segment(2)?'active':''}}" href="{{url('admin/'.$menu->slug)}}">{{ HTML::image(asset("images/admin/".@$menu->icon), "") }}<span>{{$menu->name}}</span></a>
        </li>  
        @endforeach

        @endif
        @endif

    </ul>
</div>
<div class="user-sec-rt">
    @if(Auth::guard('admin')->check())
    @php $role = MrtHelpers::getRoleName() @endphp
    <div class="hdr-box1 dis-block clearfix">  
        {{ link_to_route('admin.logout', @trans('login.logout'), $parameters = [], $attributes = ['class'=>'login-btn' , "onclick"=>"event.preventDefault();document.getElementById('logout-form').submit();"])}}
        @if($role->name=='upper_management' || $role->name=='manager' || $role->name=='admin'  || $role->name=='ceo' )
        <a class="setting-btn" data-toggle="collapse" href="#stng-box">{{ HTML::image(asset("images/admin/setting-icon.png"), "") }}</a>
        <div id="stng-box" class="setting-nav collapse">
            <ul>
                @if($role->name=='admin')
                <li>{{ link_to_route('users','Users') }}</li>
                <li>{{ link_to_route('category','Categories') }}</li>

                <li>{{ link_to_route('permission', 'Permission')}}</li>
                <li>{{ link_to_route('branch','Branch') }}</li>
                @endif
                <li>{{ HTML::link('#','Profile') }}</li>
                <li>{{ HTML::link('#','Setting') }}</li>

            </ul>
        </div>
        @endif
    </div>
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

    <div class="hdr-box2 dis-block clearfix">
        <div class="dis-block user-info-top"> <strong>User:</strong> {{ MrtHelpers::concnate(Auth::guard('admin')->user()->first_name,Auth::guard('admin')->user()->last_name)}} </div>
        <div class="dis-block user-info-top"> <strong>Role:</strong> {{ucfirst(@$role->display_name)}} </div>
    </div>
    @else

    <div class="hdr-box1 dis-block clearfix"> 
        {{ link_to_route('admin.login', @trans('login.login_heading'), $parameters = [], $attributes = ['class'=>'login-btn'])}}
        <a class="setting-btn" href="#">{{ HTML::image(asset("images/admin/setting-icon.png"), "") }}</a> 
    </div>
    @endif
</div>

</div>
</header>
