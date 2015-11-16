@extends('master')
@section('content')
    <div class="row card">
        <div class="col-xs-12 text-center col-md-6 col-md-offset-3">
            <div class="row">
                <div class="col-xs-4">
                    <div class="user-name">
                        {{$user->get('name')}}
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="profile-img">
                        <img src="/img/profile.png">
                    </div>
                </div>
                <div class="col-xs-4"><a href="/logout">Logout</a></div>
            </div>
        </div>
    </div>
    <div class="row card">
        <div class="col-xs-12 text-center col-md-6 col-md-offset-3">
            <!-- Responsive calendar - START -->
            <div class="responsive-calendar">
                <div class="controls">
                    <a class="pull-left" data-go="prev"><div class="btn"><i class="icon-chevron-left"></i></div></a>
                    <h4><span data-head-year></span> <span data-head-month></span></h4>
                    <a class="pull-right" data-go="next"><div class="btn"><i class="icon-chevron-right"></i></div></a>
                </div><hr/>
                <div class="day-headers">
                    <div class="day header">Mon</div>
                    <div class="day header">Tue</div>
                    <div class="day header">Wed</div>
                    <div class="day header">Thu</div>
                    <div class="day header">Fri</div>
                    <div class="day header">Sat</div>
                    <div class="day header">Sun</div>
                </div>
                <div class="days" data-group="days">
                    <!-- the place where days will be generated -->
                </div>
            </div>
            <!-- Responsive calendar - END -->
        </div>
    </div>
@stop