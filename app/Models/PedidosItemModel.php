<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UsuarioModel;
use App\Models\Productosmodel;
use App\Models\Pedido;

class PedidoItem extends Model
{
    use HasFactory;

    protected $table = 'pedidos_item';

    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'total'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    public function usuario()
    {
        return $this->belongsTo(UsuarioModel::class, 'usuario_id');
    }

    public function producto()
    {
        return $this->belongsTo(Productosmodel::class, 'producto_id');
    }
}
