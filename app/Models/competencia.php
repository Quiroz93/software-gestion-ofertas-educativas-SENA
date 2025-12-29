<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class competencia extends Model
{
    protected $table = "competencias";
    protected $fillable = ["nombre","descripcion"]; 
}
