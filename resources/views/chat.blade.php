@extends('master')
@section('content')
    <div class="row card">
        <div class="col-xs-12 text-center col-md-6 col-md-offset-3">
            <div class="row">
                <div class="col-xs-2"><a href="/home"><i class="fa fa-chevron-left"></i></a></div>
                <div class="col-xs-8">
                    <h1 class="nav-title"><i class="fa fa-comments-o"></i> {{$chatObj->get('name')}}</h1>
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
                            @if (!empty($messageObj['message']->get('user')->get('image')))
                                <img src="{{$messageObj['message']->get('user')->get('image')->getUrl()}}"/>
                            @else
                                <img src="/img/profile.png"/>
                            @endif
                            {{$messageObj['message']->get('user')->get('name')}}
                        </div>
                        <div class="text">
                            <p>{{$messageObj['message']->get('message')}}</p>
                            @foreach($messageObj['assets'] as $assetObj)
                                @if (!empty($assetObj->get('youtube')))
                                    <div class="video-container">
                                        <iframe width="560" height="315" src="http://www.youtube.com/embed/{{$assetObj->get('youtube')}}?rel=0" frameborder="0" allowfullscreen></iframe>
                                    </div>
                                @elseif (in_array(substr($assetObj->get('file')->getUrl(),strrpos($assetObj->get('file')->getUrl(), '.')+1), ['jpg','jpeg','gif','png']))
                                    <img class="msgimg img-responsive" src="{{$assetObj->get('file')->getUrl()}}"/>
                                @else
                                    <a class="download-asset" href="{{$assetObj->get('file')->getUrl()}}"><i class="fa fa-download">{{substr($assetObj->get('file')->getName(),strrpos($assetObj->get('file')->getName(), '-')+1)}}</i></a>
                                @endif
                            @endforeach
                            @if($user->getObjectId() == $messageObj['message']->get('user')->getObjectId())
                                <p class="control"><button class="btn btn-delete-msg" data-id="{{$messageObj['message']->getObjectId()}}">delete</button></p>
                            @endif
                            <p class="timestamp">{{$messageObj['message']->getCreatedAt()->setTimezone(new \DateTimeZone('America/Los_Angeles'))->format('D M d, h:i:s a')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="row spacer">
        <div class="col-xs-12">
            <div class="spacer-chat"></div>
        </div>
    </div>
    <div class="row card card-b message-entry">
        <form id="chat-frm" method="post" enctype="multipart/form-data">
            {!! Form::token() !!}
            <div class="form-group">
                <div class="col-xs-11">
                    <textarea name="message" class="form-control" id="message"></textarea>
                </div>
                <div class="col-xs-1">
                    <button class="btn fupload"><i class="fa fa-picture-o"></i></button>
                    <button type="submit" class="btn"><i class="fa fa-paper-plane"></i></button>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        var chat_id = "{{$chatObj->getObjectId()}}";
        var last_timer = "{{$last_timer}}";
        var lastMsgId = "{{$lastMsgId}}";
        var PU = "{{$uId}}";
    </script>
@stop