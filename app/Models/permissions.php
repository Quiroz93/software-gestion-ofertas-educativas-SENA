<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class permissions extends Model
{
    protected $table = ['id', 'nombre', 'guard_name', 'created_at', 'updated_at'];
}
