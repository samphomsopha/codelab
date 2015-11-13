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
    <div class="row card card-b">
        <div class="col-xs-12 padding-zero">
            <div class="group-name">
                <i class="fa fa-users"></i> Chem Class 101 Study Group
            </div>
            <div class="event-name">
                <i class="fa fa-comments-o"></i> Mid Terms
                <span class="timestamp">5 minutes ago</span>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="message">
                <div class="row">
                    <div class="profile-img">
                        <img src="/img/profiles/1.jpeg"/>
                        David P.
                    </div>
                    <div class="text">
                        <p>Hey guys thanks for coming to the study group tonight!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row card card-b">
        <div class="col-xs-12 padding-zero">
            <div class="group-name">
                <i class="fa fa-users"></i> Chem Class 101 Study Group
            </div>
            <div class="event-name">
                <i class="fa fa-comments-o"></i> Mid Terms
                <span class="timestamp">8 minutes ago</span>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="message">
                <div class="row">
                    <div class="profile-img">
                        <img src="/img/profiles/2.jpeg"/>
                        James Dean
                    </div>
                    <div class="text">
                        <p>Hey guys thanks for coming to the study group tonight!</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row card card-b">
        <div class="col-xs-12 padding-zero">
            <div class="group-name">
                <i class="fa fa-users"></i> Finance Class Study Group
            </div>
            <div class="event-name">
                <i class="fa fa-comments-o"></i> Finals
                <span class="timestamp">30 minutes ago</span>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="message">
                <div class="row">
                    <div class="profile-img">
                        <img src="/img/profiles/3.jpeg"/>
                        Susan A
                    </div>
                    <div class="text">
                        <p>What's the power of compound interest?</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop