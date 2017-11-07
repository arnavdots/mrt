<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>{{ config('app.name', 'MRT') }}</title>
        <!-- Styles -->
		 <!-- Bootstrap  -->
        {{ Html::style('public/css/bootstrap.min.css') }}
		 <!-- Font awesome -->
        {{ Html::style('public/css/font-awesome.min.css') }}
		 <!-- Custom style css -->
        {{ Html::style('public/css/admin/style.css') }}
        {{ Html::style('public/css/admin/responsive.css') }}
       
    </head>
<body>
