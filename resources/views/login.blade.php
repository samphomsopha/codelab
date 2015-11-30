@extends('master')
@section('content')
    <div class="row card">
        <div class="col-xs-12 text-center col-md-6 col-md-offset-3">
            <a href="/"><img src="/img/logo.png" class="img-responsive img-logo"/></a>
            <div class="card text-center">
                <p class="msg">{{@$msg}}</p>
                <ul id="tabs" class="nav nav-tabs" role="tablist">
                    <li role="presentation"@if (@$activeTab =="login") class="active"@endif><a href="#login" data-toggle="tab">Login</a></li>
                    <li role="presentation"@if (@$activeTab =="signup") class="active"@endif><a href="#signup" data-toggle="tab">Sign Up</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="login-form tab-pane fade @if (@$activeTab =="login")in active @endif" id="login">
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
                                <!--<p><a role="button" class="btn btn-primary btn-width-300" href="#">Login With Google</a></p>//-->
                                <p>Don't have an account? <a href="/register">Sign Up</a></p>
                            </div>
                        </form>
                    </div>

                    <div role="tabpanel" class="login-form tab-pane fade @if (@$activeTab =="signup")in active @endif" id="signup">
                        <h1>Sign Up</h1>
                        <form method="post" enctype="multipart/form-data" action="{{route('processRegister')}}">
                            {!! Form::token() !!}
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <input type="text" name="email" class="form-control" id="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary">Sign Up</button>
                            <div class="margin-top-20">
                                <p><a role="button" class="btn btn-primary btn-width-300" href="{{$fb_login_url}}">Sign up With Facebook</a></p>
                                <!--<p><a role="button" class="btn btn-primary btn-width-300" href="#">Sign up With Google</a></p>-->
                                <p>Already have an account? <a href="/login">Login</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop