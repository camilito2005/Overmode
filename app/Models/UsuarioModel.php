<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UsuarioModel extends Model
{
    //
    protected $table = 'usuarios'; // Nombre de la tabla en la base de datos
    protected $fillable = [
        'nombre',
        'password',
        'direccion',
        'telefono',
        'ciudad',
        'email',
        'rol_id'
    ]; // Campos que se pueden asignar masivamente
    protected $hidden = [
        'password',
    ]; // Campos que no se mostrarán en las respuestas JSON
    public function rol() // Relación con el modelo RolModel
    {
        return $this->belongsTo(RolModel::class, 'rol_id'); // Cambia 'rol_id' por el nombre de la clave foránea en tu tabla usuarios
    }
    public function getAuthPassword() // Método para obtener la contraseña
    {
        return $this->password;
    }
}
