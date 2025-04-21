<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VehiculoController extends Controller
{

    private $elementosPaginacion = 5;
    private $cargasMax = ['500', '600', '700', '800', '900', '1000'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehiculos = Vehiculo::paginate($this->elementosPaginacion);
        return view('vehiculos.all', compact('vehiculos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehiculo = null;
        return view('vehiculos.form', ['vehiculo' => $vehiculo, 'cargasMax' => $this->cargasMax]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Evitar que aparezca error de violación de integridad (no se puede guardar dos veces la misma matrícula)
        $request->validate([
            'matricula' => 'required|string|size:7|regex:/^\d{4}[A-Z]{3}$/|unique:vehiculos,matricula',
            'cargaMax' => 'required',
        ]);

        $vehiculo = new Vehiculo();
        $vehiculo->matricula = $request->matricula;
        $vehiculo->carga_max = $request->cargaMax;
        $vehiculo->save();
        return redirect()->route('vehiculos.index');
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
        $vehiculo = Vehiculo::findOrFail($id);
        return view('vehiculos.form', ['vehiculo' => $vehiculo, 'cargasMax' => $this->cargasMax]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar que la matrícula no exista ya en la base de datos
        // Se ignora el vehiculo actual para que deje modificar sus datos
        // Sino, encuentra la matricula y no deja actualizar
        $vehiculo = Vehiculo::findOrFail($id);
        $request->validate([
            'matricula' => [
                'required',
                'string',
                'size:7',
                'regex:/^\d{4}[A-Z]{3}$/',
                Rule::unique('vehiculos', 'matricula')->ignore($vehiculo->id),
            ],
            'cargaMax' => 'required',
        ]);

        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->matricula = $request->matricula;
        $vehiculo->carga_max = $request->cargaMax;
        $vehiculo->save();
        return redirect()->route('vehiculos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->delete();
        return redirect()->route('vehiculos.index');
    }
}
