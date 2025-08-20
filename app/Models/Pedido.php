<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'usuario_id',
        'fecha_pedido',
        'estado',
        'direccion_envio',
        'metodo_pago',
        'total'
    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioModel::class, 'usuario_id');
    }

    public function items()
    {
        return $this->hasMany(PedidoItemModel::class, 'pedido_id');
    }
}
