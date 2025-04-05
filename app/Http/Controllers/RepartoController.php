<?php

namespace App\Http\Controllers;

use App\Models\Reparto;
use Illuminate\Http\Request;

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
        $reparto = Reparto::find($id);
        $reparto->delete();
        return redirect()->route('repartos.index');
    }
}
