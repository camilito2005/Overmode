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
        'usuario_id',
        'producto_id',
        'cantidad',
    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioModel::class, 'usuario_id');
    }

    public function producto()
    {
        return $this->belongsTo(Productosmodel::class, 'producto_id');
    }
}
