<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'persona'; // Nombre de la tabla en la base de datos

    protected $fillable = ['nombre', 'paterno', 'materno']; // Campos que puedes asignar masivamente

    // Si la clave primaria no es 'id', debes especificarlo
    protected $primaryKey = 'id';

    // Si la clave primaria no es autoincremental, debes especificarlo
    public $incrementing = true;

    // Si no usas timestamps (created_at y updated_at)
    public $timestamps = false;
}
