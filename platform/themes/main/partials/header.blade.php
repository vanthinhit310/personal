<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=1" name="viewport" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fonts-->
        <title>Application</title>
        <link rel="icon" type="image/png" href="{{ Theme::asset()->url('img/favicon.png') }}"/>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,600;0,700;0,800;0,900;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <!-- CSS Library-->

        {!! Theme::header() !!}
    </head>

    <body @if (BaseHelper::siteLanguageDirection()=='rtl' ) dir="rtl" @endif class="hfull">
