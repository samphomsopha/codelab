@extends('master')
@section('content')
    <div class="row margin-top-20">
        <div class="col-xs-12">
            <div class="card text-center">
                <div class="login-form">
                    <h1>Login</h1>
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
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