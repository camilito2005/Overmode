<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productosmodel;
use App\Models\categoriamodel;
use App\Models\SubcategoriasModel;
use App\Models\ColorModel;
use App\Models\OpinionModel;
use App\Models\tallamodel;
use App\Models\UsuarioModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CatalogoController extends Controller
{
    public function Productos(){
        return view('catalogo.detalles_old');
    }
    //
    public function Catalogo()
    {
        $productos = Productosmodel::with('inventario.talla', 'inventario.color')->get();
        $categorias = categoriamodel::all();
        $subcategorias = SubcategoriasModel::wherenull('parent_id')->get(); // obtengo las subcategorias principales
        $subsubcategorias = SubcategoriasModel::wherenotnull('parent_id')->get();// obtengo las subcategorias hijas
        $marcas = Productosmodel::distinct()->pluck('marca');

        // Cambiar aquí: obtener id y nombre
        $tallas = tallamodel::select('id', 'nombre')->distinct()->get();
        $colores = ColorModel::select('id', 'nombre')->distinct()->get();

        // $tallas = tallamodel::groupBy('nombre', 'id')->get();
        // $colores = ColorModel::groupBy('nombre', 'id')->get();



        return view('catalogo.catalogo', compact('productos', 'categorias', 'subcategorias','subsubcategorias','marcas', 'tallas', 'colores'));
    }

    public function Detalles($id)
    {
        $producto = Productosmodel::with('inventario.talla', 'inventario.color')->findOrFail($id);

        $stock = $producto->inventario->sum('stock');
        $categoria = categoriamodel::find($producto->categoria_id);
        $subcategoria = SubcategoriasModel::find($producto->subcategoria_id);
        // obtengo las subcategorias hija que son las que tiene parent_id en la tabla subcategorias
        $subcategoriashijas = SubcategoriasModel::where('parent_id', $producto->subcategoria_id)->get(); // obtenemos las subcategorias hijas de la subcategoria del producto

        $tallasDisponibles = $producto->inventario // Filtramos las tallas que tienen stock mayor a 0
            ->where('stock', '>', 0)
            ->mapWithKeys(function ($item) {
                return [$item->talla->id => $item->talla->nombre];
            })->unique();

        $coloresDisponibles = $producto->inventario // Filtramos los colores que tienen stock mayor a 0
            ->where('stock', '>', 0)
            ->mapWithKeys(function ($item) {
                return [$item->color->id => $item->color->nombre];
            })->unique();

        $relacionados = Productosmodel::where('categoria_id', $producto->categoria_id) // Obtenemos productos relacionados por la misma categoría
            ->where('subcategoria_id', $producto->subcategoria_id) // y la misma subcategoría
            // y la misma subcategoria hija segun el parent_id
            ->where('parent_id', $producto->parent_id)
            ->where('id', '!=', $producto->id)
            ->limit(4)
            ->get();

        $opiniones = $producto->opiniones()->latest()->paginate(3);

        return view('catalogo.detalles', compact(
            'producto',
            'categoria',
            'subcategoria',
            'subcategoriashijas',
            'tallasDisponibles',
            'coloresDisponibles',
            'stock',
            'relacionados',
            'opiniones'
        ));
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

        if ($request->filled('subcategoria_id')) {
            $query->where('subcategoria_id', $request->subcategoria_id);
        }

        // Filtrar por subsubcategoríahija
        if ($request->filled('parent_id')) {
            $query->where('parent_id', $request->parent_id);
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
        $subcategorias = SubcategoriasModel::wherenull('parent_id')->get(); // obtengo las subcategorias principales
        $subsubcategorias = SubcategoriasModel::wherenotnull('parent_id')->get();// obtengo las subcategorias hijas
        // $marcas = Productos
        $marcas = Productosmodel::distinct()->pluck('marca');
        // $tallas = tallamodel::distinct()->pluck('nombre');
        $tallas = tallamodel::all();
        // $colores = ColorModel::distinct()->pluck('nombre');
        $colores = ColorModel::all();

        return view('catalogo.catalogo', compact('productos', 'categorias', 'subcategorias','subsubcategorias', 'marcas', 'tallas', 'colores'));
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
}
