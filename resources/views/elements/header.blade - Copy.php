<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}" />
    
    <!-- Alertify css -->
    <link rel="stylesheet" href="{{ asset('css/alertify/alertify.min.css') }}" />
    <!-- Alertify theme css -->
    <link rel="stylesheet" href="{{ asset('css/alertify/themes/default.min.css') }}" />

    <!-- loaders css -->
    <link href="{{ asset('css/loader/jquery.loading.css') }}" rel="stylesheet">
    
    <!-- css for customization -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
   
    
</head>      

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        
        
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>{{ config('app.name', 'Laravel') }}</title>
<!-- Styles -->
{{ Html::style('css/bootstrap.min.css') }}
{{ Html::style('css/font-awesome.min.css') }}
{{ Html::style('css/style.css') }}
{{ Html::style('css/responsive.css') }}
{{ Html::script('js/jquery-2.2.3.min.js') }}
</head>

<body>
<header class="header">
  <div class="hdr-inr dis-block clearfix">