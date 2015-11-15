<div class="row card">
    <div class="col-xs-12 text-center col-md-6 col-md-offset-3">
        <div class="row">
            <div class="col-xs-4">
                <div class="user-name">
                    {{$user->get('name')}}
                </div>
            </div>
            <div class="col-xs-4">
                <div class="profile-img">
                    <img src="/img/profile.png">
                </div>
            </div>
            <div class="col-xs-4"><a href="/logout">Logout</a></div>
        </div>
    </div>
</div>