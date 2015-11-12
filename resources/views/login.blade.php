@extends('master')
@section('content')
    <div class="row margin-top-20">
        <div class="col-xs-6 col-xs-offset-3 text-center margin-top-20">
            <div class="card text-center">
                <div class="login-form">
                    <h1>Login</h1>
                    <form method="post" enctype="multipart/form-data" action="{{route('processLogin')}}">
                        {!! Form::token() !!}
                        <div class="form-group">
                            <input type="text" name="username" class="form-control" id="username" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                        <div class="margin-top-20">
                            <p><a role="button" class="btn btn-primary btn-width-300" href="{{$fb_login_url}}">Login With Facebook</a></p>
                            <p><a role="button" class="btn btn-primary btn-width-300" href="#">Login With Google</a></p>
                            <p>Don't have an account? <a href="/register">Sign Up</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop