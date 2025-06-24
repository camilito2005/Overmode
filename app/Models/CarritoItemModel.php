<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UsuarioModel;
use App\Models\Productosmodel;

class CarritoItemModel extends Model
{
    use HasFactory;

    protected $table = 'carritos_item';

    protected $fillable = [
        'carrito_id',
        'talla_id',
        'color_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioModel::class, 'usuario_id');
    }

    public function producto()
    {
        return $this->belongsTo(Productosmodel::class, 'producto_id');
    }
    public function carrito()
    {
        return $this->belongsTo(CarritoModel::class, 'carrito_id');
    }
    public function talla()
    {
        return $this->belongsTo(TallaModel::class, 'talla_id');
    }
    public function color()
    {
        return $this->belongsTo(ColorModel::class, 'color_id');
    }
    public function pedidoItems()
    {
        return $this->hasMany(PedidoItem::class, 'carrito_item_id');
    }
}
