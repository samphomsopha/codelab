@extends('master')
@section('content')
    <div class="row">
        <div class="col-xs-6 col-xs-offset-3 text-center margin-top-20">
            <div class="card">
                <div class="row">
                    <div class="col-xs-8">
                        <div class="profile-img">
                            <img src="/img/profile.png">
                        </div>
                        <div class="user-name">
                            {{$user->get('name')}}
                        </div>
                    </div>
                    <div class="col-xs-4"><a href="/logout">Logout</a></div>
                </div>
                <h1>Home Feed</h1>
            </div>
        </div>
    </div>
@stop