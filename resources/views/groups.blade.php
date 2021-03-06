@extends('master')
@section('content')
    @include('profileheader')
    @foreach ($dGroups as $groupData)
        <div class="row card card-b">
            <div class="col-xs-12 padding-zero">
                <div class="group-name">
                    @if ($user->getObjectId() == $groupData['group']->get('user')->getObjectId() || $groupData['group']->get('public') == true)
                        <i class="fa fa-users"></i> <a href="{{route('editgroup', ['id' => $groupData['group']->getObjectId()])}}">{{$groupData['group']->get('name')}}</a>
                    @else
                        <i class="fa fa-users"></i>{{$groupData['group']->get('name')}}
                    @endif
                </div>
                @foreach($groupData['events'] as $event)
                    <div class="event-name">
                        <i class="fa fa-comments-o"></i> <a href="{{route('chat', ['roomId' => $event->get('chatRoom')->getObjectId()])}}">{{$event->get('name')}}</a>
                        @if ($user->getObjectId() == $event->get('user')->getObjectId())
                            <a href="{{route('editEvent', ['id' => $event->getObjectId()])}}">[edit]</a>
                        @endif
                        @if (!empty($event->get('date')))
                        <span class="timestamp">{{$event->get('date')->format('m-d-Y')}}</span>
                        @endif
                    </div>
                @endforeach
                @if ($user->getObjectId() == $groupData['group']->get('user')->getObjectId() || $groupData['group']->get('public') == true)
                <div class="event-name">
                    <span class="ft-right"><button class="btn btn-default"><a href="{{route('newEvent',['gid' => $groupData['group']->getObjectId()])}}">New Event</a></button></span>
                </div>
                @endif
            </div>
        </div>
    @endforeach
    @if (empty($dGroups))
        <div class="row card card-b">
            <p class="title">Oops looks like you don't have any groups. Create one and invite your friends!</p>
            <button class="btn"><a href="{{route('newgroup')}}">Create A Group</a></button>
            <button class="btn"><a href="{{route('joinGroup')}}">Join A Group</a></button>
        </div>
    @endif
    <div class="row">
        <div class="col-xs-12">
            <div class="spacer"></div>
        </div>
    </div>
@stop