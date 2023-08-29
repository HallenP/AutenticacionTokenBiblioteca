<?php

namespace App\Http\Controllers\GestionToken;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



use Illuminate\Routing\Redirector;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use App\Models\User;
use App\Models\Libro;
use Log;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Crypt;


class GestionTokenController extends Controller
{
    //creamos una vista

    public function gestiontoken(){
        /* 
        if(Auth::User()->IdRol == 1){
            return view('Token');
          }else{
            return redirect('/');
          }*/
          if(Auth::User()->IdRol == 1){
            
          
          $users = User::all();
          $usertokens = [];
          foreach($users as $user){
              $usertokens[$user->id] = JWTAuth::fromUser($user);
              
          }
          return view( 'Token', compact('users','usertokens')); 
        }
    }

    public function logintoken(Request $r, $token){
        try{
            $user = JWTAuth::parseToken($token)->authenticate();
            Auth::login($user);
            return redirect('/');
        }catch(
            \Exception $e
        ){
            return response()->json(['message'=>'token invalido'],401);
            //return respuesta(TRUE, '', [], $user); 
        }
    }

    //metodo para verificar el token
    public function generatetoken(Request $r){

   // $tokene = $r->input('email');
   // $tokenp = $r->input('password');
    
    //$user = User::where('email', $tokene)->first();
/* 
    if ($user && Hash::check($tokenp, $user->password)) {
        return 'contraseña correcta';
    } else {
        return 'contraseña incorrecta';
    }*/

   // if (!$user) {
      //  return redirect()->back()->with('error', 'Usuario token no encontrado');
   // }

    //$auth = JWTAuth::fromUser($user);
    //return respuesta(TRUE, '', [], $auth); 
        //return response()->json(compact('auth'));
        
       // $email = $r->input('email');
         // Obtén el correo electrónico del formulario
        //$password = $r->input('password'); // Obtén la contraseña del formulario
      //  $credentials = $r->only('email', 'password');

        // Busca el usuario por su dirección de correo electrónico
       // $user = User::where('email', $credentials)->first();
       /* 
        if (!$user) {
            return redirect()->back()->with('error', 'Usuario no encontrado');

        }*/
        

        //var_dump(bcrypt($password), $user->password);
        
        // Verifica si la contraseña ingresada coincide con la contraseña almacenada
        /*
        if (Hash::check($credentials['password'], $user->password)) {
            // Genera el token
            $token = JWTAuth::fromUser($user);
        
            return response()->json(compact('token'));
        } else {
            return redirect()->back()->with('error', 'Contraseña incorrecta');
        }
*/

        $credentials = $r->only('email', 'password');
    
    $user = User::where('email', $credentials['email'])->first();
    
    if (!$user) {
        return redirect()->back()->with('error', 'Usuario no encontrado');
    }
    
    if (Hash::check($credentials['password'], $user->password)) {
        // Genera el token
        $token = JWTAuth::fromUser($user);
        //return response()->json(compact('token'));
        return respuesta(TRUE, '', [], $token); 
    } else {
        //return redirect()->back()->with('error', 'Contraseña incorrecta');
        return respuesta(FALSE, '', [], $token);
    }


    }

    public function mostrartokens(){
        
        $users = User::all();
        $usertokens = [];
        foreach($users as $user){
            $usertokens[$user->id] = JWTAuth::fromUser($user);
            
        }
       // return view( 'Token', compact('users','usertokens')); 
        return respuesta(TRUE, '', [], ['usertokens'=>$usertokens, 'users'=>$users]); 
    }
}
