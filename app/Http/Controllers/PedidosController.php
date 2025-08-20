<?php

namespace App\Http\Controllers;

use App\Models\CarritoItemModel;
use App\Models\CarritoModel;
use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Models\UsuarioModel;
use App\Models\PedidoItemModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PedidosController extends Controller
{
    public function crearDesdeCarrito(Request $request)
    {
        // Verificar que el usuario esté logueado
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('mensaje', 'Debes iniciar sesión para comprar.')
                ->with('type', 'Danger');
        }

        $usuario_id = Auth::id();
        $direccion = UsuarioModel::where('id', $usuario_id)->value('direccion');

        // primero recupero el carrito del ususario 
        // 1. Obtener el carrito activo del usuario
        $carrito = CarritoModel::where('usuario_id', $usuario_id)
            ->where('activo', true)
            ->first();

        if (!$carrito) {
            return back()->with('mensaje', 'No tienes un carrito activo')->with('type', 'Danger');
        }

        // 2. Recuperar todos los items de ese carrito
        $carrito_items = CarritoItemModel::where('carrito_id', $carrito->id)->get();

        if ($carrito_items->isEmpty()) {
            return back()->with('mensaje', 'El carrito está vacío')->with('type', 'Danger');
        }

        DB::beginTransaction();
        try {
            // Crear el pedido
            $pedido = Pedido::create([
                'usuario_id' => $usuario_id,
                'fecha_pedido' => now(),
                'estado' => 'pendiente',
                'direccion_envio' => $direccion ?? 'Sin especificar',
                'metodo_pago' => 'paypal',
                'total' => $carrito_items->sum(fn($item) => $item->cantidad * $item->precio_unitario),
            ]);

            // Crear ítems del pedido (ahora sí todos los productos)
            foreach ($carrito_items as $item) {
                PedidoItemModel::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $item->producto_id,
                    'talla_id' => $item->talla_id,
                    'color_id' => $item->color_id,
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->precio_unitario,
                ]);
            }

            // Marcar carrito como cerrado / inactivo
            $carrito->update(['activo' => false, 'estado' => 'comprado']);

            DB::commit();

            return view('checkout.paypal', [
                'pedidoId' => $pedido->id,
                'total' => $pedido->total,
                'usuario_id' => $usuario_id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('mensaje', 'Error: ' . $e->getMessage())->with('type', 'Danger');
        }
    }
    public function pagado(Request $request)
    {
        // Aquí puedes manejar la lógica de lo que sucede cuando el pago es exitoso
        // Por ejemplo, actualizar el estado del pedido a 'pagado'
        $pedido = Pedido::find($request->pedido_id);
        if ($pedido) {
            $pedido->estado = 'pagado';
            $pedido->save();
            return response()->json(['mensaje' => 'Pago procesado correctamente.'], 200, ['success' => true]);
        }
        return response()->json(['mensaje' => 'Pedido no encontrado.'], 404);
    }
}
