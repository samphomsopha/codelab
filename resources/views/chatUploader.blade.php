@extends('master')
@section('content')
    <div class="row card">
        <div class="col-xs-12 text-center col-md-6 col-md-offset-3">
            <div class="row">
                <div class="col-xs-2"><a href="/home"><i class="fa fa-chevron-left"></i></a></div>
                <div class="col-xs-8">
                    <h1 class="nav-title"><i class="fa fa-comments-o"></i> Mid Term</h1>
                </div>
                <div class="col-xs-2"><a href="/logout">Logout</a></div>
            </div>
        </div>
    </div>
    <div class="row card card-b">
        <form id="chatfrm" action="/chat/upload" class="mydropzone" method="post" enctype="multipart/form-data">
            {!! Form::token() !!}
            <input type="hidden" name="chat_id" value="{{$chatObj->getObjectId()}}"/>
            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-1">
                    <label for="message">Message</label>
                    <textarea name="message" class="form-control" id="message">{{$message}}</textarea>
                    <div id="uploadctn" class="dz-message needsclick">
                        Drop files here or click to upload.<br>
                    </div>
                    <label for="youtube">Youtube Video</label>
                    <input type="text" class="form-control" id="youtube" name="youtube" placeholder="Youtube URL">
                </div>
            </div>
            <div class="col-xs-2 col-xs-offset-9">
                <button class="btn send"><i class="fa fa-paper-plane"></i></button>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        var chat_id = "{{$chatObj->getObjectId()}}";
    </script>
@stop