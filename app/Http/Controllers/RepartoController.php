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

        // ->where('gestor_id', Auth::id())

        $repartosGestor  = Reparto::with('gestor', 'transportista', 'vehiculo')
            ->where('gestor_id', Auth::id())
            ->whereNotIn('estado', ['finalizado'])
            ->paginate($this->numPag);
        $repartosAdmin  = Reparto::with('gestor', 'transportista', 'vehiculo')
            ->paginate($this->numPag);
        return view('repartos.all', ['repartosGestor' => $repartosGestor, 'repartosAdmin' => $repartosAdmin]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /* Obtener los transportistas y vehiculos para el formulario de creación de reparto */
        $transportistas = User::where('rol', 'transportista')->pluck('name');
        $vehiculos = Vehiculo::all()->pluck('matricula');
        return view('repartos.form', ['transportistas' => $transportistas, 'vehiculos' => $vehiculos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        // dd($r->all()); // Obtener todos los datos del request
        $reparto = new Reparto();
        // Obtener el id del usuario autenticado
        $reparto->gestor_id = Auth::user()->id ?? 1;
        // Obtener el id del usuario (transportista) cuyo nombre es el recuperado en el request
        $reparto->transportista_id = User::where('name', $r->transportista)->value('id');
        $reparto->vehiculo_id = $r->vehiculo;
        // Obtener el id del vehiculo cuyo matricula ha sido capturada en el request
        $reparto->vehiculo_id = Vehiculo::where('matricula', $r->vehiculo)->value('id');
        $reparto->estado = "en proceso";
        $reparto->save();
        return redirect()->route('repartos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $repartoId)
    {
        // Modificar estado de envios del reparto
        $envios = Envio::where('reparto_id', $repartoId)->get();
        foreach ($envios as $envio) {
            if ($envio->estado != 'entregado') {
                $envio->estado = 'pendiente';
                $envio->save();
            }
        }
        // Eliminar reparto
        $reparto = Reparto::findOrFail($repartoId);
        $reparto->delete();
        return redirect()->route('repartos.index');
    }

    // Método para mostrar la vista de añadir envios a un reparto (repartos.deliveries) (dos tablas: una con envios para asignar y otra con envios que se van asignando)
    public function addDeliveries(string $id)
    {
        $reparto = Reparto::find($id);
        $enviosPendientes = Envio::whereNotIn('estado', ['entregado', 'anulado', 'en reparto'])->get();
        $enviosAsignados = Envio::where('reparto_id', $id)->get();
        return view('repartos.deliveries', ['reparto' => $reparto, 'enviosPendientes' => $enviosPendientes, 'enviosAsignados' => $enviosAsignados]);
    }

    // Método para actualizar un envio que ha sido asignado en un reparto
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

    // Método para actualizar los envios asignados a un reparto en la vista de asignación de repartos
    public function showDeliveries(string $id)
    {
        $reparto = Reparto::findOrFail($id);
        $enviosPendientes = Envio::whereNotIn('estado', ['entregado', 'anulado', 'en reparto'])->get();
        $enviosAsignados = Envio::where('reparto_id', $id)->get();
        $kilosCargados = $enviosAsignados->sum('kilos');
        // Compact() permite pasar datos a la vista de una manera más reducida (sólo se nombra la variable)
        return view('repartos.deliveries', compact('reparto', 'enviosPendientes', 'enviosAsignados', 'kilosCargados'));
    }

    // Método para sacar del reparto los envios ya asignados
    public function removeFromDelivery(Request $request, string $repartoId)
    {
        $envio = Envio::findOrFail($request->envio_id);
        $envio->reparto_id = null;
        $envio->estado = 'pendiente';
        $envio->save();
        return redirect()->route('repartos.showDeliveries', $repartoId)->with('message', 'deliveryRemoved');
    }


    // Método para mostrar repartos finalizados
    public function showDeliveriesCompleted()
    {
        $finalizados = Reparto::where('gestor_id', Auth::id())->where('estado', 'finalizado')->paginate($this->numPag);
        return view('repartos.completed', ['finalizados' => $finalizados]);
    }
}
