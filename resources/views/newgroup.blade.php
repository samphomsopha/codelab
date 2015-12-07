@extends('master')
@section('content')
    <div class="row margin-top-20">
        <div class="col-xs-12 margin-top-20 col-md-6 col-md-offset-3">
            <div class="card">
                <h1>New Group</h1>
                <form method="post" id="groupform" enctype="multipart/form-data" action="{{route('processGroup')}}">
                    {!! Form::token() !!}
                    <div class="form-group">
                        Public <input type="checkbox" name="public" value="y"/>
                        <input type="text" name="groupname" class="form-control" id="groupname" placeholder="Group Name">
                    </div>
                    <div class="placeholder">
                        <label for="groupname">Invite Your Friends</label>
                        <div class="friends"></div>
                        <div>
                        <input type="text" name="invite" class="form-control" id="invite" placeholder="Add Email">
                        </div>
                        <span class="ft-right"><button type="submit" class="btn btn-primary">Submit</button></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop