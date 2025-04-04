<?php

namespace App\Http\Controllers;

use App\Models\Envio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        $clientes = User::where('rol', 'cliente')->get();
        return view('envios.form', ['clientes' => $clientes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        $envio = new Envio();
        $envio->cliente_id = Auth::user()->id ?? 1;
        $envio->destinatario = $r->destinatario . " - " . $r->direccion_destinatario;
        $envio->bultos = $r->bultos;
        $envio->kilos = $r->kilos;
        $envio->estado = "pendiente";
        $envio->save();
        return redirect()->route('envios.index');
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
        $envio = Envio::find($id);
        $envio->delete();
        return redirect()->route('envios.index');
    }

    /* Método para mostrar la vista de envío de mail */
    public function email(string $id)
    {
        $envio = Envio::with('cliente')->findOrFail($id);;
        return view('envios.email', ['envio' => $envio]);
    }

    /* Método para que un cliente pueda enviar un email */
    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'mensaje' => 'required|string',
        ]);
        Mail::raw($request->mensaje, function ($mail) use ($request) {
            $mail->to($request->email)
                ->subject('Mensaje desde TrueTrack');
        });
        return redirect()->route('envios.index');
    }

    /* Método para cambiar estado de un envio a 'anulado' */
    public function setNull($id)
    {
        $envio = Envio::find($id);
        $envio->estado = 'anulado';
        $envio->save();
        return redirect()->back();
    }
}
