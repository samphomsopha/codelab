@extends('master')
@section('content')
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
    @foreach($data as $dt)
    <div class="row card card-b">
        <div class="col-xs-12 padding-zero">
            <div class="group-name">
                <a href="/group"><i class="fa fa-users"></i> {{$dt['group']->get('name')}}</a>
                <a href="/chat"><span class="ft-right"></ap><i class="fa fa-comments-o"></i> {{$dt['event']->get('name')}}</span></a>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="message">
                <a href="/chat">
                <div class="row">
                    <div class="profile-img">
                        <img src="/img/profile.png"/>
                        {{$dt['user']->get('name')}}
                    </div>
                    <div class="text">
                        <p>{{$dt['message']->get('message')}}</p>
                        <span class="timestamp">{{$dt['message']->getCreatedAt()->setTimezone(new \DateTimeZone('America/Los_Angeles'))->format('D M d, h:i:s a')}}</span>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
    @endforeach
    <div class="row">
        <div class="col-xs-12">
            <div class="spacer"></div>
        </div>
    </div>
@stop