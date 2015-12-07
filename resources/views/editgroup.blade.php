@extends('master')
@section('content')
    @include('profileheader')

    <div class="row card card-b">
        <div class="col-xs-12 padding-zero">
            <div class="group-name">
                <i class="fa fa-users"></i> {{$group->get('name')}}
                <span class="ft-right"><a href="{{route('groupDelete', ['id' => $group->getObjectId()])}}">Delete</a></span>
            </div>
            @if ($user->getObjectId() == $group->get('user')->getObjectId() || $group->get('public') == true)
            <div class="share">
                Invite Code: <b>{{$group->get('inviteCode')}}</b>
            </div>
            <!--<div class="share">
                Shared Docs(0) <a href="/{{route('upload', ['forid' => $group->getObjectId()])}}">+ Add Docs</a>
            </div>//-->
            <form method="post" id="groupform" enctype="multipart/form-data" action="{{route('processGroup')}}">
                {!! Form::token() !!}
                <input type="hidden" name="id" value="{{$group->getObjectId()}}"/>
                <div class="form-group">
                    Public <input type="checkbox" name="public" value="y"@if ($group->get('public')) checked @endif/>
                    <input type="text" name="groupname" class="form-control" id="groupname" value="{{$group->get('name')}}">
                </div>
                <div class="placeholder">
                    <label for="groupname">Invite Your Friends</label>
                    <div class="friends">
                        @foreach ($group->get('invites') as $invite)
                            <div class="invite-contain">
                                <input type="hidden" name="invites[]" value="{{$invite}}"/>
                                <div class="invite">{{$invite}}</div><i class="fa fa-times-circle x-out"></i>
                            </div>
                        @endforeach
                    </div>
                    <div>
                        <input type="text" name="invite" class="form-control" id="invite" placeholder="Add Email">
                    </div>
                </div>
                <div class="placeholder">
                    <label>Group Members</label>
                    <div class="members">
                    @foreach($members as $member)
                        <div class="invite-contain">
                            <div class="invite">{{$member->get('email')}}</div><i class="fa fa-times-circle x-out"></i>
                        </div>
                    @endforeach
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="margin-top-20">
                    <span class="ft-right"><button type="submit" class="btn btn-primary">Save</button></span>
                </div>
            </form>
            @else
                <h4>Sorry, you don't have permission to edit this group.</h4>
            @endif
        </div>
    </div>
    <div class="row spacer">
        <div class="col-xs-12">
            <div class="spacer-chat"></div>
        </div>
    </div>
@stop