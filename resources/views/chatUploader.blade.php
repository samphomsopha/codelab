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
        <form id="chat-frm" action="/file-upload" class="dropzone" method="post" enctype="multipart/form-data">
            {!! Form::token() !!}
            <div class="form-group">
                <div class="col-xs-11">
                    <textarea name="message" class="form-control" id="message">{{$message}}</textarea>
                    <input type="file" name="file" multiple/>
                </div>
                <div class="col-xs-1">
                    <button class="btn"><i class="fa fa-paper-plane"></i></button>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        var chat_id = "{{$chatObj->getObjectId()}}";
    </script>
@stop