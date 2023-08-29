
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
       
        <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <!-- Styles -->
        
    </head>
    <body >
        @extends('layouts.menu')
        @section('content')
        <div id="app">
        <gestiontoken-component></gestiontoken-component>


        <table class="table">
    <thead>
        <tr>
            <th>
                cedula
            </th>
            <th>
                token
            </th>
           
        </tr>
    </thead>
    <tbody >
        @foreach($users as $user)
    
       
        <tr>
            <td>{{ $user->cedula }}</td>
            <td>
                {{$usertokens[$user->id]}}
            </td>
            
           
            
           
        </tr>
@endforeach
    </tbody>
</table>
        </div>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        <script scr="{{asset('js/app.js')}}"></script>
        <script scr="{{asset('assets/js/main.js')}}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @endsection
    </body>
</html>