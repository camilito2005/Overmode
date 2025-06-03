<?php

namespace App\Http\Controllers;

use App\Models\TallaModel;
use Illuminate\Http\Request;

class TallasController extends Controller
{
    //
    public function Agregar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);
        $nombre = $request->input('nombre');
        $tallas = TallaModel::create([
            'nombre' => $nombre,
            'created_at' => now(),
        ]);
        if ($tallas) {
            return redirect()->route('productos.combinaciones')->with('mensaje', 'talla creada exitosamente');
        } else {
            return redirect()->back()->with(['mensaje' => 'algo salio mal , intentalo de nuevo']);
        }
    }

    public function Actualizar(Request $request, $id)
    {
        $request->validate([
            'talla' => 'required|string|max:255',
        ]);

        $talla = TallaModel::findOrFail($id);

        $talla->update([
            'nombre' => $request->input('talla'),
            'updated_at' => now(),
        ]);

        if ($talla) {
            return redirect()->route('productos.combinaciones')->with('mensaje', 'Talla actualizada correctamente.');
        } else {
            return redirect()->back()->with('error', 'algo salio mal , intentalo de nuevo');
        }
    }

    public function Eliminar($id)
    {
        $tallas = TallaModel::findOrFail($id);
        $tallas->delete();

        if ($tallas) {
            return redirect()->route('productos.combinaciones')->with('mensaje', 'Talla eliminada correctamente.');
        } else {
            return redirect()->back()->with(['mensaje' => 'algo salio mal , intentalo de nuevo']);
        }
    }
}
