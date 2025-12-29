<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class nivel_formacion extends Model
{
    protected $table = "nivel_formaciones";
    protected $fillable = ["nombre","descripcion"];
}
