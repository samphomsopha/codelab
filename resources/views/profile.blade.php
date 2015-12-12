@extends('master')
@section('content')
    @include('profileheader')
        <div class="row card card-b">
            <a href="{{route('editProfile')}}">[Edit]</a>
            <div class="col-xs-12 profile">
                <h2>{{$user->get('name')}}</h2>
                <div class="img">
                    @if (!empty($user->get('image')))
                        <a href="{{route('editProfile')}}"><img src="{{$user->get('image')->getUrl()}}"></a>
                    @else
                        <a href="{{route('editProfile')}}"><img src="/img/profile.png"/></a>
                    @endif
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="spacer"></div>
        </div>
    </div>
@stop