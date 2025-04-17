<?php

namespace App\Http\Controllers;

use App\Models\Envio;
use App\Models\Reparto;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function destroy(string $id)
    {
        //
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

    public function driverCompleteDistribution(string $repartoId)
    {
        $reparto = Reparto::findOrFail($repartoId);
        $reparto->estado = 'finalizado';
        $reparto->save();
        return redirect()->route('driver.distributions', $reparto->transportista_id);
    }
}
