<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Rol extends Model
{
    use HasFactory;
    use HasApiTokens, HasFactory, Notifiable;
    protected $guarded = ['IdRol'];
    protected $primaryKey = 'IdRol';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'IdRol',
        'Descripcion'
        
    ];

}
