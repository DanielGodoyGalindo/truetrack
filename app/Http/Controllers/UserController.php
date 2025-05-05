<?php

namespace App\Http\Controllers;

use App\Models\Envio;
use App\Models\Reparto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // variables globales privadas 
    private $elementosPaginacion = 5;
    private $roles = ['cliente', 'gestor_trafico', 'transportista', 'administrador'];

    /**
     * Listar todos los usuarios.
     */
    public function index()
    {
        // Obtener todos los usuarios excepto el administrador autenticado
        $usuarios = User::where('id', '!=', Auth::user()->id)->paginate($this->elementosPaginacion);
        return view('usuarios.all', compact('usuarios'));
    }

    /**
     * Muestra el formulario para crear un usuario.
     */
    public function create()
    {
        $usuario = null;
        return view('usuarios.form', ['usuario' => $usuario, 'roles' => $this->roles]);
    }

    /**
     * Guardar un nuevo usuario.
     */
    public function store(Request $request)
    {
        // Evitar que aparezca error de violación de integridad (no se puede guardar dos veces el mismo email)
        $request->validate([
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'nombre' => ['required', 'string', 'regex:/^[\pL\s]{3,}$/'],
            'password' => 'required|string|min:8',
            'rol' => ['required', 'string']
        ]);

        $usuario = new User();
        $usuario->name = $request->nombre;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->rol = $request->rol;
        $usuario->save();
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Muestra el formulario para editar al usuario.
     */
    public function edit(string $id)
    {
        $usuario = User::findOrFail($id);
        return view('usuarios.form', ['usuario' => $usuario, 'roles' => $this->roles]);
    }

    /**
     * Actualiza el usuario cuyo id se indica como parámetro.
     */
    public function update(Request $request, string $id)
    {
        // Validar que el email no exista ya en la base de datos
        // Se ignora el usuario actual para que deje modificar sus datos
        // Sino, encuentra el email y no deja actualizar
        $usuario = User::findOrFail($id);
        $request->validate([
            'email' => [
                'required',
                'string',
                'regex:/^[\w\.-]+@[\w\.-]+\.\w{2,}$/',
                Rule::unique('users', 'email')->ignore($usuario->id),
            ],
            'nombre' => ['required', 'string', 'regex:/^[\pL\s]{3,}$/'],
            'rol' => ['required', 'string']
        ]);

        $usuario = User::findOrFail($id);
        $usuario->name = $request->nombre;
        $usuario->email = $request->email;
        // $usuario->password = $request->password;
        $usuario->rol = $request->rol;
        $usuario->save();
        return redirect()->route('users.index');
    }

    /**
     * Borrar el usuario cuyo id se indica como parámetro.
     */
    public function destroy(string $id)
    {
        $usuario = User::findOrFail($id);
        switch ($usuario->rol) {
            // Solo borrar a un gestor si no tiene creado ningun reparto
            case 'gestor_trafico':
                $numRepartos = Reparto::where('gestor_id', $usuario->id)->count();
                if ($numRepartos == 0) {
                    $usuario->delete();
                } else {
                    return redirect()->route('users.index')->with('message', 'gestorNotDeleted');
                }
                break;
            // Solo borrar a un transportista si no tiene asignado algun reparto
            case 'transportista':
                $numRepartos = Reparto::where('transportista_id', $usuario->id)->count();
                if ($numRepartos == 0) {
                    $usuario->delete();
                } else {
                    return redirect()->route('users.index')->with('message', 'transportistaNotDeleted');
                }
                break;
            default: // Borrar clientes (se borran tambien sus envíos) / administradores
                $usuario->delete();
        }
        return redirect()->route('users.index')->with('message', 'userDeleted');
    }

    // Obtener los repartos asignados a un transportista
    // Se ejecuta cuando un transportista se loguea
    public function driverDistributions(string $idTransportista)
    {
        $repartos = Reparto::where('transportista_id', $idTransportista)
            ->whereNotIn('estado', ['finalizado'])
            ->get();
        $transportista = User::findOrFail($idTransportista);
        return view('transportistas.myDistributions', compact('repartos', 'transportista'));
    }

    // Obtener los envíos de un reparto
    // Se ejecuta cuando un transportista selecciona uno de sus repartos
    public function driverDeliveries(string $repartoId)
    {
        $reparto = Reparto::findOrFail($repartoId);
        $envios = Envio::where('reparto_id', $repartoId)->get();
        $estados = ['en reparto', 'entregado', 'no entregado'];
        $enviosPendientes = Envio::where([
            ['estado', 'en reparto'],
            ['reparto_id', $repartoId]
        ])->count(); // envios que han sido entregados o marcados como no entregados
        $numEnvios = $envios->count();
        return view('transportistas.deliveries', compact('reparto', 'envios', 'estados', 'enviosPendientes', 'numEnvios'));
    }

    // Actualiza el estado de los envíos de un reparto para un transportista
    // Se ejecuta cuando un transportista actualiza el estado de los envíos dentro de un reparto
    public function updateDriverDistribution(string $repartoId, Request $r)
    {
        foreach ($r->input('envios') as $envioId => $estado) {
            $envio = Envio::findOrFail($envioId);
            $envio->estado = $estado;
            $envio->save();
        }
        return redirect()->route('driver.deliveries', $repartoId)->with('success', 'Estados actualizados correctamente');
    }

    // Actualiza el estado de un reparto a finalizado
    public function driverCompleteDistribution(string $repartoId)
    {
        $reparto = Reparto::findOrFail($repartoId);
        $reparto->estado = 'finalizado';
        $reparto->save();
        return redirect()->route('driver.distributions', $reparto->transportista_id);
    }
}
