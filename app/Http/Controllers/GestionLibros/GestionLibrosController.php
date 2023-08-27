<?php

namespace App\Http\Controllers\GestionLibros;

//use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use App\Models\User;
use App\Models\Libro;
use Log;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;
class GestionLibrosController extends Controller
{
    public $status = false;
    public $message = '';
    public function gestionlibros(){
        return view('GestionLibros');
    }

    public function crearlibros(Request $r){
        
        $validated = Validator::make($r->all(),[
            'titulo' => ['required','string'],
            'nombreportada' => ['required'],
            'autor' => ['required'],
            'generoliterario' => ['required'],
            'editorial' => ['required'],
            'ubicacion' => ['required'],
            'ejemplares' => ['required']
        ],[
            
            'titulo.required'=>'Titulo requerido',
            'nombreportada.required'=>'Nombre de Portada requerido',
            'autor.required'=>'Autor requerido',
            'generoliterario.required'=>'Genero_Literario requerida',
            'editorial.required'=>'Editorial contraseña',
            'ubicacion.required'=>'Ubicacion requerida',
            'ejemplares.required'=>'Ejemplares requerida'
        ]
        

        );

        if ( $validated->fails() ){
            return ['status' => $this->status, 'message' => 'Algo salio mal, verifica', 'validate' => $validated->errors(), 'model' => []];

        }
        $id = $r->IdLibro ? $r->IdLibro : 0;
        if($id > 0) $libros = Libro::find($id); else $libros = new Libro();

        $libros->titulo = $r->titulo ? $r->titulo : '';
        $libros->nombrePortada = $r->nombreportada ? $r->nombreportada : '';
        $libros->autor = $r->autor ? $r->autor : '';
        $libros->genero_Literario = $r->generoliterario ? $r->generoliterario : '';
        $libros->editorial = $r->editorial ? $r->editorial : '' ;
        $libros->ubicacion = $r->ubicacion ? $r->ubicacion : '';
        $libros->ejemplares = $r->ejemplares ? $r->ejemplares : 0;

        $libros->save();
        
        return ['status' => TRUE, 'message' => 'Libro creado exitosamente', 'validate' => $validated->errors(), 'model' => $libros];

    }

    public function getlibros(){
        $libros = Libro::where('estado', 'A')->select('libros.*')->get();
        return respuesta(true, '', [], $libros);
    }

    public function getdetalle(Request $r, $detalle){
        $libro = Libro::where('idLibro', $detalle)->select('libros.*')->get();
        return respuesta(true, '', [], $libro);
    }

    public function borrarlibro(Request $r, $borrar){
        $libroseliminados = Libro::find($borrar);
        $libroseliminados-> estado = 'X';
        $libroseliminados->save();
        return ['status'=>TRUE, 'message'=>'Libro eliminado exitosamente', 'validate'=>[], 'model'=>$libroseliminados];
    }

    public function buscartitulo(Request $r){
        $validate = Validator::make($r->all(), [
            'titulo' => [
                function($atribute, $value, $fail){
                    if($value){
                        $count = DB::table('libros')->whereRaw('LOWER(titulo) LIKE ?', ['%' . strtolower($value) . '%'])
                        ->count();
                        if($count === 0){
                            $fail("no se encontro el titulo buscado");
                        }
                    }
                }
            ]
            ]);
            if($validate->fails()){
                return ['status'=> $this->status, 'message'=>'NO SE ENCONTRARON LOS RESULTADOS', 'validate'=>$validate->errors(), 'model'=>[]];
                
            }

            $libros = Libro::where(function ($query) use ($r){
                if($r->titulo)
                $query->whereRaw('LOWER(titulo) LIKE ?', ['%' . strtolower($r->titulo) . '%']);
            })
            ->where('estado', 'A')
            ->select('libros.*')->get();
            //validar el nombre
            if($r->titulo && !preg_match('/^[a-zA-Z0-9\s]+$/', $r->titulo )){
                $validaciones['titulo']='solo letras y numeros ';

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
                'model' => $libros    
            ];
    }
}
