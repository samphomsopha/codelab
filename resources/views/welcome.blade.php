@extends('master')
@section('content')
<div class="row card">
    <div class="col-xs-2 col-xs-offset-9">
        <a href="/login">Login</a>
    </div>
</div>
<div class="row card">
    <div class="col-xs-12 text-center col-md-6 col-md-offset-3">
        <a href="/"><img src="/img/logo.png" class="img-responsive img-logo"/></a>
        <div class="card">
            <h3>Welcome</h3>
            <p><a role="button" href="/new-group" class="btn btn-primary btn-width-300">Create Group</a></p>
            <p><a role="button" href="/join-group" class="btn btn-primary btn-width-300">Join Group</a></p>
        </div>
    </div>
</div>
@stop