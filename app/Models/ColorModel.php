<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ColorModel extends Model
{
    protected $table = 'colores';

    protected $fillable =
    [
        'nombre',
        'codigo_hex',
    ];

    public function productos()
    {
        return $this->belongsToMany(Productosmodel::class, 'producto_color', 'color_id', 'producto_id');
    }
}
