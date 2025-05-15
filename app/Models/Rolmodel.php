<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rolmodel extends Model
{
    //
    protected $table = 'roles'; // Nombre de la tabla en la base de datos
    protected $fillable = [
        'nombre',
        'descripcion',
    ]; // Campos que se pueden asignar masivamente
    protected $hidden = [
        'created_at',
        'updated_at',
    ]; // Campos que no se mostrarán en las respuestas JSON
    public function usuarios()
    {
        return $this->hasMany(UsuarioModel::class, 'rol_id');
    } // Relación con el modelo UsuarioModel
    public function getAuthPassword() // Método para obtener la contraseña
    {
        return $this->password;
    }
}
