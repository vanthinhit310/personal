<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=1" name="viewport" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="pusher_app_key" content="{{ theme_option('pusher_key','') }}">
        <meta name="pusher_app_cluster" content="{{ theme_option('pusher_cluster','') }}">
        <!-- Fonts-->
        <link href="https://fonts.googleapis.com/css?family={{ urlencode(theme_option('primary_font', 'Roboto')) }}" rel="stylesheet" type="text/css">
        <!-- CSS Library-->

        <style>
            :root {
                --color-1st: {
                        {
                        theme_option('primary_color', '#ff2b4a')
                    }
                }

                ;
                --primary-font: '{{ theme_option('primary_font', 'Roboto') }}',
                sans-serif;
            }
        </style>

        {!! Theme::header() !!}
    </head>

    <body @if (BaseHelper::siteLanguageDirection()=='rtl' ) dir="rtl" @endif>
