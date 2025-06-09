<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\categoriamodel;
use App\Models\InventarioModel;
use App\Models\TallaModel;
use App\Models\ColorModel;
use App\Models\OpinionModel;
use App\Models\CarritoItemModel;
use App\Models\PedidoItem;
use App\Models\UsuarioModel;

class Productosmodel extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'categoria_id',
        'marca',
        'imagen_url',
    ];

    // Relaciones
    public function categoria()
    {
        return $this->belongsTo(categoriamodel::class);
    }

    // public function inventario()
    // {
    //     return $this->hasMany(InventarioModel::class);
    // }
    public function inventario()
    {
        return $this->hasMany(InventarioModel::class, 'producto_id');
    }

    public function tallas()
    {
        return $this->belongsToMany(TallaModel::class, 'producto_talla', 'producto_id', 'talla_id');
    }

    public function colores()
    {
        return $this->belongsToMany(ColorModel::class, 'producto_color', 'producto_id', 'color_id');
    }
    // public function opiniones()
    // {
    //     return $this->hasMany(OpinionModel::class);
    // }
    public function opiniones()
    {
        return $this->hasMany(OpinionModel::class, 'producto_id');
    }


    public function carritoItems()
    {
        return $this->hasMany(CarritoItemModel::class);
    }

    public function pedidoItems()
    {
        return $this->hasMany(PedidoItem::class);
    }
}
