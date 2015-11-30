@extends('master')
@section('content')
    @include('navheader')
    <div class="row">
        <div class="col-xs-12 text-center col-md-6 col-md-offset-3">
            <div class="card">
                <p class="title">Add Event</p>
                <form method="post" enctype="multipart/form-data">
                    {!! Form::token() !!}
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Event Name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="display-block" name="eventDate" id="eventDate" @if(!empty($st))value="{{$st}}"@endif placeholder="Date">
                    </div>
                    <div class="placeholder">
                        <label for="groupname">Invite Your Friends</label>
                        <div class="friends"></div>
                        <input type="text" name="invite" class="form-control" id="invite" placeholder="Add Email">
                        <button class="btn btn-primary invite-btn">Add</button>
                    </div>
                    <div class="margin-top-20">
                        <p>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop