<?php

namespace App\Http\Controllers;

use App\Models\Envio;
use Illuminate\Http\Request;

class EnvioController extends Controller
{

    private $numPag = 5;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $r)
    {
        // Se construye una consulta con las relaciones del model Envio
        // Si viene como request el nombre de un cliente, se busca en la tabla Users
        // el usuario con el nombre indicado en el request $r
        $query  = Envio::with('cliente', 'reparto');
        if ($r->filled("cliente")) {
            $query->whereHas('cliente', function ($user) use ($r) {
                $user->where('nombre', 'like', '%' . $r->cliente . '%');
            });
        }
        $envios = $query->paginate($this->numPag)->appends(['cliente' => $r->cliente]);
        return view('envios.all', ['envios' => $envios]);
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
}
