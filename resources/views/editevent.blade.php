@extends('master')
@section('content')
    @include('navheader')
    <div class="row card card-b">
        <div class="col-xs-12 padding-zero">
            <div class="group-name">
                <i class="fa fa-comments-o"></i> {{$event->get('name')}}
                <span class="ft-right">+Invite</span>
            </div>
            <div class="share">
                Invite Code: <b>{{$event->get('inviteCode')}}</b>
            </div>
            <div class="share">
                Shared Docs(0) <a href="/{{route('upload', ['forid' => $event->getObjectId()])}}">+ Add Docs</a>
            </div>
        </div>
    </div>
@stop