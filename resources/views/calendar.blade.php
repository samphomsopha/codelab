@extends('master')
@section('content')
    @include('profileheader')

    <div class="row card">
        <div class="col-xs-12 text-center col-md-6 col-md-offset-3">
            <!-- Responsive calendar - START -->
            <div class="responsive-calendar">
                <div class="controls">
                    <a class="pull-left" data-go="prev"><div class="btn btn-primary">Prev</div></a>
                    <h4><span data-head-year></span> <span data-head-month></span></h4>
                    <a class="pull-right" data-go="next"><div class="btn btn-primary">Next</div></a>
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
    <script type="text/javascript">
        var showTime = "{{$showdate->format('Y-m')}}";
    </script>
@stop