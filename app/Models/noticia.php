<?php
// app/Models/Noticia.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    // Definir la tabla si no sigue la convención plural
    protected $table = 'noticias';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'activa',
    ];
}

