@extends('master')
@section('content')
    @include('navheader')
    <div class="row card card-b">
        <div class="col-xs-12 padding-zero">
            <div class="group-name">
                <i class="fa fa-users"></i> <a href="{{route('editgroup', ['id' => $group->getObjectId()])}}">{{$group->get('name')}}</a>
            </div>
            @foreach($events as $event)
                <div class="event-name">
                    <i class="fa fa-comments-o"></i> <a href="{{route('chat', ['roomId' => $event->get('chatRoom')->getObjectId()])}}">{{$event->get('name')}}</a>
                    @if (!empty($event->get('date')))
                        <span class="timestamp">{{$event->get('date')->format('m-d-Y')}}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@stop
