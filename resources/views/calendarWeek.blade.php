@extends('master')
@section('content')
    @include('profileheader')
    <div class="row card">
        <div class="col-xs-12 text-center">
            <a href="{{route('calendarWeekView', ['date' => $prevWeek->format('Y-m-d')])}}">Prev</a>
            <a href="{{route('calendarDayView', ['day' => $dt->format('Y-m-d')])}}" class="btn btn-default">Day</a>
            <a href="#" class="btn btn-default active">Week</a>
            <a href="/calendar/?st={{$dt->format('Y-m-d')}}" class="btn btn-default">Month</a>
            <a href="{{route('calendarWeekView', ['date' => $nextWeek->format('Y-m-d')])}}">Next</a>
        </div>
    </div>
    <div class="row card">
        <div class="col-xs-12 text-center weekCal">
            <h5>{{$dt->format('F')}}</h5>
            <div class="row">
                @foreach ($week as $wkday)
                    <div class="calHeader">
                        <a href="{{route('calendarDayView', ['day' => $wkday['dt']])}}">{{$wkday['dis']}}</a>
                    </div>
                @endforeach
            </div>
            <div class="row weekRow">
                @foreach ($week as $wkday)
                    <div class="calDay">
                        <div><a href="{{route('newCalendarEvent',['day' => $wkday['dt']])}}"><i class="fa fa-plus-circle"></i> Event</a></div>
                        @if (!empty($events[$wkday['dt']]))
                            @foreach($events[$wkday['dt']] as $event)
                                <div class="entry"><a href="{{route('chat', ['roomId' => $event['event']->get('chatRoom')->getObjectId()])}}">{{$event['event']->get('name')}}</a></div>
                            @endforeach
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop