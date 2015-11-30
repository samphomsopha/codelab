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
    <div class="row card">
        <div class="col-xs-12 text-center col-md-6 col-md-offset-3">
            <span class="ft-left"><a href="/calendar/?st={{$day}}"><i class="fa fa-chevron-left nav-left"></i> Month</span></a>
            <span class="ft-right"><a href="{{route('newCalendarEvent',['day' => $dt->format('Y-m-d')])}}"><i class="fa fa-plus-circle"></i> New Event</a></span>
            <h4>{{$dt->format('D M j')}}</h4>
        </div>
    </div>
    <div class="row card card-b min-height">
    @foreach($events as $evData)
        <div class="col-xs-12 padding-zero">
            <div class="group-name">
                @if ($user->getObjectId() == $evData['group']->get('user')->getObjectId())
                    <i class="fa fa-users"></i> <a href="{{route('editgroup', ['id' => $evData['group']->getObjectId()])}}">{{$evData['group']->get('name')}}</a>
                @else
                    <i class="fa fa-users"></i>{{$evData['group']->get('name')}}
                @endif
            </div>
            <div class="event-name">
                <i class="fa fa-comments-o"></i> <a href="{{route('chat', ['roomId' => $evData['event']->get('chatRoom')->getObjectId()])}}">{{$evData['event']->get('name')}}</a>
                @if ($user->getObjectId() == $evData['event']->get('user')->getObjectId())
                    <a href="{{route('editEvent', ['id' => $evData['event']->getObjectId()])}}">[edit]</a>
                @endif
            </div>
            <hr>
        </div>
    @endforeach
    </div>
    <script type="text/javascript">
        var showTime = "{{$dt->format('Y-m-d')}}";
    </script>
@stop