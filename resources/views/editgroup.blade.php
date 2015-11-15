@extends('master')
@section('content')
    @include('profileheader')

    <div class="row card card-b">
        <div class="col-xs-12 padding-zero">
            <div class="group-name">
                <i class="fa fa-users"></i> {{$group->get('name')}}
                <span class="ft-right">+Invite</span>
            </div>
            <div class="share">
                Shared Docs(0) <a href="/{{route('upload', ['forid' => $group->getObjectId()])}}">+ Add Docs</a>
            </div>
        </div>
    </div>
@stop