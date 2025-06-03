<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class OpinionModel extends Model{
    
     use HasFactory;

    protected $table = 'opiniones';

    protected $fillable = [
        'usuario_id',
        'producto_id',
        'comentario',
        'calificacion',
        'fecha',
    ];

    public function producto()
    {
        return $this->belongsTo(Productosmodel::class, 'producto_id');
    }

    public function usuario()
    {
        return $this->belongsTo(UsuarioModel::class, 'usuario_id');
    }
}
