@extends('master')
@section('content')
    @include('profileheader')
    @foreach ($dGroups as $groupData)
        <div class="row card card-b">
            <div class="col-xs-12 padding-zero">
                <div class="group-name">
                    <i class="fa fa-users"></i> <a href="{{route('editgroup', ['id' => $groupData['group']->getObjectId()])}}">{{$groupData['group']->get('name')}}</a>
                </div>
                @foreach($groupData['events'] as $event)
                    <div class="event-name">
                        <i class="fa fa-comments-o"></i> {{$event->get('name')}}
                        <span class="timestamp">11/23/2015</span>
                    </div>
                @endforeach
                <div class="event-name">
                    <span class="ft-right"><button class="btn btn-default"><a href="{{route('newEvent',['gid' => $groupData['group']->getObjectId()])}}">New Event</a></button></span>
                </div>
            </div>
        </div>
    @endforeach
    @if (empty($groups))
        <div class="row card card-b">
            <p class="title">Oops looks like you don't have any groups. Create one and invite your friends!</p>
            <button class="btn"><a href="{{route('newgroup')}}">Create A Group</a></button>
            <button class="btn"><a href="{{route('joingroup')}}">Join A Group</a></button>
        </div>
    @endif
@stop