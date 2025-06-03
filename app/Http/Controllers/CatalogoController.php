<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productosmodel;
use App\Models\categoriamodel;
use App\Models\tallamodel;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Storage;

class CatalogoController extends Controller
{
    //
    public function Catalogo()
    {
        $productos = Productosmodel::all();
        $productoss = Productosmodel::with(['inventario'])->get(); // 
        foreach ($productoss as $producto) {
            $stock = $producto->inventario->sum('stock'); // Sumar el stock de todas las variantes
        }
        return view('catalogo.catalogo', compact('productos', 'stock'));
    }
    public function Detalles($id)
    {
        $producto = Productosmodel::with('inventario.talla', 'inventario.color')->findOrFail($id); // busca el producto por ID y carga las relaciones de inventario, talla y color

        $stock = $producto->inventario->sum('stock'); // Sumar el stock de todas las variantes

        $categoria = categoriamodel::find($producto->categoria_id); // Obtiene la categoría del producto

        $tallasDisponibles = $producto->inventario->where('stock', '>', 0)->pluck('talla.nombre')->unique(); // Obtiene las tallas disponibles del producto
        $coloresDisponibles = $producto->inventario->where('stock', '>', 0)->pluck('color.nombre')->unique(); // Obtiene los colores disponibles del producto
        // $stock = $producto->inventario->sum('stock'); // Sumar el stock de todas las variantes
        return view('catalogo.detalles', compact('producto', 'categoria', 'tallasDisponibles', 'coloresDisponibles', 'stock'));
    }
    public function Buscar(Request $request)
    {
        $query = $request->input('query');
        $productos = Productosmodel::where('nombre', 'like', '%' . $query . '%')
            ->orWhere('descripcion', 'like', '%' . $query . '%')
            ->get();

        return view('catalogo.catalogo', compact('productos'));
    }
    public function FiltrarPorCategoria($categoriaId)
    {
        $productos = Productosmodel::where('categoria_id', $categoriaId)->get();
        return view('catalogo.catalogo', compact('productos'));
    }
    public function FiltrarPorPrecio(Request $request)
    {
        $minPrecio = $request->input('min_precio', 0);
        $maxPrecio = $request->input('max_precio', 999999);

        $productos = Productosmodel::whereBetween('precio', [$minPrecio, $maxPrecio])->get();

        return view('catalogo.catalogo', compact('productos'));
    }
    public function FiltrarPorMarca($marca)
    {
        $productos = Productosmodel::where('marca', $marca)->get();
        return view('catalogo.catalogo', compact('productos'));
    }
    public function FiltrarPorTalla($tallaId)
    {
        $productos = Productosmodel::whereHas('tallas', function ($query) use ($tallaId) {
            $query->where('talla_id', $tallaId);
        })->get();

        return view('catalogo.catalogo', compact('productos'));
    }
    public function FiltrarPorColor($colorId)
    {
        $productos = Productosmodel::whereHas('colores', function ($query) use ($colorId) {
            $query->where('color_id', $colorId);
        })->get();

        return view('catalogo.catalogo', compact('productos'));
    }
}
