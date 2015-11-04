<!DOCTYPE html>
<html lang="@yield('lang')">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    {!!@$metadata!!}
    {!!@$assetstop!!}
</head>
<body id="page-top" class="index">
<!-- Content -->
<div class="container">
    @yield('content')
</div>
{!!@$assets!!}
{!!@$inlinescript!!}
</body>
</html>