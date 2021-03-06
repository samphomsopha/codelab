@extends('master')
@section('content')
    @include('navheader')
    <div class="row card card-b">
        @if (!empty($errorMsg))
        <p class="error">{{$errorMsg}}</p>
        @endif
        <p class="Title">Please enter event code below.</p>
        <form method="post" enctype="multipart/form-data">
            {!! Form::token() !!}
            <div class="form-group">
                <input type="text" name="eventCode" class="form-control" id="eventCode" placeholder="Enter Event Code">
            </div>
            <div class="margin-top-20">
                <p>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </p>
            </div>
        </form>
    </div>
@stop