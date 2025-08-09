<?php

namespace App\Http\Controllers;

use App\Models\SubcategoriasModel;
use Illuminate\Http\Request;

class SubcategoriaController extends Controller
{
    //
    public function Guardar(Request $request){
        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $subcategorias = SubcategoriasModel::create([
            'subcategoria' => $request->input('nombre'),
            'categoria_id' => $request->input('categoria_id'),
            'created_at' => now(),
            'updated_at' => now(),
        // ])->save();
        ]);
        if ($subcategorias) {
            return redirect()->back()->with('mensaje', 'Subcategoría guardada correctamente');
        }else {
            return redirect()->back()->with('mensaje', 'Error al guardar la subcategoría');
        }

    }
}
