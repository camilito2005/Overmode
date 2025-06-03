<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Productosmodel;
use App\Models\categoriamodel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class TallaModel extends Model{
    
    protected $table = 'tallas';

    protected $fillable = ['nombre'];

    
    public function productos()
    {
        return $this->belongsToMany(Productosmodel::class, 'producto_talla', 'talla_id', 'producto_id');
    }
}
