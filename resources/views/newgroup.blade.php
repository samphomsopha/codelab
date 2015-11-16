@extends('master')
@section('content')
    <div class="row margin-top-20">
        <div class="col-xs-12 text-center margin-top-20 col-md-6 col-md-offset-3">
            <div class="card">
                <h1>New Group</h1>
                <form method="post" enctype="multipart/form-data" action="{{route('processGroup')}}">
                    {!! Form::token() !!}
                    <div class="form-group">
                        <input type="text" name="groupname" class="form-control" id="groupname" placeholder="Group Name">
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