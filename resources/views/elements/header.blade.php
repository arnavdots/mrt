<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Styles -->
        {{ Html::style('public/css/bootstrap.min.css') }}
		 <!-- select2 css -->
        {{ Html::style('public/plugins/select2/select2.min.css') }}
        {{ Html::style('public/plugins/select2/select2-bootstrap.css') }}
		
        {{ Html::style('public/css/font-awesome.min.css') }}
        {{ Html::style('public/css/admin/style.css') }}
        {{ Html::style('public/css/admin/responsive.css') }}
        
        <!-- Alertify css -->
        {{ Html::style('public/css/alertify/alertify.min.css') }}
        <!-- Alertify theme css -->
        {{ Html::style('public/css/alertify/themes/default.min.css') }}

        <!-- loaders css -->
        {{ Html::style('public/css/loader/jquery.loading.css') }}
        
        <!-- daterangepcker css -->
        {{ Html::style('public/plugins/daterange/daterangepicker.css') }}

        <!-- css for customization -->
        {{ Html::style('public/css/custom.css') }}
         {{ Html::script('public/js/jquery-3.2.1.min.js') }}
        <script>
            var BASEURL = "{{ url('/') }}";
        </script>
       
    </head>
<body>
<header class="header">
    <div class="hdr-inr dis-block clearfix">