<?php

namespace App\Http\Controllers;

use App\Models\ColorModel;
use Illuminate\Http\Request;

class ColoresController extends Controller
{
    //
    public function Agregar(Request $request)
    {
        $request->validate([
            'color' => 'required|string|max:255',
            'cod_hex' => 'required|string|max:255'
        ]);
        $codigo_hexagonal = $request->input('cod_hex');
        $color = $request->input('color');

        // dd($request->all());

        

        $colores = ColorModel::create([
            'nombre' => $color,
            'codigo_hex' => $codigo_hexagonal,
            'created_at' => now(),
        ]);
        if ($colores) {
            return redirect()->route('productos.combinaciones')->with('mensaje', 'color guardada correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al guardar la categoría.');
        }
    }
    public function Actualizar(Request $request, $id)
    {
        $request->validate([
            'color' => 'required|string|max:255',
            'codigo_hex' => 'required|string|max:255',
        ]);

        $colores = ColorModel::findOrFail($id);

        $colores->update([
            'nombre' => $request->input('color'),
            'codigo_hex' => $request->input('codigo_hex'),
            'updated_at' => now(),
        ]);

        if ($colores) {
            return redirect()->route('productos.combinaciones')->with('mensaje', 'Color actualizada correctamente.');
        } else {
            return redirect()->back()->with('error', 'algo salio mal , intentalo de nuevo');
        }
    }

    public function Eliminar($id){

        $colores = ColorModel::findOrFail($id);
        $colores->delete();

        if ($colores) {
            return redirect()->route('productos.combinaciones')->with('mensaje', 'Color eliminado correctamente.');
        }
        else {
            return redirect()->back()->with('error', 'algo salio mal , intentalo de nuevo');
        }


    }
}
