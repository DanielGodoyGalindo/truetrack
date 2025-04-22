<?php

namespace App\Http\Controllers;

use App\Models\Reparto;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VehiculoController extends Controller
{
    // variables globales privadas 
    private $elementosPaginacion = 5;
    private $cargasMax = ['500', '600', '700', '800', '900', '1000'];

    /**
     * Listar todos los vehículos.
     */
    public function index()
    {
        $vehiculos = Vehiculo::paginate($this->elementosPaginacion);
        return view('vehiculos.all', compact('vehiculos'));
    }

    /**
     * Mostrar el formulario para crear un vehículo nuevo.
     */
    public function create()
    {
        $vehiculo = null;
        return view('vehiculos.form', ['vehiculo' => $vehiculo, 'cargasMax' => $this->cargasMax]);
    }

    /**
     * Guarda un nuevo vehículo con los datos recibidos del usuario.
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
     * Muestra el formulario para editar un vehículo.
     */
    public function edit(string $id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        return view('vehiculos.form', ['vehiculo' => $vehiculo, 'cargasMax' => $this->cargasMax]);
    }

    /**
     * Actualiza el vehículo indicado como parámetro.
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
     * Elimina el vehículo si no está asignado a ningun reparto.
     */
    public function destroy(string $id)
    {
        $numRepartos = Reparto::where('vehiculo_id', $id)->count();
        // Sólo borrar vehículo si no tiene ningun reparto
        if ($numRepartos == 0) {
            $vehiculo = Vehiculo::findOrFail($id);
            $vehiculo->delete();
            return redirect()->route('vehiculos.index')->with('message', 'vehicleDeleted');
        } else {
            return redirect()->route('vehiculos.index')->with('message', 'vehicleNotDeleted');
        }
    }
}
