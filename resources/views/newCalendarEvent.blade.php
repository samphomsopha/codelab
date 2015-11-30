@extends('master')
@section('content')
    @include('navheader')
    <div class="row">
        <div class="col-xs-12 text-center col-md-6 col-md-offset-3">
            <div class="card">
                <h5>Select a Group</h5>
                <form method="post" enctype="multipart/form-data" id="selectGroup">
                    <div class="form-group">
                        <select name="groupId" id="groupId">
                            <option value="">Select Group</option>
                            @foreach($groups as $groupObj)
                                <option value="{{$groupObj->getObjectId()}}">{{$groupObj->get('name')}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                - Or -
                <h5>Create A New Group</h5>
                <form method="post" enctype="multipart/form-data" action="{{route('processGroup')}}">
                    {!! Form::token() !!}
                    <input type="hidden" name="reroute" value="newevents"/>
                    <div class="form-group">
                        <input type="text" name="groupname" class="form-control" id="groupname" placeholder="Group Name">
                    </div>
                    <div class="placeholder">
                        <label for="groupname">Invite Your Friends</label>
                        <div class="friends"></div>
                        <input type="text" name="invite" class="form-control" id="invite" placeholder="Add Email">
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
    <script type="text/javascript">
       var stDate = "{{$day}}";
    </script>
@stop