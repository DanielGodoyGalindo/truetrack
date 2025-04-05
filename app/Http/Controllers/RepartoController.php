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
        $repartos  = Reparto::with('gestor', 'transportista', 'vehiculo')->paginate($this->numPag);
        return view('repartos.all', ['repartos' => $repartos]);
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
    public function destroy(string $id)
    {
        $reparto = Reparto::find($id);
        $reparto->delete();
        return redirect()->route('repartos.index');
    }

    public function addDeliveries(string $id)
    {
        $reparto = Reparto::find($id);
        $envios = Envio::whereNotIn('estado', ['entregado', 'anulado']);
        return view('repartos.deliveries', ['reparto' => $reparto, 'envios' => $envios]);
    }
}
