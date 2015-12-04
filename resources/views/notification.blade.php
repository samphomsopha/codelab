@extends('master')
@section('content')
    @include('profileheader')
    @foreach ($notifications as $notify)
        <div class="row card card-b">
            <div class="notify">
                <div class="profile-img">
                @if (!empty($byimage))
                    <img src="{{$notify['byimage']->get('image')->getUrl()}}">
                @else
                    <img src="/img/profile.png">
                @endif
                </div>
                <b>{{$notify['notification']->get('by')->get('name')}}</b> sent a new message to <a href="{{route('chat', ['roomId' => $notify['chatRoom']->getObjectId()])}}">{{$notify['chatRoom']->get('name')}}</a>.
                <br />
                at {{$notify['notification']->get('message')->getCreatedAt()->setTimezone(new \DateTimeZone('America/Los_Angeles'))->format('D M d, h:i:s a')}}
                <div class="msg">
                    <a href="{{route('chat', ['roomId' => $notify['chatRoom']->getObjectId()])}}">"{{$notify['notification']->get('message')->get('message')}}"</a>
                    @foreach($notify['assets'] as $assetObj)
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
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="spacer"></div>
            </div>
        </div>
    @endforeach
@stop