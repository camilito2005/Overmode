<?php

namespace App\Http\Controllers;

use App\Models\categoriamodel;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    //
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $categoria = categoriamodel::create([
            'nombre' => $request->input('nombre'),
            'created_at' => now(),
        ]);
        if ($categoria) {
            return redirect()->route('productos.combinaciones')->with('success', 'Categoría guardada correctamente.'); 
        } else {
            return redirect()->back()->with('error', 'Error al guardar la categoría.');
        
            # code...
        }
    }
    public function Actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $categoria = categoriamodel::findOrFail($id);
        $categoria->nombre = $request->input('nombre');
        $categoria->updated_at = now();
        $categoria->save();

        return redirect()->route('productos.combinaciones')->with('success', 'Categoría actualizada correctamente.');
    }
    public function Eliminar($id)
    {
        $categoria = categoriamodel::findOrFail($id);
        $categoria->delete();

        return redirect()->route('productos.combinaciones')->with('success', 'Categoría eliminada correctamente.');
    }
}
