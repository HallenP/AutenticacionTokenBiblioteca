@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
        </div>
    </div>

</div>


<div class="container-fluid">
                  <div class="row">
                      <div class="col-sm-12">
                          <div class="card">
                              <div class="card-body">
                                  <ul class="nav nav-tabs border-tab justify-content-center" id="top-tab" role="tablist">
                                      <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-home" role="tab" aria-controls="top-home" aria-selected="true"><i class="icofont icofont-ui-edit"></i>LOGIN</a></li>
                                      <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="false"><i class="icofont icofont-ui-add"></i>LOGIN CON TOKEN</a></li>
                                      
                                  </ul>
                                  <div class="tab-content" id="top-tabContent">
                                      <div class="tab-pane fade show active" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                                      <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="/login">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Ingrese su correo</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="checklogin" id="exampleCheck1">
                                    <label class="form-check-label">Recordar sesion</label>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4 justify-conten-center">
                                
                                <button type="submit" class="btn btn-primary">
                                    Iniciar Sesion
                                </button>

                                
                                

                                
                            </div>
                        </div>
                    
                        
                        
                    </form>
                </div>
            </div>
                                      </div>
                                      <div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">
                                      <gestiontoken-component></gestiontoken-component>
                                      </div>
                                      
                                  </div>            
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
                
                @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        <script scr="{{asset('js/app.js')}}"></script>
        <script scr="{{asset('assets/js/main.js')}}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
