<?php
use App\Http\Controllers\Controller;

if (! function_exists('current_user')) {
    function respuesta($status, $message, $validate, $model)
    {
        return ['status' => $status, 'message' => message($message), 'validate' => $validate, 'model' => $model];
    }

    function message($message)
    {
        switch ($message) {
            case 'success':
                $message = 'Acción realizada con exito';
                break;
            case 'error':
                $message = 'No se pudo completar la acción';
                break;
            case 'delete':
                $message = 'Registro eliminado con exito';
                break;
            case 'validate':
                $message = 'Llena los campos requeridos';
                break;
            default:
                // $message = $message;
                break;
        }
        return $message;
    }
}