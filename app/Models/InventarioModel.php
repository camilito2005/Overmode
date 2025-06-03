<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Productosmodel;
use App\Models\TallaModel;
use App\Models\ColorModel;

class InventarioModel extends Model
{
    protected $table = 'inventario';

    protected $fillable = [
        'producto_id',
        'stock',
        'talla_id',    // opcional, si el stock es por talla
        'color_id',    // opcional, si el stock es por color
    ];

    public function producto()
    {
        return $this->belongsTo(Productosmodel::class, 'producto_id');
    }

    public function talla()
    {
        return $this->belongsTo(TallaModel::class, 'talla_id');
    }

    public function color()
    {
        return $this->belongsTo(ColorModel::class, 'color_id');
    }
}
