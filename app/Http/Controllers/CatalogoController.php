<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productosmodel;
use App\Models\categoriamodel;
use App\Models\ColorModel;
use App\Models\OpinionModel;
use App\Models\tallamodel;
use App\Models\UsuarioModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CatalogoController extends Controller
{
    //
    public function Catalogo()
    {
        $productos = Productosmodel::with('inventario.talla', 'inventario.color')->get();
        $categorias = categoriamodel::all();
        $marcas = Productosmodel::distinct()->pluck('marca');

        // Cambiar aquí: obtener id y nombre
        $tallas = tallamodel::select('id', 'nombre')->distinct()->get();
        $colores = ColorModel::select('id', 'nombre')->distinct()->get();

        // $tallas = tallamodel::groupBy('nombre', 'id')->get();
        // $colores = ColorModel::groupBy('nombre', 'id')->get();



        return view('catalogo.catalogo', compact('productos', 'categorias', 'marcas', 'tallas', 'colores'));
    }

    public function Detalles($id)
    {
        $producto = Productosmodel::with('inventario.talla', 'inventario.color')->findOrFail($id); // busca el producto por ID y carga las relaciones de inventario, talla y color

        $stock = $producto->inventario->sum('stock'); // Sumar el stock de todas las variantes

        $categoria = categoriamodel::find($producto->categoria_id); // Obtiene la categoría del producto

        $tallasDisponibles = $producto->inventario->where('stock', '>', 0)->pluck('talla.nombre')->unique(); // Obtiene las tallas disponibles del producto
        $coloresDisponibles = $producto->inventario->where('stock', '>', 0)->pluck('color.nombre')->unique(); // Obtiene los colores disponibles del producto

        $relacionados = Productosmodel::where('categoria_id', $producto->categoria_id)->where('id', '!=', $producto->id)->limit(4)->get();

        $opiniones = $producto->opiniones()->latest()->paginate(3);

        // $opinionesVisible = $opiniones->take(3); // Solo las 3 primeras
        // $stock = $producto->inventario->sum('stock'); // Sumar el stock de todas las variantes
        return view('catalogo.detalles', compact('producto', 'categoria', 'tallasDisponibles', 'coloresDisponibles', 'stock', 'relacionados','opiniones'));
    }
    public function Buscar(Request $request)
    {
        $search = $request->input('search');

        $productos = Productosmodel::where('nombre', 'ilike', '%' . $search . '%')
            ->orWhere('descripcion', 'ilike', '%' . $search . '%')
            ->get();
             return response()->json($productos);

        return response()->json([]);
    }

    public function Filtrar(Request $request)
    {
        $query = Productosmodel::with('inventario.talla', 'inventario.color');

        // Filtrar por categoría
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        // Filtrar por marca
        if ($request->filled('marca')) {
            $query->where('marca', $request->marca);
        }

        // Filtrar por precio
        if ($request->filled('min_precio') || $request->filled('max_precio')) {
            $min = $request->input('min_precio', 0);
            $max = $request->input('max_precio', 999999);
            $query->whereBetween('precio', [$min, $max]);
        }

        // Filtrar por talla (vía inventario)
        if ($request->filled('talla_id')) {
            $query->whereHas('inventario.talla', function ($q) use ($request) {
                $q->where('talla_id', $request->talla_id);
            });
        }

        // Filtrar por color (vía inventario)
        if ($request->filled('color_id')) {
            $query->whereHas('inventario.color', function ($q) use ($request) {
                $q->where('color_id', $request->color_id);
            });
        }

        $productos = $query->get();

        // También retornamos los filtros disponibles para que la vista no falle
        $categorias = categoriamodel::all();
        $marcas = Productosmodel::distinct()->pluck('marca');
        // $tallas = tallamodel::distinct()->pluck('nombre');
        $tallas = tallamodel::all();
        // $colores = ColorModel::distinct()->pluck('nombre');
        $colores = ColorModel::all();

        return view('catalogo.catalogo', compact('productos', 'categorias', 'marcas', 'tallas', 'colores'));
    }
    public function Opinion(Request $request, $id)
    {
        $request->validate([
            'calificacion' => 'required|numeric|min:0',
            'comentario' => 'required|string|max:1000',
        ]);

        $usuario = Auth::user()->id;

        $opinion = OpinionModel::create([
            'usuario_id' => $usuario,
            'producto_id' => $id,
            'calificacion' => $request->input('calificacion'),
            'comentario' => $request->input('comentario'),
        ]);

        if ($opinion) {
            return redirect()->back()->with('mensaje', 'su opinion a sido guardada exitosamente.');
        } else {
            return redirect()->back()->with('error', 'Error al guardar la categoría.');
        }
    }
    public function ListarOpinion(){
        
    }
}
