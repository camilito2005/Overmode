<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class UsuarioModel extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable, CanResetPasswordTrait;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellido',
        'password',
        'direccion',
        'telefono',
        'ciudad',
        'email',
        'rol_id'
    ]; // Campos que se pueden llenar masivamente

    protected $hidden = [
        'password',
        'remember_token',
    ]; // Campos que se ocultan al serializar el modelo

    public function rol()
    {
        return $this->belongsTo(RolModel::class, 'rol_id');
    }

    public function getAuthPassword()
    {
        return $this->password;
    }
}
