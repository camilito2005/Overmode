<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productosmodel;
use App\Models\categoriamodel;
use App\Models\TallaModel;
use App\Models\ColorModel;
use App\Models\Pedido;
use App\Models\CarritoModel;
use App\Models\CarritoItemModel;
use App\Models\InventarioModel;
use Illuminate\Support\Facades\Auth;

class CarritoControllers extends Controller
{
    public function AggCarrito(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'talla_id' => 'required|exists:tallas,id',
            'color_id' => 'required|exists:colores,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto_id = $request->input('producto_id');
        $talla_id = $request->input('talla_id');
        $color_id = $request->input('color_id');
        $cantidad = $request->input('cantidad');


        $stockDisponible = InventarioModel::where('producto_id', $producto_id)
            ->where('talla_id', $talla_id)
            ->where('color_id', $color_id)
            ->value('stock'); // Obtiene el stock disponible para la combinación de producto, talla y color

        if ($stockDisponible < $cantidad) {
            return back()->with(['mensaje'=> 'No hay suficiente stock disponible.']);
        }

        $precio = Productosmodel::findOrFail($producto_id)->precio;

        if (Auth::check()) {
            $usuario_id = Auth::user()->id;

            // Verificar si el usuario ya tiene un carrito activo
            $carrito = CarritoModel::firstOrCreate(
                ['usuario_id' => $usuario_id, 'activo' => true, 'estado' => 'activo'],
                ['activo' => true, 'estado' => 'activo', 'created_at' => now(), 'updated_at' => now()]
            );

            // Verificar si el item ya existe en el carrito
            $item = CarritoItemModel::where('carrito_id', $carrito->id)
                ->where('producto_id', $producto_id)
                ->where('talla_id', $talla_id)
                ->where('color_id', $color_id)
                ->first();


            if ($item) {
                $nuevaCantidad = $item->cantidad + $cantidad; // 

                if ($nuevaCantidad > $stockDisponible) {
                    return back()->with('error', 'No hay suficiente stock disponible para agregar más unidades.');
                }

                $item->cantidad = $nuevaCantidad;
                $item->subtotal = $nuevaCantidad * $precio; // Actualizar el subtotal si es necesario
                // $item->precio = $precio; // Actualizar el precio si es necesario
                $item->save();
            } else {
                $carrito = CarritoItemModel::create([
                    'carrito_id' => $carrito->id,
                    'producto_id' => $producto_id,
                    'talla_id' => $talla_id,
                    'color_id' => $color_id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precio, // Guardar el precio unitario del producto
                    'subtotal' => $cantidad * $precio, // Calcular el subtotal
                ]);
            }
            return redirect()->back()->with('mensaje', 'Producto agregado al carrito correctamente.');
        }
        return response()->json(['localStorage' => 'Producto agregado al carrito correctamente.'], 200);
    }
    public function VerCarrito()
    {
        if (Auth::check()) {

            $usuario_id = Auth::user()->id;
            $carrito = CarritoModel::where('usuario_id', $usuario_id)
                ->where('activo', true)
                ->with('items.producto', 'items.talla', 'items.color')
                ->first();



            $total = $carrito ? $carrito->items->sum('subtotal') : 0;
            if ($carrito) { // verifica si el carrito existe
                $itemprocesados = $carrito->items->map(function ($item) {
                    return [
                        'item_id' => $item->id,// 
                        'producto_id' => $item->producto->id,
                        'nombre' => $item->producto->nombre,
                        'descripcion' => $item->producto->descripcion,
                        'precio' => $item->precio_unitario,
                        'cantidad' => $item->cantidad,
                        'imagen_url' => $item->producto->imagen_url,
                        'talla' => $item->talla->nombre ?? 'N/A',
                        'color' => $item->color->nombre ?? 'N/A',
                        'subtotal' => $item->subtotal,
                    ];
                });
                return view('carrito.carrito', [
                    'carrito' => $itemprocesados, // esto sí es iterable
                    'total' => $total
                ]);
            } else {
                $itemprocesados = [];
                // Si no hay carrito, retornar una colección vacía
                return view('carrito.carrito', [
                    'carrito' => $itemprocesados, // colección vacía si no hay carrito
                    'total' => 0
                ]);
            }
        } else {
            $itemprocesados = [];
            return view('carrito.carrito', [
                'carrito' => $itemprocesados, // también colección vacía si no hay sesión
                'total' => 0
            ]);
        }
    }
    public function EliminarItem($itemId)
    {

        if (Auth::check()) {
            $usuario_id = Auth::user()->id;

            // Buscar el carrito activo del usuario
            $carrito = CarritoModel::where('usuario_id', $usuario_id)
                ->where('activo', true)
                ->first();

            if ($carrito) {
                dump($carrito);
                // Buscar el ítem dentro del carrito
                // $item = $carrito->items()->find($itemId); //  Aquí se busca el ítem por su ID
                // Alternativamente, puedes usar:
                $item = CarritoItemModel::where('id', $itemId) //
                    ->where('carrito_id', $carrito->id)
                    ->first(); // Asegurarse de que el ítem pertenece al carrito del usuario
                   

                if ($item) {
                    $item->delete(); // Eliminar el ítem

                    // Verificar si el carrito quedó vacío después de la eliminación
                    if ($carrito->items()->count() === 0) {
                        $carrito->activo = false;
                        $carrito->estado = 'inactivo'; // Si usas campo "estado"
                        $carrito->save();
                    }

                    return redirect()->back()->with('mensaje', 'Item eliminado del carrito correctamente.');
                } else {
                    return redirect()->back()->with('mensaje', 'El item no existe en el carrito.');
                }
            } else {
                return redirect()->back()->with('mensaje', 'No se encontró el carrito del usuario.');
            }
        }

        return redirect()->back()->with('mensaje', 'No se pudo eliminar el item del carrito.');
    }
    public function VaciarCarrito()
    {
        if (Auth::check()) {
            $usuario_id = Auth::user()->id;

            // Buscar el carrito activo del usuario
            $carrito = CarritoModel::where('usuario_id', $usuario_id)
                ->where('activo', true)
                ->first();

            if ($carrito) {
                // Eliminar todos los ítems del carrito
                $carrito->items()->delete();

                // Marcar el carrito como inactivo ya que está vacío
                $carrito->activo = false;
                $carrito->estado = 'inactivo'; // Si tienes campo estado
                $carrito->save();

                // return redirect()->back()->with('success', 'Carrito vaciado correctamente.');
                return redirect()->route('catalogo')->with('mensaje', 'Carrito vaciado correctamente.');
            }
        }

        return redirect()->back()->with('error', 'No se pudo vaciar el carrito.');
    }
    public function ActualizarCarrito(Request $request)
    {
        if (Auth::check()) {
            $usuario_id = Auth::user()->id; // Obtiene el ID del usuario autenticado
            $carrito = CarritoModel::where('usuario_id', $usuario_id) // Busca el carrito del usuario autenticado
                ->where('activo', true)
                ->first();

            dd($request->input('items'));
            $items = $request->input('items'); // Obtiene los items del carrito desde la solicitud

            if ($carrito) { // Verifica si el carrito existe
                foreach ($request->input('items', []) as $itemData) { // 'items' es un array de datos de los items
                    $item = $carrito->items()->find($itemData['id']); // Busca el item en el carrito por su ID
                    dd("item : " . $item);
                    if ($item) { // Verifica si el item existe en el carrito

                        $stockDisponible = InventarioModel::where('producto_id', $item->producto_id)
                            ->where('talla_id', $item->talla_id)
                            ->where('color_id', $item->color_id)
                            ->value('stock'); // Obtiene el stock disponible para la combinación de producto, talla y color
                        dd("stockDisponible : " . $stockDisponible);

                        if ($itemData['cantidad'] > $stockDisponible) { // Verifica si la cantidad solicitada es mayor que el stock disponible
                            return redirect()->back()->with('mensaje', 'No hay suficiente stock para actualizar el producto "' . $item->producto->nombre . '"');
                        }
                        if ($itemData['cantidad'] < 1) { // Verifica si la cantidad es menor que 1
                            return redirect()->back()->with('mensaje', 'La cantidad debe ser al menos 1 para el producto "' . $item->producto->nombre . '"');
                        }


                        $item->cantidad = $itemData['cantidad']; // Actualiza la cantidad del item

                        $item->subtotal = $item->cantidad * $item->precio_unitario; // Actualiza el subtotal del item

                        dd("item->subtotal : " . $item->subtotal);
                        dd("item->cantidad : " . $item->cantidad);

                        $item->save(); // Guarda los cambios en el item
                    }
                }
                return redirect()->back()->with('mensaje', 'Carrito actualizado correctamente.');
            } else {
                return redirect()->back()->with('mensaje', 'No se encontró el carrito del usuario.');
            }
        }
        return redirect()->back()->with('mensaje', 'No se pudo actualizar el carrito.');
    }

    public function Sincronizar(Request $request)
    {
        if (Auth::check()) {

            $items = $request->input('items');
            $usuario_id = Auth::user()->id;

            $carrito = CarritoModel::firstOrCreate([
                'usuario_id' => $usuario_id,
                'activo' => true,
                'estado' => 'activo'
            ]);

            foreach ($items as $item) {
                $existente = CarritoItemModel::where('carrito_id', $carrito->id)
                    ->where('producto_id', $item['producto_id'])
                    ->where('talla_id', $item['talla_id'])
                    ->where('color_id', $item['color_id'])
                    ->first();

                if ($existente) {
                    $existente->cantidad += $item['cantidad'];
                    $existente->subtotal = $existente->cantidad * $existente->precio_unitario;
                    $existente->save();
                } else {
                    $precio = Productosmodel::findOrFail($item['producto_id'])->precio;
                    CarritoItemModel::create([
                        'carrito_id' => $carrito->id,
                        'producto_id' => $item['producto_id'],
                        'talla_id' => $item['talla_id'],
                        'color_id' => $item['color_id'],
                        'cantidad' => $item['cantidad'],
                        'precio_unitario' => $precio,
                        'subtotal' => $precio * $item['cantidad']
                    ]);
                }
            }

            return response()->json(['mensaje' => 'Carrito sincronizado correctamente']);
        } else {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }
    }
}
