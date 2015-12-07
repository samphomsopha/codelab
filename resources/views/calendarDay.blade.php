@extends('master')
@section('content')
    @include('profileheader')
    <div class="row card">
        <div class="col-xs-12 text-center">
            <div class="calBtn">
                <a href="#" class="btn btn-default active">Day</a>
                <a href="{{route('calendarWeekView', ['date' => $dt->format('Y-m-d')])}}" class="btn btn-default">Week</a>
                <a href="/calendar/?st={{$dt->format('Y-m-d')}}" class="btn btn-default">Month</a>
            </div>
        </div>
        <div class="col-xs-12 text-center">
            <span class="prevdate"><a href="{{route('calendarDayView', ['day' => $prevDt->format('Y-m-d')])}}">{{$prevDt->format('D d')}}</a></span>
            <span class="currdate">{{$dt->format('D M j')}}</span>
            <span class="nextdate"><a href="{{route('calendarDayView', ['day' => $nextDt->format('Y-m-d')])}}">{{$nextDt->format('D d')}}</a></span>
            <span class="ft-right"><a href="{{route('newCalendarEvent',['day' => $dt->format('Y-m-d')])}}"><i class="fa fa-plus-circle"></i> New Event</a></span>
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
    @if (empty($events))
        <div class="col-xs-12 padding-zero">
            <div class="group-name">
                No Events Today
            </div>
        </div>
    @endif
    </div>
    <script type="text/javascript">
        var showTime = "{{$dt->format('Y-m-d')}}";
    </script>
@stop