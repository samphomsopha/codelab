@extends('master')
@section('content')
    @include('navheader')
    <div class="row card card-b">
        <div class="col-xs-12 padding-zero">
            <div class="group-name">
                <i class="fa fa-comments-o"></i> {{$event->get('name')}}
                <span class="ft-right"><a href="{{route('eventDelete', ['id' => $event->getObjectId()])}}">Delete</a></span>
            </div>
            <div class="share">
                Invite Code: <b>{{$event->get('inviteCode')}}</b>
            </div>
            <!--<div class="share">
                Shared Docs(0) <a href="/{{route('upload', ['forid' => $event->getObjectId()])}}">+ Add Docs</a>
            </div> //-->
            <form method="post" action="{{route('newEvent',['gid' => $group->getObjectId()])}}" enctype="multipart/form-data">
                {!! Form::token() !!}
                <input type="hidden" name="id" value="{{$event->getObjectId()}}"/>
                <div class="form-group">
                    <input type="text" name="name" class="form-control" id="name" placeholder="Event Name" value="{{$event->get('name')}}">
                </div>
                <div class="form-group">
                    <input type="text" class="display-block" name="eventDate" id="eventDate" value="@if(!empty($event->get('date'))) {{$event->get('date')->format('m/d/Y')}} @endif" placeholder="Date">
                </div>
                <div class="placeholder">
                    <label for="groupname">Invite Your Friends</label>
                    <div class="friends"></div>
                    <input type="text" name="invite" class="form-control" id="invite" placeholder="Add Email">
                    <button class="btn btn-primary invite-btn">Add</button>
                </div>
                <div class="margin-top-20">
                    <p>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
@stop