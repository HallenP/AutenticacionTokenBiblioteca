<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Prestamo extends Model
{
    use HasFactory;
    use HasApiTokens, HasFactory, Notifiable;
    protected $guarded = ['IdPrestamo'];
    protected $primaryKey = 'IdPrestamo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'IdPrestamo',
        'IdUsuario',
        'IdLibro',
        'FechaDevolucion',
        'FechaConfirmacionDevolucion',
        'Estado',
        'FechaCreacion',
        'estadoeliminacion'

    ];


}
