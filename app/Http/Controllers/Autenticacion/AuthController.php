<?php

namespace App\Http\Controllers\Autenticacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Log;
use DB;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthController extends Controller
{
  public $status = false;
    public $message = '';
    // creamos el controllador para inicio sesion

    public function login(Request $r){
       
        //creamos variable para llamar las credenciales del login (email y contraseña)
        $credenciales = $r->validate([
            'email'=>['required', 'email', 'string'],
            'password'=>['required', 'string']
        ]);

        //varaibale remenber para recordar la sesion del usuario, fille para crear booleanos
        $remember = $r->filled('checklogin');

         // creamos un condicional con las 2 variables , atemp es para un bolean y verificar las credenciales
         if(Auth::attempt($credenciales, $remember)){
            // evitar que se roben credenciales con los metodos
            $r->session()->regenerate();
            
            /*
            if(Auth::User()->IdRol == '1'){
                return redirect('/');
                
            }else if(Auth::User()->IdRol == '2'){
                return redirect('/');*/
                
            //}

           return redirect('/');

         }
         
         throw ValidationException::withMessages([
            'email'=>__('auth.failed')
         ]);
         return redirect('/login/loginview');

    }

    // creamos la vista para el incio (vista principal)
    public function inicio(){
        return view('/welcome');
      }

      public function loginview(){
        return view('auth.login');
      } 
//para validar campos
      public function register(Request $r){
        $r->validate([
            'name'=>['required', 'string','max:50'],
            'lastname'=>['required', 'string','max:50'],
            'email'=>['required', 'string','max:50', 'email', 'unique:users'],
            'password'=>['required', 'confirmed','max:10','min:3'],
            'edad'=>['required', 'integer'],
            'cedula'=>['required', 'integer','unique:users,cedula']
        ],[
            'name.required'=>'nombre requerido',
            'lastname.required'=>'apellido requerido',
            'email.required'=>'correo requerido',
            'password.required'=>'contraseña requerida',
            'password.confirmed'=>'confirmar contraseña',
            'edad.required'=>'edad requerida',
            'cedula.required'=>'cedula requerida'
        ]);
// aqui vamos a crear usuarios
        $users=User::create([
            'name'=>$r->name,
            'lastname'=>$r->lastname,
            'email'=>$r->email,
        // usamos bcryp para encriptar la contraseña
            'password'=>bcrypt($r->password),
            'edad'=>$r->edad,
            'cedula'=>$r->cedula
        ]);

        $token = JWTAuth::fromUser($users);

        //return redirect('/login/loginview')->withSuccess('Registrado correctamente');
        return response()->json(compact('user','token'),201);
      }


      public function registerview(){
        return view('auth.register');
      }

      public function logout(Request $r, Redirector $redirector){
        Auth::logout();
        //invaidar la sesion del usuario
        $r->session()->invalidate();
        //regenrar un nuevo token
        $r->session()->regenerateToken();
        return $redirector->to('/login/loginview')->with('status','Gracias por visitarnos');
      }

      public function gestionusuarios(){
        return view('GestionUsuario');
    }

    public function getUsers(){
        $users = User::where('estadoeliminacion', 'A')->select('users.*')->get();
        return respuesta(true, '', [], $users);
    }
    
    public function getRol(){
      $roles = Rol::all();
      return respuesta(true, '', [], $roles);
  }

    public function  crearusuario(Request $r){
    
      $id = $r->idUsuario ? $r->idUsuario : 0;

      $validateRules = [
          'name' => ['required', 'string', 'max:50'],
          'lastname' => ['required', 'string', 'max:50'],
          'email' => ['required', 'string', 'max:50', 'email'],
          'edad' => ['required', 'integer','between:18,60'],
          'password' => ['nullable', 'string', 'min:8', 'max:12', 'confirmed',
          'regex:/[A-Z]/', // Al menos una letra mayúscula
          'regex:/[a-z]/', // Al menos una letra minúscula
          'regex:/[0-9]/', // Al menos un número
          'regex:/[@#$%^&*()_\-=+{}\[\]:;<>,.?~]/' // al menos un caracteres especial
        ],
          'cedula' => ['required', 'integer',//validacion de cedula
           'digits:10','regex:/^(?!(\d)\1{9})\d{10}$/' 
        ],
          'rol' => ['required'],
      ];
  
      $validateMessages = [
          'name.required' => 'nombre requerido',
          'lastname.required' => 'apellido requerido',
          'email.required' => 'correo requerido',
          'edad.required' => 'edad requerida',
          'edad.between' => 'La edad debe estar entre 18 y 60 años.',
         'cedula.regex' => 'Cedula con numeros reptido no valida',
        'cedula.digits' => 'La cédula debe terner 10 caracteres.',

          'cedula.required' => 'cedula requerida',
          'rol.required' => 'rol requerido',
          'password.min' => 'La contraseña debe tener al menos :min caracteres.',
        'password.max' => 'La contraseña no puede tener más de :max caracteres.',
        'password.confirmed' => 'las contraseñas no coinciden',
        'password.regex' => 'la contraseña debe tener al menos un numero,una letra mayuscula, un letra minuscula, un numero y un caracter especial',
      ];
  
      if ($id == 0) {
          $validateRules['email'][] = 'unique:users,email';
          $validateRules['cedula'][] = 'unique:users,cedula';
  
          $validateMessages['email.unique'] = 'Correo repetido';
          $validateMessages['cedula.unique'] = 'Cédula repetida';

         
      }
  
      $validate = Validator::make($r->all(), $validateRules, $validateMessages);
  
      if ($validate->fails()) {
           return ['status' => FALSE, 'message' => 'Usuario fallido ', 'validate' => $validate->errors(), 'model' => []];
      }

      if($id>0) $usuario = User::find($id); else $usuario = new User();
      $usuario->name = $r->name ? $r->name : '';
      $usuario->lastname = $r->lastname ? $r->lastname : '';
      $usuario->email = $r->email ? $r->email : '';
      $usuario->edad = $r->edad ? $r->edad : '';
      $usuario->cedula = $r->cedula ? $r->cedula : '';
      $usuario->IdRol = $r->rol ? $r->rol : '';

      if($id == 0){
        $usuario->password = $r->password ? Hash::make($r->password) : Hash::make(Str::random(10));

      }else{
        if($r->password){
          $usuario->password = Hash::make($r->password);
        }
      }

      $usuario->save();
      return ['status' => TRUE, 'message' => 'Usuario actualizado exitosamente', 'validate' => [], 'model' => $usuario];

    }

    public function validatePassword($password){
      $passwordlength = strlen($password);
      if($passwordlength < 3 || $passwordlength > 10){
        return FALSE;
      }
      return TRUE;
    }


    public function getdetalleu(Request $r, $detalle){
      $usuarios = User::join('rols as r1', function($query){
          $query->on('r1.IdRol', '=', 'users.IdRol');
      })

      
      ->where('users.id', $detalle)
      ->where('users.estadoeliminacion', 'A')
      ->select('users.*', 'r1.descripcion')
      ->get();
      return respuesta(TRUE, '', [], $usuarios);


      
  }


  public function borraru(Request $r, $borrar){
    $usueliminados = User::find($borrar);
    $usueliminados-> estadoeliminacion = 'X';
    $usueliminados->save();
    return ['status'=>TRUE, 'message'=>'Usuario eliminado exitosamente', 'validate'=>[], 'model'=>$usueliminados];
}

  public function buscaru(Request $r){
    $validate = Validator::make($r->all(), [
      'cedula' => [
          function($atribute, $value, $fail){
              if($value){
                  $count = DB::table('users')->where('cedula', $value)
                  ->count();
                  if($count === 0){
                      $fail("no se encontro el usuario buscado");
                  }
              }
          }
      ]
      ]);
      if($validate->fails()){
          return ['status'=> $this->status, 'message'=>'NO SE ENCONTRARON LOS RESULTADOS', 'validate'=>$validate->errors(), 'model'=>[]];
          
      }

      $us = User::where(function ($query) use ($r){
          if($r->cedula)
          $query->where('cedula', 'LIKE', '%' . $r->cedula . '%');
      })
      ->where('estadoeliminacion', 'A')
      ->select('users.*')->get();
      //validar el nombre
      if($r->cedula && !preg_match('/^[0-9\s]+$/', $r->cedula )){
          $validaciones['cedula']='solo  numeros ';

      } 

      if(!empty($validaciones)){
          return[
              'status' => FALSE,
              'message' => 'Corriga los errores presentados',
              'validate' => $validaciones,
              'model' => []
          ];
      }

      return [ 
          'status' => TRUE,
          'message' => '',
          'validate' => [],
          'model' => $us    
      ];
  }

  //JWT AUTENTICACION

  public function authenticate(Request $request)
    {
      $credentials = $request->only('email', 'password');
      try {
          if (! $token = JWTAuth::attempt($credentials)) {
              return response()->json(['error' => 'invalid_credentials'], 400);
          }
      } catch (JWTException $e) {
          return response()->json(['error' => 'could_not_create_token'], 500);
      }
      return response()->json(compact('token'));
    }

    public function getAuthenticatedUser()
    {
        try {
          if (!$user = JWTAuth::parseToken()->authenticate()) {
                  return response()->json(['user_not_found'], 404);
          }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('user'));
    }


    public function logouth(){
      auth()->logout();
      return response()->json(['message' => 'Session cerrada con exito']);
  }
  // registro jwt
  public function registerUser(Request $request)
  {
  Log::info($request);

  $validator = Validator::make($request->all(), [
      'name' => ['required', 'string', 'max:255'],
      'lastname' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', Rules\Password::defaults()],
      'edad' => ['required', 'integer'],
      'cedula' =>['required']
  ], [
      'name.required' => 'El campo nombre es obligatorio',
      'lastname.required' => 'El campo apellidos es obligatorio',
      'email.required' => 'El campo correo es obligatorio',
      'password.required' => 'El campo contraseña es obligatorio',
      'edad.required' => 'edad requerida',
      'cedula.required' => 'cedula requerida'
  ]);

  if ($validator->fails()) {
      return response()->json($validator->errors(), 400);
  }

  $user = User::create([
      'name' => $request->name,
      'lastname' => $request->lastname,
      'email' => $request->email,
      'password' => bcrypt($request->password),
      'edad' => $request->edad,
      'cedula' => $request->cedula
  ]);

  $token = JWTAuth::fromUser($user);

  return response()->json(compact('user', 'token'), 201);
  }
}
