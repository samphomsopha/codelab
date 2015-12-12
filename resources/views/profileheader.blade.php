<div class="row card">
    <div class="col-xs-4">
        <div class="user-name">
            {{$user->get('name')}}
        </div>
    </div>
    <div class="col-xs-4">
        <div class="profile-img">
            @if (!empty($user->get('image')))
                <a href="{{route('profile')}}"><img src="{{$user->get('image')->getUrl()}}"></a>
            @else
                <a href="{{route('profile')}}"><img src="/img/profile.png"/></a>
            @endif
        </div>
    </div>
    <div class="col-xs-4">
        <div>
            <img class="logo" src="/img/logo.png"/>
        </div>
    </div>
</div>