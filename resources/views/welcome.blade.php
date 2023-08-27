<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
       

        <!-- Styles -->
        
    </head>
    <body >
        @extends('layouts.menu')
        @section('content')
        <div id="app">
        <example-component></example-component>

        </div>
         @vite(['resources/sass/app.scss', 'resources/js/app.js']) 
        
        <script scr="{{asset('js/app.js')}}"></script>
        <script scr="{{asset('assets/js/main.js')}}"></script>

        @endsection
    </body>
</html>