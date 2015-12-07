<div class="row card">
    <div class="col-xs-4">
        <div class="user-name">
            {{$user->get('name')}}
        </div>
    </div>
    <div class="col-xs-4">
        <div class="profile-img">
            @if (!empty($user->get('image')))
                <img src="{{$user->get('image')->getUrl()}}">
            @else
                <img src="/img/profile.png"/>
            @endif
        </div>
    </div>
    <div class="col-xs-4">
        <a href="/logout">Logout</a>
        <div>
            <img class="logo" src="/img/logo.png"/>
        </div>
    </div>
</div>