<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Productomodel;


class categoriamodel extends Model
{
    protected $table = 'categorias';

    protected $fillable = ['nombre'];

    public function productos()
    {
        return $this->hasMany(Productosmodel::class);
    }
}
