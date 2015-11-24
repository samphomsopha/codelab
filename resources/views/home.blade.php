@extends('master')
@section('content')
    @include('profileheader')
    @foreach($data as $dt)
    <div class="row card card-b">
        <div class="col-xs-12 padding-zero">
            <div class="group-name">
                <a href="{{route('groupView', ['id' => $dt['group']->getObjectId()])}}"><i class="fa fa-users"></i> {{$dt['group']->get('name')}}</a>
                <a href="{{route('chat', ['roomId' => $dt['chatRoom']->getObjectId()])}}"><span class="ft-right"></ap><i class="fa fa-comments-o"></i> {{$dt['event']->get('name')}}</span></a>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="message">
                <div class="row">
                    <div class="profile-img">
                        <a href="{{route('chat', ['roomId' => $dt['chatRoom']->getObjectId()])}}">
                            @if (!empty($dt['user']->get('image')))
                                <img src="{{$dt['user']->get('image')->getUrl()}}"/>
                            @else
                                <img src="/img/profile.png"/>
                            @endif
                            {{$dt['user']->get('name')}}
                        </a>
                    </div>
                    <div class="text">
                        <a href="{{route('chat', ['roomId' => $dt['chatRoom']->getObjectId()])}}">
                            <p>{{$dt['message']['msg']->get('message')}}</p>
                            @foreach($dt['message']['assets'] as $assetObj)
                                <img class="msgimg img-responsive" src="{{$assetObj->get('file')->getUrl()}}"/>
                            @endforeach
                            <span class="timestamp">{{$dt['message']['msg']->getCreatedAt()->setTimezone(new \DateTimeZone('America/Los_Angeles'))->format('D M d, h:i:s a')}}</span>
                        </a>
                    </div>
                </div>
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