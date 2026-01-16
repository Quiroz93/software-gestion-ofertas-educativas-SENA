<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class competencia extends Model
{
    // Definir la tabla si no sigue la convención plural
    protected $table = "competencias";

    // Definir los campos que pueden ser asignados masivamente
    protected $fillable = ["nombre","descripcion"]; 
}
