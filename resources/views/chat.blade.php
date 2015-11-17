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
    @foreach($messages as $messageObj)
        <div class="row card card-b">
            <div class="col-xs-12">
                <div class="message">
                    <div class="row">
                        <div class="profile-img">
                            <img src="/img/profile.png"/> {{$messageObj->get('user')->get('name')}}
                        </div>
                        <div class="text">
                            <p>{{$messageObj->get('message')}}</p>
                            <p class="timestamp">{{$messageObj->getCreatedAt()->setTimezone(new \DateTimeZone('America/Los_Angeles'))->format('D M d, h:i:s a')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
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
    <script type="text/javascript">
        var chat_id = "{{$chatObj->getObjectId()}}";
    </script>
@stop