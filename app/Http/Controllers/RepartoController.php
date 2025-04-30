<?php

namespace App\Http\Controllers;

use App\Models\Envio;
use App\Models\Reparto;
use App\Models\User;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepartoController extends Controller
{
    private $numPag = 5;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $repartos  = Reparto::with('gestor', 'transportista', 'vehiculo')->paginate($this->numPag);
        // return view('repartos.all', ['repartos' => $repartos]);

        // Obtener repartos para el gestor autenticado
        $repartosGestor  = Reparto::with('gestor', 'transportista', 'vehiculo')
            ->where('gestor_id', Auth::id())
            ->whereNotIn('estado', ['finalizado'])
            ->paginate($this->numPag);
        //Obtener repartos para el admin
        $repartosAdmin  = Reparto::with('gestor', 'transportista', 'vehiculo')
            ->paginate($this->numPag);
        return view('repartos.all', ['repartosGestor' => $repartosGestor, 'repartosAdmin' => $repartosAdmin]);
    }

    /**
     * Muestra el formulario para crear un nuevo reparto
     */
    public function create()
    {
        if (Auth::user()->rol !== 'gestor_trafico') {
            abort(403, 'No tienes permiso para acceder');
        }
        /* Obtener los transportistas y vehiculos para el formulario de creación de reparto */
        $transportistas = User::where('rol', 'transportista')->pluck('name');
        // Pluck() obtiene sólo los valores del campo indicado como parámetro
        $vehiculos = Vehiculo::all()->pluck('matricula');
        $reparto = null;
        return view('repartos.form', compact('transportistas', 'vehiculos', 'reparto'));
    }

    /**
     * Guarda un nuevo reparto
     */
    public function store(Request $r)
    {
        if (Auth::user()->rol !== 'gestor_trafico') {
            abort(403, 'No tienes permiso para acceder');
        }
        // dd($r->all()); // Obtener todos los datos del request
        $reparto = new Reparto();
        // Obtener el id del usuario autenticado
        $reparto->gestor_id = Auth::user()->id ?? 1;
        // Obtener el id del usuario (transportista) cuyo nombre es el recuperado en el request
        $reparto->transportista_id = User::where('name', $r->transportista)->value('id');
        // $reparto->vehiculo_id = $r->vehiculo;
        // Obtener el id del vehiculo cuyo matricula ha sido capturada en el request
        $reparto->vehiculo_id = Vehiculo::where('matricula', $r->vehiculo)->value('id');
        $reparto->estado = "en proceso";
        $reparto->save();
        return redirect()->route('repartos.index');
    }

    /**
     * Muestra el reparto (finalizado) y todos sus envíos
     */
    public function show(string $id)
    {
        // Obtener reparto y sus envíos
        $reparto = Reparto::findOrFail($id);
        $envios = Envio::where('reparto_id', $id)->paginate($this->numPag);
        // Calculo envios entregados
        $enviosTotales = $envios->total();
        $entregados = Envio::where('reparto_id', $id)->where('estado', 'entregado')->count();
        return view('repartos.completedInfo', compact('reparto', 'envios', 'entregados', 'enviosTotales'));
    }

    /**
     * Muestra el formulario para editar un reparto.
     */
    public function edit(string $id)
    {
        if (Auth::user()->rol !== 'gestor_trafico') {
            abort(403, 'No tienes permiso para acceder');
        }
        $reparto = Reparto::with('transportista', 'vehiculo')->findOrFail($id);
        $transportistas = User::where('rol', 'transportista')->pluck('name');
        $vehiculos = Vehiculo::all()->pluck('matricula');
        return view('repartos.form', compact('reparto', 'transportistas', 'vehiculos'));
    }

    /**
     * Actualizar el reparto cuyo id se pasa como parámetro.
     */
    public function update(Request $r, string $id)
    {
        if (Auth::user()->rol !== 'gestor_trafico') {
            abort(403, 'No tienes permiso para acceder');
        }
        // Validación
        $r->validate([
            'transportista' => ['required', 'string'],
            'vehiculo' => ['required', 'string'],
        ]);
        // Actualización
        $reparto = Reparto::findOrFail($id);
        $reparto->transportista_id = User::where('name', $r->transportista)->firstOrFail()->id;
        $reparto->vehiculo_id = Vehiculo::where('matricula', $r->vehiculo)->firstOrFail()->id;
        $reparto->save();
        return redirect()->route('repartos.index');
    }

    /**
     * Borrar el reparto con id que se indica como parámetro.
     */
    public function destroy(string $repartoId)
    {
        if (Auth::user()->rol !== 'administrador') {
            abort(403, 'No tienes permiso para acceder');
        }
        // Borrar reparto sólo si no tiene envíos asignados
        $numEnvios = Envio::where('reparto_id', $repartoId)->count();
        if ($numEnvios == 0) {
            $reparto = Reparto::findOrFail($repartoId);
            $reparto->delete();
            return redirect()->route('repartos.index')->with('message', 'deliveryDeleted');
        } else {
            return redirect()->route('repartos.index')->with('message', 'deliveryNotDeleted');
        }
        // Modificar estado de envios del reparto
        // $envios = Envio::where('reparto_id', $repartoId)->get();
        // foreach ($envios as $envio) {
        //     if ($envio->estado != 'entregado') {
        //         $envio->estado = 'pendiente';
        //         $envio->save();
        //     }
        // }
        // Eliminar reparto
        // $reparto = Reparto::findOrFail($repartoId);
        // $reparto->delete();
        // return redirect()->route('repartos.index');
    }

    /**
     * Método para mostrar la vista de añadir envios a un reparto (repartos.deliveries) (dos tablas: una con envios para asignar y otra con envios que se van asignando)
     */
    public function addDeliveries(string $id)
    {
        $reparto = Reparto::findOrFail($id);
        $enviosPendientes = Envio::whereNotIn('estado', ['entregado', 'anulado', 'en reparto'])->paginate($this->numPag);
        $enviosAsignados = Envio::where('reparto_id', $id)->get();
        $kilosCargados = $reparto->envios->sum('kilos');
        return view('repartos.deliveries', compact('reparto', 'enviosPendientes', 'enviosAsignados', 'kilosCargados'));
    }

    /**
     * Método para actualizar un envio que ha sido asignado en un reparto
     */
    public function assignDelivery(Request $request, string $repartoId)
    {
        //// Controlar peso
        $reparto = Reparto::findOrFail($repartoId);
        $pesoTotalReparto = $reparto->envios->sum('kilos');
        $envio = Envio::findOrFail($request->envio_id);
        // Si se supera la carga máxima, no permitir
        if (($pesoTotalReparto + $envio->kilos) > $reparto->vehiculo->carga_max) {
            return redirect()->route('repartos.showDeliveries', $repartoId)->with('message', 'deliveryNotAdded');
        }
        // Sino, se asigna el envío correctamente
        $envio->reparto_id = $repartoId;
        $envio->estado = 'en reparto';
        $envio->save();
        return redirect()->route('repartos.showDeliveries', $repartoId)->with('message', 'deliveryAdded');
    }

    /** 
     * Método para mostrar los envios asignados a un reparto y pendientes en la vista de asignación de repartos
     */
    public function showDeliveries(string $id)
    {
        $reparto = Reparto::findOrFail($id);
        $enviosPendientes = Envio::whereNotIn('estado', ['entregado', 'anulado', 'en reparto'])->paginate($this->numPag);
        $enviosAsignados = Envio::where('reparto_id', $id)->get();
        $kilosCargados = $enviosAsignados->sum('kilos');
        // Compact() permite pasar datos a la vista de una manera más reducida (sólo se nombra la variable)
        return view('repartos.deliveries', compact('reparto', 'enviosPendientes', 'enviosAsignados', 'kilosCargados'));
    }

    /** 
     * Método para sacar del reparto los envios ya asignados
     */
    public function removeFromDelivery(Request $request, string $repartoId)
    {
        $envio = Envio::findOrFail($request->envio_id);
        $envio->reparto_id = null;
        $envio->estado = 'pendiente';
        $envio->save();
        return redirect()->route('repartos.showDeliveries', $repartoId)->with('message', 'deliveryRemoved');
    }

    /**
     * Método para mostrar repartos finalizados
     */
    public function showDeliveriesCompleted()
    {
        $finalizados = Reparto::where('gestor_id', Auth::id())->where('estado', 'finalizado')->paginate($this->numPag);
        return view('repartos.completed', ['finalizados' => $finalizados]);
    }

    // Mostrar todos los envíos con estado 'no entregado' en un reparto de un transportista
    // Se ejecuta cuando un transportista que tiene envios no entregados accede a la seccion 'Información no entregados'
    // para que añada la información de cada envio fallido
    // public function showFailedDeliveries(string $repartoId)
    // {
    //     $enviosFallidos = Envio::where([['reparto_id', $repartoId], ['estado', 'no entregado']])->get();
    //     $reparto = Reparto::findOrFail($repartoId);
    //     return view('transportistas.failedDeliveries', compact('enviosFallidos', 'reparto'));
    // }

    // Actualiza la información de los envíos que han sido marcados como no entregados
    // Se ejecuta cuando un transportista ha entrado en los envíos no entregados de su reparto
    // y selecciona "Guardar detalles envíos fallidos"
    // public function updateFailedDeliveries(Request $r, string $repartoId)
    // {
    //     $info = $r->input('info');
    //     foreach ($info as $envioId => $informacion) {
    //         $envio = Envio::findOrFail($envioId);
    //         $envio->informacion = $informacion;
    //         $envio->save();
    //     }
    //     return redirect()
    //         ->route('driver.deliveries', $repartoId)
    //         ->with('success', '¡Comentarios guardados!');
    // }
}
