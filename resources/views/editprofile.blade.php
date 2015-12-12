@extends('master')
@section('content')
    @include('profileheader')
    <div class="row card card-b">
        <form method="post" action="{{route('saveProfile')}}" id="profileForm" class="mydropzone" enctype="multipart/form-data" action="{{route('processGroup')}}">
        <div class="col-xs-12 profile">
                {!! Form::token() !!}
                <input type="hidden" name="assetId" value=""/>
                <input type="text" name="name" class="form-control name" id="name" value="{{$user->get('name')}}">
                <div class="img edit img-preview">
                    @if (!empty($user->get('image')))
                        <img id="origImg" class="dz-message needsclick" src="{{$user->get('image')->getUrl()}}">
                    @else
                        <img id="origImg" class="dz-message needsclick" src="/img/profile.png"/>
                    @endif
                </div>
        </div>
        <div class="col-xs-4 col-xs-offset-8">
            <input type="submit" class="btn btn-default btn-submit" value="Save"/>
        </div>
        </form>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="spacer"></div>
        </div>
    </div>
@stop