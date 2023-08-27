<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Libro extends Model
{
    use HasFactory;
    use HasApiTokens, HasFactory, Notifiable;
    protected $guarded = ['idLibro'];
    protected $primaryKey = 'idLibro';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idLibro',
        'titulo',
        'nombrePortada',
        'autor',
        'genero_Literario',
        'editorial',
        'ubicacion',
        'ejemplares'

    ];



}
