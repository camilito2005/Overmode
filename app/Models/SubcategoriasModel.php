<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubcategoriasModel extends Model
{
    //
    protected $table = 'subcategorias';
    protected $fillable = ['subcategoria', 'categoria_id', 'parent_id'];

    public function categoria()
    {
        return $this->belongsTo(CategoriaModel::class, 'categoria_id');
    }
    public function parent()
    {
        return $this->belongsTo(SubcategoriasModel::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(SubcategoriasModel::class, 'parent_id');
    }
}
