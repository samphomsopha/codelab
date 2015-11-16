@extends('master')
@section('content')
    <div class="row card">
        <div class="col-xs-12 text-center col-md-6 col-md-offset-3">
            <div class="row">
                <div class="col-xs-2"><a href="/home"><i class="fa fa-chevron-left"></i></a></div>
                <div class="col-xs-8">
                    <h1 class="nav-title"><i class="fa fa-comments-o"></i> Mid Term</h1>
                </div>
                <div class="col-xs-2"><a href="/logout">Logout</a></div>
            </div>
        </div>
    </div>
    <div class="row card card-b">
        <div class="col-xs-12">
            <div class="message">
                <div class="row">
                    <div class="profile-img">
                        <img src="/img/profiles/1.jpeg"/>
                        David P.
                    </div>
                    <div class="text">
                        <p>Hey guys thanks for coming to the study group tonight!</p>
                        <p class="timestamp">5 minutes ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row card card-b">
        <div class="col-xs-12">
            <div class="message">
                <div class="row">
                    <div class="profile-img">
                        <img src="/img/profiles/2.jpeg"/>
                        James Dean
                    </div>
                    <div class="text">
                        <p>Hey guys thanks for coming to the study group tonight!</p>
                        <p class="timestamp">8 minutes ago</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row card card-b self">
        <div class="col-xs-12">
            <div class="message">
                <div class="row">
                    <div class="profile-img">
                        <img src="/img/profile.png"/>
                        Sam Phomsopha
                    </div>
                    <div class="text">
                        <p>Looking forward to meeting tonight!</p>
                        <p class="timestamp">1 hour ago</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row card card-b">
        <div class="col-xs-12">
            <div class="message">
                <div class="row">
                    <div class="profile-img">
                        <img src="/img/profiles/7.jpeg"/>
                        Mark
                    </div>
                    <div class="text">
                        <p>Meeting is set for 9pm @SBUX</p>
                        <p class="timestamp">10 hour ago</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row card card-b self">
        <div class="col-xs-12">
            <div class="message">
                <div class="row">
                    <div class="profile-img">
                        <img src="/img/profile.png"/>
                        Sam Phomsopha
                    </div>
                    <div class="text">
                        <p>Looking forward to meeting tonight!</p>
                        <p class="timestamp">1 hour ago</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row card card-b">
        <div class="col-xs-12">
            <div class="message">
                <div class="row">
                    <div class="profile-img">
                        <img src="/img/profiles/7.jpeg"/>
                        Mark
                    </div>
                    <div class="text">
                        <p>Meeting is set for 9pm @SBUX</p>
                        <p class="timestamp">10 hour ago</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row card card-b self">
        <div class="col-xs-12">
            <div class="message">
                <div class="row">
                    <div class="profile-img">
                        <img src="/img/profile.png"/>
                        Sam Phomsopha
                    </div>
                    <div class="text">
                        <p>Looking forward to meeting tonight!</p>
                        <p class="timestamp">1 hour ago</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row card card-b">
        <div class="col-xs-12">
            <div class="message">
                <div class="row">
                    <div class="profile-img">
                        <img src="/img/profiles/7.jpeg"/>
                        Mark
                    </div>
                    <div class="text">
                        <p>Meeting is set for 9pm @SBUX</p>
                        <p class="timestamp">10 hour ago</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row card card-b self">
        <div class="col-xs-12">
            <div class="message">
                <div class="row">
                    <div class="profile-img">
                        <img src="/img/profile.png"/>
                        Sam Phomsopha
                    </div>
                    <div class="text">
                        <p>Looking forward to meeting tonight!</p>
                        <p class="timestamp">1 hour ago</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row card card-b">
        <div class="col-xs-12">
            <div class="message">
                <div class="row">
                    <div class="profile-img">
                        <img src="/img/profiles/7.jpeg"/>
                        Mark
                    </div>
                    <div class="text">
                        <p>Meeting is set for 9pm @SBUX</p>
                        <p class="timestamp">10 hour ago</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="spacer-chat"></div>
        </div>
    </div>
    <div class="row card card-b message-entry">
        <div class="col-xs-12">
                <form method="post" enctype="multipart/form-data">
                    {!! Form::token() !!}
                    <div class="form-group">
                        <input type="text" name="message" class="form-control" id="name" placeholder="Type message">
                    </div>
                </form>
        </div>
    </div>
@stop