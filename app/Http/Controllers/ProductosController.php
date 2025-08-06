<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productosmodel;
use App\Models\categoriamodel;
use App\Models\TallaModel;
use App\Models\ColorModel;
use App\Models\InventarioModel;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

class ProductosController extends Controller
{
    public function Home(){
        // obtengo 4 productos,los mas recientes
        $productos = ProductosModel::orderBy('created_at', 'desc')->take(4)->get();
        // dd($productos);
        return view('welcome', compact('productos'));

    }
    public function Combinaciones (){
        $colores = ColorModel::all(); // Obtener todos los colores
        $tallas = TallaModel::all(); // Obtener todas las tallas
        $categorias = categoriamodel::all();
        return redirect()->back()->with(['mensaje' => 'combinacion creada exitosamente', 'tipo' => 'success', 'color' => 'verde']); // Redirigir a la vista de combinaciones con un mensaje de éxito
        // return view('tallas_colores_categorias.combinacion', compact('categorias', 'tallas', 'colores'));
    }
    public function Formulario()
    {
        if (Auth::user()->rol_id != 1) {
            return redirect()->route('index')->with(['mensaje' => 'No tienes permisos para acceder a esta sección.', 'tipo' => 'error', 'color' => 'rojo']);    
            
        }
        $colores = ColorModel::all(); // Obtener todos los colores
        $tallas = TallaModel::all(); // Obtener todas las tallas
        $categorias = categoriamodel::all();
        return view('productos.formulario', compact('categorias', 'tallas', 'colores'));
    }
    public function Guardar(Request $request)
    {
        $request->validate([ // Validación de los campos del formulario
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'precio' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'marca' => 'required|string|max:255',
            'imagen_url' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'variantes' => 'array', // Validar que variantes sea un array
            'variantes.*.talla_id' => 'required|exists:tallas,id', // Validar que cada variante tenga una talla válida
            'variantes.*.color_id' => 'required|exists:colores,id', // Validar que cada variante tenga un color válido
            'variantes.*.stock' => 'required|integer|min:0', // Validar que cada variante tenga un stock válido
        ]);


        $publicPath = null;

        if ($request->hasFile('imagen_url')) {
            // ✔️ Guarda en disco 'public', en la carpeta 'productos'
            $path = $request->file('imagen_url')->store('productos', 'public');
            $publicPath = Storage::url($path); // da: /storage/productos/archivo.jpg

            // dump("Ruta interna (real): " . storage_path("app/public/productos"));
            // dump("Archivo guardado: $path");
            // dump("Archivo existe: " . (Storage::disk('public')->exists($path) ? 'Sí' : 'No'));
        }

        $productos = Productosmodel::create([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'precio' => $request->input('precio'),
            'categoria_id' => $request->input('categoria_id'),
            'marca' => $request->input('marca'),
            'imagen_url' => $publicPath,
        ]);

        if ($productos) {
            $variantes = $request->input('variantes', []); // Obtener las variantes del request

            foreach ($variantes as $variante) { // Recorrer las variantes
                if (!empty($variante['talla_id']) && !empty($variante['color_id'])) { // Verificar que la talla y el color no estén vacíos
                    InventarioModel::create([ // Crear una nueva entrada en el inventario
                        'producto_id' => $productos->id, // Usar el ID del producto recién creado
                        'talla_id' => $variante['talla_id'], // Usar el ID de la talla de la variante
                        'color_id' => $variante['color_id'], // Usar el ID del color de la variante
                        'stock' => $variante['stock'] ?? 0, // Usar el stock de la variante, o 0 si no se proporciona
                    ]);
                }
            }
            return redirect()->route('productos.listar')->with('mensaje', 'Producto creado exitosamente.');
        } else {
            return redirect()->back()->with('error', 'Error al crear el producto.');
        }
    }

    public function Listar(){
        if (Auth::user()->rol_id != 1) {
            return redirect()->route('index')->with(['mensaje' => 'No tienes permisos para acceder a esta sección.', 'tipo' => 'error', 'color' => 'rojo']);    
            
        }
        // $productoss = Productosmodel::with(['inventario'])->get(); // 
        $productos = Productosmodel::with(['categoria', 'inventario.talla', 'inventario.color'])->get();

        return view('Productos.productos', compact('productos'));
    }
    public function Form_editar($id)
    {
        $producto = Productosmodel::with(['inventario.talla','inventario.color'])->findOrFail($id); // Busca el producto por ID y carga las relaciones de inventario, talla y color
        $inventario = InventarioModel::where('producto_id', $id)->get(); // Obtiene el inventario del producto por ID
        
        $stock = $inventario->sum('stock'); // Suma el stock de todas las variantes del producto
        // $tallasDisponibles = $inventario->pluck('talla.nombre')->unique(); // Obtiene las tallas disponibles del producto
        // $coloresDisponibles = $inventario->pluck('color.nombre')->unique(); // Obtiene los colores disponibles del producto
        $tallasDisponibles = TallaModel::all(); // Obtener todas las tallas
        $coloresDisponibles = ColorModel::all(); // Obtener todos los colores
        $categorias = categoriamodel::all(); // Obtener todas las categorías
        
        return view('productos.editar', compact('producto', 'inventario', 'stock', 'tallasDisponibles', 'coloresDisponibles', 'categorias'));
    }
    public function Actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'precio' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'marca' => 'required|string|max:255',
            'imagen_url' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'variantes' => 'nullable|array', // Validar que variantes sea un array
            'variantes.*.talla_id' => 'required|exists:tallas,id', // Validar que cada variante tenga una talla válida
            'variantes.*.color_id' => 'required|exists:colores,id', // Validar que cada variante tenga un color válido
            'variantes.*.stock' => 'required|integer|min:0', // Validar que cada variante tenga un stock válido
            
        ]);


        $producto = Productosmodel::findOrFail($id); // Buscar el producto por ID

        if (!$producto) {
            return redirect()->route('productos.listar')->with('mensaje', 'error');
        }

        $publicPath = $producto->imagen_url; // Mantener la imagen actual si no se sube una nueva

        if ($request->hasFile('imagen_url')) { // Verificar si se subió una nueva imagen
            // ✔️ Guarda en disco 'public', en la carpeta 'productos'
            $path = $request->file('imagen_url')->store('productos', 'public');
            $publicPath = Storage::url($path); // da: /storage/productos/archivo.jpg
        }

        $producto->update([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'precio' => $request->input('precio'),
            'categoria_id' => $request->input('categoria_id'),
            'marca' => $request->input('marca'),
            'imagen_url' => $publicPath,
        ]);

        // ✅ Actualizar las variantes del producto
        if ($request->has('variantes')) { // 
        foreach ($request->input('variantes') as $variante) {
            if (!empty($variante['id'])) {
                // Actualizar variante existente por ID
                $inventario = InventarioModel::find($variante['id']);
                if ($inventario) {
                    $inventario->update([
                        'talla_id' => $variante['talla_id'],
                        'color_id' => $variante['color_id'],
                        'stock' => $variante['stock'],
                    ]);
                }
            } else {
                // Buscar si ya existe la combinación
                $existente = InventarioModel::where('producto_id', $producto->id)
                    ->where('talla_id', $variante['talla_id'])
                    ->where('color_id', $variante['color_id'])
                    ->first();

                if ($existente) {
                    // ✅ Ya existe: actualizar stock (sumar)
                    // $existente->stock += $variante['stock'];
                    $existente->stock = $variante['stock'];
                    $existente->save();
                } else {
                    // ❌ No existe: crear nueva variante
                    InventarioModel::create([
                        'producto_id' => $producto->id,
                        'talla_id' => $variante['talla_id'],
                        'color_id' => $variante['color_id'],
                        'stock' => $variante['stock'],
                    ]);
                }
            }
        }
    }
        return redirect()->route('productos.listar')->with('mensaje', 'Producto actualizado correctamente.');
    }

    public function Eliminar($id)
    {
        $productos = Productosmodel::findOrFail($id);
        // dump($productos);

        if (!$productos) {
            return redirect()->route('productos.listar')->with('mensaje', 'error');
        }

        // elimino la foto del producto
        if ($productos->imagen_url) { // Verifico si existe una imagen asociada al producto
            $imagePath = str_replace('public/storage/', 'public/', $productos->imagen_url); // Reemplazo la ruta para que coincida con el disco 'public'
            if (Storage::disk('public')->exists($imagePath)) {// Verifico si el archivo existe en el disco 'public'
                Storage::disk('public')->delete($imagePath); // Elimino el archivo de imagen
            }
        }
        // dd($productos);
        // public/productos/RKnJIhoqHWlJSTlN0AasA7zruZaH0gNZvSLX3G4x.jpg"

        $productos->delete($id);
        return redirect()->route('productos.listar')->with('mensaje', 'usuario eliminado correctamente');
    }
}
