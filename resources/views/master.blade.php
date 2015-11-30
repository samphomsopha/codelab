<!DOCTYPE html>
<html lang="@yield('lang')">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>@yield('title')</title>
    {!!@$metadata!!}
    {!!@$assetstop!!}
</head>
<body id="page-top" class="index">
<!-- Content -->
<div class="container content">
    @yield('content')
</div>

<nav class="navbar navbar-default navbar-fixed-bottom nav-bottom">
    <ul class="nav nav-pills">
        <li role="presentation"@if (@$activeBarTab =="dashboard") class="active"@endif>
            <a href="/home">
                <div class="nav-icon"><i class="fa fa-newspaper-o"></i></span></div>
                <div class="nav-link">Dashboard</div>
            </a>
        </li>
        <li role="presentation"@if (@$activeBarTab =="calendar") class="active"@endif>
            <a href="/calendar">
                <div class="nav-icon"><i class="fa fa-calendar"></i></div>
                <div class="nav-link">Calendar</div>
            </a>
        </li>
        <li role="presentation"@if (@$activeBarTab =="groups") class="active"@endif>
            <a href="/groups">
                <div class="nav-icon"><i class="fa fa-users"></i></div>
                <div class="nav-link">Groups</div>
            </a>
        </li>
        <li role="presentation" class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="nav-icon"><i class="fa fa-bars"></i></span></div>
                <div class="nav-link">
                    More <span class="caret"></span>
                </div>
            </a>
            <ul class="dropdown-menu">
                <li><a href="{{route('newCalendarEvent',['day' => 'now'])}}">Add Event</a></li>
                <li><a href="{{route('joinEvent')}}">Join Event</a></li>
                <li><a href="{{route('newgroup')}}">New Group</a></li>
                <li><a href="{{route('joinGroup')}}">Join Group</a></li>
            </ul>
        </li>
    </ul>
</nav>
{!!@$assets!!}
{!!@$inlinescript!!}
</body>
</html>