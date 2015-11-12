@extends('master')
@section('content')
    <div class="row margin-top-20">
        <div class="col-xs-6 col-xs-offset-3 text-center margin-top-20">
            <div class="card">
                <h1>New Group</h1>
                <form method="post" enctype="multipart/form-data" action="{{route('processGroup')}}">
                    {!! Form::token() !!}
                    <div class="form-group">
                        <label for="groupname">Group Name</label>
                        <input type="text" name="groupname" class="form-control" id="groupname" placeholder="Group Name">
                    </div>
                    <div class="placeholder">
                        Invite PlaceHolder
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