@extends('master')
@section('content')
    <div class="row margin-top-20">
        <div class="col-xs-12">
            <div class="card text-center">
                <div class="login-form">
                    <h1>Sign Up</h1>
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="name" class="form-control" id="name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <input type="confirm-password" class="form-control" id="confirm-password" placeholder="Confirm Password">
                        </div>
                        <button type="submit" class="btn btn-primary">Sign Up</button>
                        <div class="margin-top-20">
                            <p><a role="button" class="btn btn-primary btn-width-300" href="{{$fb_login_url}}">Sign up With Facebook</a></p>
                            <p><a role="button" class="btn btn-primary btn-width-300" href="#">Sign up With Google</a></p>
                            <p>Already have an account? <a href="/login">Login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop