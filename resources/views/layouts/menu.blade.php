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
    <header>
        <nav class="navbar navbar-expand-sm navbar-toggleable-sm navbar-light bg-dark border-bottom box-shadow mb-3">
            <div class="container-fluid">
                <a class="navbar-brand text-light"  asp-area="" asp-controller="Home" asp-action="Index">ProyectoF2</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".navbar-collapse" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse d-sm-inline-flex justify-content-between">
                    <ul class="navbar-nav flex-grow-1">
                        <li class="nav-item">
                            <a class="nav-link text-light" asp-area="" asp-controller="Home" asp-action="Index">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" asp-area="" asp-controller="Home" asp-action="Privacy">Privacy</a>
                        </li>
                        
                        @if(auth()->user()->IdRol === 1)
                        <li class="nav-item" >
                                <a class="btn btn-outline-info" href="/gestionusuarios">Agregar Usuario</a>
                            </li>
                        @endif

                        
                            <li class="nav-item">
                                <a class="btn btn-outline-info" href="/gestionlibros">Gestion Libros</a>
                            </li>

                          

                         @if(auth()->user()->IdRol === 1)
                            <li class="nav-item">
                                <a class="btn btn-outline-info" href="/gestionprestamo">Prestamos</a>
                            </li>
                        @endif

                      

                        <form action="/login/cerrarsesion" method="post">
                            @csrf
                        <li  class="nav-item">
                            <a class="btn btn-outline-warning" href="#" onclick="this.closest('form').submit()">Salir</a>
                        </li>

                        </form>
                        
                    </ul>
                </div>
            </div>
        </nav>
    </header>
        @yield('content')
        
        
    </body>

</html>
