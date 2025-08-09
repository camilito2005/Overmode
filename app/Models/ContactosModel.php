<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactosModel extends Model
{
    //
    protected $table = 'contactanos'; // Nombre de la tabla en la base de datos
    protected $fillable = ['nombre', 'correo', 'mensaje']; // Campos que se pueden asignar masivamente
}
