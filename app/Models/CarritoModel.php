<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CarritoItemModel;

class CarritoModel extends Model
{
    use HasFactory;

    protected $table = 'carritos';

    protected $fillable = [
        'usuario_id',
        'estado', // ejemplo: activo, pendiente, comprado
        'activo', // 

    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioModel::class, 'usuario_id');
    }

    public function items()
    {
        return $this->hasMany(CarritoItemModel::class, 'carrito_id');
    }
}
