<?php

namespace App\Http\Controllers\GestionPrestamos;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use App\Models\User;
use App\Models\Prestamo;
use App\Models\Libro;
use Log;

class GestionPrestamosController extends Controller
{
    public $status = false;
    public $message = '';

    public function gestionprestamo(){

        if(Auth::User()->IdRol == 1){
            return view('GestionPrestamo');
          }else{
            return redirect('/');
          }
       
    }

    public function crearprestamos(Request $r){
        
        $validated = Validator::make($r->all(),[
            'fechadedevolucion' => ['required'],
            'fechaconfirmacion' => ['required'],
            'estado' => ['required'],
            'fechacreacion' => ['required'],
            'idLibro' => ['required'],
            'id' => ['required']
            
        ],[
            
            'fechadedevolucion.required'=>'fecha de devolucion requerido',
            'fechaconfirmacion.required'=>'fecha de confirmacion de devolucion requerido',
            'estado.required'=>'estado del prestamo requerido',
            'fechacreacion.required'=>' Fecha de la creacion del prestamo requerida',
            'idLibro.required'=>' Titulo del libro requerido',
            'id.required'=>'Usuario que pide el prestamo requerido'
        ]
        

        );

        if ( $validated->fails() ){
            return ['status' => $this->status, 'message' => 'Algo salio mal, verifica', 'validate' => $validated->errors(), 'model' => []];

        }
        $id = $r->IdPrestamo ? $r->IdPrestamo : 0;
        if($id > 0) $prestamos = Prestamo::find($id); else $prestamos = new Prestamo();

        $prestamos->FechaDevolucion = date('Y-m-d', strtotime ($r->fechadedevolucion)) ? $r->fechadedevolucion : '';
        $prestamos->FechaConfirmacionDevolucion = date('Y-m-d', strtotime ($r->fechaconfirmacion)) ? $r->fechaconfirmacion : '';
        $prestamos->Estado = $r->estado ? $r->estado : '';
        $prestamos->fechaCreacion = date('Y-m-d', strtotime ($r->fechacreacion)) ? $r->fechacreacion : '';
        $prestamos->idLibro = $r->idLibro ? $r->idLibro : '' ;
        $prestamos->idUsuario = $r->id ? $r->id : '';

        $prestamos->save();
        
        return ['status' => TRUE, 'message' => 'prestamo creado exitosamente', 'validate' => $validated->errors(), 'model' => $prestamos];

    }

    public function getprestamos(Request $r){
        $prestamos = Prestamo::join('libros as l1', function($query){
            $query->on('l1.idLibro', '=', 'prestamos.IdLibro');
        })

        ->join('users as u1', function($query){
            $query->on('u1.id', '=', 'prestamos.IdUsuario');
        })
        ->where('prestamos.estadoeliminacion', 'A')
        ->select('prestamos.*', 'l1.titulo', 'u1.cedula')
        ->get();
        return respuesta(TRUE, '', [], $prestamos);
    }

    public function getprestamodetalle(Request $r, $detalle){
        $prestamos = Prestamo::join('libros as l1', function($query){
            $query->on('l1.idLibro', '=', 'prestamos.IdLibro');
        })

        ->join('users as u1', function($query){
            $query->on('u1.id', '=', 'prestamos.IdUsuario');
        })
        ->where('prestamos.IdPrestamo', $detalle)
        ->where('prestamos.estadoeliminacion', 'A')
        ->select('prestamos.*', 'l1.titulo', 'u1.cedula')
        ->get();
        return respuesta(TRUE, '', [], $prestamos);
    }

    public function borrarprestamo(Request $r, $borrar){
        $prestamoseliminados = Prestamo::find($borrar);
        $prestamoseliminados-> estadoeliminacion = 'X';
        $prestamoseliminados->save();
        return ['status'=>TRUE, 'message'=>'Prestamo eliminado exitosamente', 'validate'=>[], 'model'=>$prestamoseliminados];
    }

    public function buscarprestamo(Request $r){
        $validate = Validator::make($r->all(), [
            'titulo' => [
                function($atribute, $value, $fail){
                    if($value){
                        $count = Prestamo::join('libros as l1', function($query){
                            $query->on('l1.idLibro', '=', 'prestamos.IdLibro' )
                            ->where('l1.titulo', 'like', '%');
                        })->whereRaw('LOWER(l1.titulo) LIKE ?', ['%' . strtolower($value) . '%'])
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

            $prestamos = Prestamo::join('libros as l1', function($query){
                $query->on('l1.idLibro', '=', 'prestamos.IdLibro' )
                ->where('l1.titulo', 'like', '%');
            })->where(function ($query) use ($r){
                if($r->titulo)
                $query->whereRaw('LOWER(l1.titulo) LIKE ?', ['%' . strtolower($r->titulo) . '%']);
            })
            ->where('prestamos.estadoeliminacion', 'A')
            ->select('prestamos.*', 'l1.titulo')->get();
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
                'model' => $prestamos    
            ];
    }
}
