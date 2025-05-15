<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsuarioModel;
use App\Models\Rolmodel;

class UsuariosController extends Controller
{
    //
    public function index()
    {
        return view('index');
    }
    public function Form_html(){
        $usuario = UsuarioModel::all();
        $ciudades = ['Bogotá', 'Medellín', 'Cali', 'Barranquilla', 'Cartagena'];
        $roles = Rolmodel::all();
        
        return view('usuarios.formulario', compact('roles','usuario', 'ciudades')); // Pasar los roles a la vista
    }

    public function Registrar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'ciudad' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'rol' => 'required|exists:roles,id',
        ]);

        $usuario = new UsuarioModel();
        $usuario->nombre = $request->input('nombre');
        $usuario->apellido = $request->input('apellidos');
        // $usuario->password = Hash::make($request->input('password')); // Encriptar la contraseña
        $usuario->password = bcrypt($request->input('password')); // Encriptar la contraseña
        $usuario->direccion = $request->input('direccion');
        $usuario->telefono = $request->input('telefono');
        $usuario->ciudad = $request->input('ciudad');
        $usuario->email = $request->input('email');
        $usuario->rol_id = $request->input('rol');
        // dump("nombre: ".$usuario->nombre, "password: ".$usuario->password, "direccion: ".$usuario->direccion, "telefono: ".$usuario->telefono, "ciudad: ".$usuario->ciudad, "email: ".$usuario->email, "rol_id: ".$usuario->rol_id);
        // $usuario->password = Hash::make($request->input('password')); // Encriptar la contraseña
        $usuario->save();
        if ($usuario->save()) {
        return redirect()->route('usuarios.listar')->with(['mensaje' => 'Usuario registrado exitosamente.', 'tipo' => 'success', 'color' => 'verde']);
        }
        else {
            return redirect()->back()->with(['mensaje' => 'Error al registrar el usuario.', 'tipo' => 'error', 'color' => 'rojo']);
        }

    }
    public function Listar()
    {
        $usuarios = UsuarioModel::all();
        $roles = Rolmodel::all();
        $ciudades = ['Bogotá', 'Medellín', 'Cali', 'Barranquilla', 'Cartagena'];

        // $usuarios = UsuarioModel::with('rol')->where('rol_id', 1)->get(); // Filtrar por rol_id
        
        return view('usuarios.usuarios', compact('usuarios', 'roles','ciudades')); // Pasar los usuarios y los roles a la vista
    }
    public function Editar($id)
    {
        $usuario = UsuarioModel::findOrFail($id); // Buscar el usuario por ID
        // Verificar si el usuario existe
        if (!$usuario) {
            return redirect()->route('usuarios.listar')->with(['mensaje' => 'Usuario no encontrado.', 'tipo' => 'error', 'color' => 'rojo']);
        }
        // Obtener todos los roles
        $roles = Rolmodel::all();
        return view('usuarios.editar', compact('usuario', 'roles')); // Pasar el usuario y los roles a la vista
    }
    public function Actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'ciudad' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $id,
            'rol' => 'required|exists:roles,id',
        ]);

        $usuario = UsuarioModel::findOrFail($id); // Buscar el usuario por ID
        // Verificar si el usuario existe
        if (!$usuario) {
            return redirect()->route('usuarios.listar')->with(['mensaje' => 'Usuario no encontrado.', 'tipo' => 'error', 'color' => 'rojo']);
        }
        $usuario->nombre = $request->input('nombre');
        $usuario->apellido = $request->input('apellidos');
        if ($request->input('password')) {
            $usuario->password = bcrypt($request->input('password')); // Encriptar la contraseña
        }
        $usuario->direccion = $request->input('direccion');
        $usuario->telefono = $request->input('telefono');
        $usuario->ciudad = $request->input('ciudad');
        $usuario->email = $request->input('email');
        $usuario->rol_id = $request->input('rol');

        if ($usuario->save()) {
            return redirect()->route('usuarios.listar')->with(['mensaje' => 'Usuario actualizado exitosamente.', 'tipo' => 'success', 'color' => 'verde']);
        } else {
            return redirect()->back()->with(['mensaje' => 'Error al actualizar el usuario.', 'tipo' => 'error', 'color' => 'rojo']);
        }
    }
    public function Eliminar($id)
    {
        $usuario = UsuarioModel::findOrFail($id); // Buscar el usuario por ID
        // Verificar si el usuario existe
        if (!$usuario) {
            return redirect()->route('usuarios.listar')->with(['mensaje' => 'Usuario no encontrado.', 'tipo' => 'error', 'color' => 'rojo']);
        }
        $usuario->delete(); // Eliminar el usuario
        return redirect()->route('usuarios.listar')->with(['mensaje' => 'Usuario eliminado exitosamente.', 'tipo' => 'success', 'color' => 'verde']);
    }
}
