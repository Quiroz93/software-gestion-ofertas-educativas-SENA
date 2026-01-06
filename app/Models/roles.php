<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class roles extends Model
{
    protected $table = ['id', 'name', 'guard_name', 'created_at', 'updated_at'];
}
