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
                <a href="/group"><i class="fa fa-users"></i> Chem Class 101 Study Group</a>
                <a href="/chat"><span class="ft-right"></ap><i class="fa fa-comments-o"></i> Mid Term</span></a>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="message">
                <a href="/chat">
                <div class="row">
                    <div class="profile-img">
                        <img src="/img/profiles/1.jpeg"/>
                        David P.
                    </div>
                    <div class="text">
                        <p>Hey guys thanks for coming to the study group tonight!</p>
                        <span class="timestamp">5 minutes ago</span>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row card card-b">
        <div class="col-xs-12 padding-zero">
            <div class="group-name">
                <a href="/group"><i class="fa fa-users"></i> Chem Class 101 Study Group</a>
                <a href="/chat"><span class="ft-right"><i class="fa fa-comments-o"></i> Mid Term</span></a>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="message">
                <a href="/chat">
                <div class="row">
                    <div class="profile-img">
                        <img src="/img/profiles/2.jpeg"/>
                        James Dean
                    </div>
                    <div class="text">
                        <p>Hey guys thanks for coming to the study group tonight!</p>
                        <span class="timestamp">8 minutes ago</span>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row card card-b">
        <div class="col-xs-12 padding-zero">
            <div class="group-name">
                <i class="fa fa-users"></i> Finance Class Study Group
                <span class="ft-right"><i class="fa fa-comments-o"></i> Final</span>
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
                        <span class="timestamp">30 minutes ago</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row card card-b">
        <div class="col-xs-12 padding-zero">
            <div class="group-name">
                <a href="/group"><i class="fa fa-users"></i> Chem Class 101 Study Group</a>
                <a href="/chat"><span class="ft-right"><i class="fa fa-comments-o"></i> Final</span></a>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="message">
                <a href="/chat">
                    <div class="row">
                        <div class="profile-img">
                            <img src="/img/profiles/4.jpeg"/>
                            Sarah Day
                        </div>
                        <div class="text">
                            <p>OMG final will be so hard!!!</p>
                            <div class="video-container">
                            <iframe width="853" height="480" src="https://www.youtube.com/embed/4JFmQNuG7AY" frameborder="0" allowfullscreen></iframe>
                            </div>
                            <span class="timestamp">1 hour ago</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="spacer"></div>
        </div>
    </div>
@stop