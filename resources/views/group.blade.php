@extends('master')
@section('content')
    <div class="row card">
        <div class="col-xs-12 text-center col-md-6 col-md-offset-3">
            <div class="row">
                <div class="col-xs-2"><a href="/home"><i class="fa fa-chevron-left"></i></a></div>
                <div class="col-xs-8">
                    <h1 class="nav-title"><i class="fa fa-users"></i> Chem Class 101 Study Group</h1>
                </div>
                <div class="col-xs-2"><a href="/logout">Logout</a></div>
            </div>
        </div>
    </div>
    <div class="row card card-b">
        <div class="col-xs-12 padding-zero">
            <div class="group-name">
                <a href="/group"><i class="fa fa-users"></i> Chem Class 101 Study Group</a>
            </div>
            <div class="event-name">
                <a href="/chat">
                    <i class="fa fa-comments-o"></i> Mid Term
                    <span class="timestamp">5 minutes ago</span>
                </a>
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
            </div>
            <div class="event-name">
                <a href="/chat">
                    <i class="fa fa-comments-o"></i> Mid Term
                    <span class="timestamp">8 minutes ago</span>
                </a>
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
            </div>
            <div class="event-name">
                <a href="/chat">
                    <i class="fa fa-comments-o"></i> Final
                    <span class="timestamp">1 hour ago</span>
                </a>
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
                            <p>OMG finals will be so hard!!!</p>
                            <div class="video-container">
                                <iframe width="853" height="480" src="https://www.youtube.com/embed/4JFmQNuG7AY" frameborder="0" allowfullscreen></iframe>
                            </div>
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
            </div>
            <div class="event-name">
                <a href="/chat">
                    <i class="fa fa-comments-o"></i> Mid Term
                    <span class="timestamp">1 hour ago</span>
                </a>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="message">
                <a href="/chat">
                    <div class="row">
                        <div class="profile-img">
                            <img src="/img/profile.png"/>
                            Sam Phomsopha
                        </div>
                        <div class="text">
                            <p>Looking forward to meeting tonight!</p>
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