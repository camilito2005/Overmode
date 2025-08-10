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
            'parent_id' => 'nullable|exists:subcategorias,id', // Validar que la subcategoría padre exista
        ]);

        $subcategorias = SubcategoriasModel::create([
            'subcategoria' => $request->input('nombre'),
            'categoria_id' => $request->input('categoria_id'),
            'parent_id' => $request->input('parent_id'), // Guardar el ID de la subcategoría padre si se proporciona
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
