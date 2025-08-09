<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubcategoriasModel extends Model
{
    //
    protected $table = 'subcategorias';
    protected $fillable = ['subcategoria', 'categoria_id'];

    public function categoria()
    {
        return $this->belongsTo(CategoriaModel::class, 'categoria_id');
    }
}
