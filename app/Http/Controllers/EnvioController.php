<?php

namespace App\Http\Controllers;

use App\Models\Envio;
use App\Models\Reparto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EnvioController extends Controller
{

    private $numPag = 5;
    private $estados = ['pendiente', 'en reparto', 'entregado', 'no entregado', 'anulado'];

    /**
     * Muestra todos los envíos.
     */
    public function index(Request $r)
    {
        // Se construye una consulta con las relaciones del model Envio
        // Si viene como request el nombre de un cliente, se busca en la tabla Users
        // el usuario con el nombre indicado en el request $r
        // $query  = Envio::with('cliente', 'reparto')->where('cliente_id', Auth::id());
        // if ($r->filled("cliente")) {
        //     $query->whereHas('cliente', function ($user) use ($r) {
        //         $user->where('nombre', 'like', '%' . $r->cliente . '%');
        //     });
        // }
        // $envios = $query->paginate($this->numPag)->appends(['cliente' => $r->cliente]);

        $enviosCliente = Envio::with('cliente', 'reparto')->where('cliente_id', Auth::id())->whereNotIn('estado', ['entregado', 'anulado'])->paginate($this->numPag);
        $enviosTotales = Envio::with('cliente', 'reparto')->whereNotIn('estado', ['entregado', 'anulado'])->paginate($this->numPag);
        return view('envios.all', ['enviosCliente' => $enviosCliente, 'enviosTotales' => $enviosTotales]);
    }

    /**
     * Mostrar formulario para crear un envío.
     */
    public function create()
    {
        if (Auth::user()->rol !== 'cliente') {
            abort(403, 'No tienes permiso para acceder');
        }
        $envio = null;
        $clientes = User::where('rol', 'cliente')->get();
        return view('envios.form', ['clientes' => $clientes, 'envio' => $envio]);
    }

    /**
     * Guarda un nuevo envío con los datos obtenidos.
     */
    public function store(Request $r)
    {
        if (Auth::user()->rol !== 'cliente') {
            abort(403, 'No tienes permiso para acceder');
        }
        // Validación
        $r->validate([
            'nombre' => ['required', 'string'],
            'direccion' => ['required', 'string'],
            'codigo_postal' => ['required', 'string', 'regex:/^\d{5}$/'],
            'poblacion' => ['required', 'string'],
            'bultos' => ['required', 'integer'],
            'kilos' => ['required', 'numeric'],
        ]);
        $envio = new Envio();
        $envio->cliente_id = Auth::user()->id;
        $envio->destinatario = trim($r->nombre) . " - " . trim($r->direccion) . ", " . $r->codigo_postal . " " . trim($r->poblacion);
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
     * Muestra el formulario para editar un envío.
     */
    public function edit(string $id)
    {
        if (Auth::user()->rol !== 'cliente') {
            abort(403, 'No tienes permiso para acceder');
        }
        $envio = Envio::findOrFail($id);
        // Obtener partes de la cadena "destinatario" -> [Nombre completo] - [Dirección], [Código postal] [Población]
        preg_match('/^(.*?)\s*-\s*(.*?),\s*(\d{5})\s+(.*)$/', $envio->destinatario, $subcadenas);
        $nombre = $subcadenas[1];
        $direccion = $subcadenas[2];
        $codigo_postal = $subcadenas[3];
        $poblacion = $subcadenas[4];
        return view('envios.form', compact('envio', 'nombre', 'direccion', 'codigo_postal', 'poblacion') + ['estados' => $this->estados]);
    }

    /**
     * Actualiza el envio cuyo id se recibe como parámetro.
     */
    public function update(Request $r, string $id)
    {
        if (Auth::user()->rol !== 'cliente') {
            abort(403, 'No tienes permiso para acceder');
        }
        // Validación
        $r->validate([
            'nombre' => ['required', 'string'],
            'direccion' => ['required', 'string'],
            'codigo_postal' => ['required', 'string', 'regex:/^\d{5}$/'],
            'poblacion' => ['required', 'string'],
            'bultos' => ['required', 'integer'],
            'kilos' => ['required', 'numeric'],
        ]);
        // Actualización
        $envio = Envio::findOrFail($id);
        $envio->destinatario = $r->nombre . " - " . $r->direccion . ", " . $r->codigo_postal . " " . $r->poblacion;
        $envio->bultos = $r->bultos;
        $envio->kilos = $r->kilos;
        $envio->save();
        return redirect()->route('envios.index');
    }

    /**
     * Borra un envío.
     */
    public function destroy(string $id)
    {
        if (Auth::user()->rol !== 'administrador') {
            abort(403, 'No tienes permiso para acceder');
        }
        $envio = Envio::findOrFail($id);
        $envio->delete();
        return redirect()->route('envios.index');
    }

    /* Método para mostrar la vista de envío de mail */
    public function email(string $id)
    {
        $envio = Envio::with('cliente')->findOrFail($id);
        // Generar cabecera del mensaje para incluyir en el mail
        $cabecera = <<<STR
        Información de tu envío
        -----------------------
        Cliente: {$envio->cliente->name}
        Tu dirección: {$envio->destinatario}
        Bultos:  {$envio->bultos}
        Kilos: {$envio->kilos}
        Estado: {$envio->estado}
        STR;
        return view('envios.email', ['envio' => $envio, 'cabecera' => $cabecera]);
    }

    /* Método para que un cliente pueda enviar un email */
    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email:rfc,dns'],
            'mensaje' => ['required', 'string'],
        ]);
        Mail::raw($request->cabecera . "\n\n" . $request->mensaje, function ($mail) use ($request) {
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

    /* Método para devolver el número total de envíos no entregados ni anulados */
    /* Se usa en index para mostrar los datos en los componentes card de Vue  y para redireccionar a los transportistas */
    public function showDatosIndex()
    {
        // Comprobar si el usuario es transportista
        if (Auth::check() && Auth::user()->rol == 'transportista') {
            return redirect()->route('driver.distributions', ['id' => Auth::user()->id]);
        }

        // Devolver números enteros //
        // Devuelve el número de envios que corresponsen al usuario cliente que está autenticado
        $numEnviosCliente = Envio::whereNotIn('estado', ['entregado', 'anulado'])
            ->where('cliente_id', Auth::id())
            ->count();
        // Devuelve el número total de envios (para mostrarselos a los gestores)
        $numEnviosTotales = Envio::whereNotIn('estado', ['entregado', 'anulado'])->count();
        // Devuelve el número de repartos que corresponsen al usuario gestor de tráfico que está autenticado
        $numRepartosGestor = Reparto::whereNotIn('estado', ['finalizado'])
            ->where('gestor_id', Auth::id())
            ->count();
        // Devuelve el número total de repartos (para mostrarselos al admin)
        $numRepartosTotales = Reparto::whereNotIn('estado', ['finalizado'])->count();
        return view('index', ['numEnviosCliente' => $numEnviosCliente, 'numEnviosTotales' => $numEnviosTotales, 'numRepartosGestor' => $numRepartosGestor, 'numRepartosTotales' => $numRepartosTotales]);
    }

    // Mostrar los envíos que ya han sido entregados y los envíos que han sido anulados
    // Se ejecuta cuando se solicita ver envios finalizados
    public function showCompleted()
    {
        $enviosCompletadosCli = Envio::where('cliente_id', Auth::id())->whereIn('estado', ['entregado', 'anulado'])->paginate($this->numPag);
        $enviosCompletadosNoCli = Envio::whereIn('estado', ['entregado', 'anulado'])->paginate($this->numPag);
        return view('envios.completed', ['enviosCompletadosCli' => $enviosCompletadosCli, 'enviosCompletadosNoCli' => $enviosCompletadosNoCli]);
    }

    // Método para que Transportista pueda actualizar el estado de un envío
    public function actualizarEnvio(Request $r, $envioId)
    {
        $envio = Envio::findOrFail($envioId);
        $envio->estado = $r->estado;
        $envio->informacion = $envio->estado == 'no entregado' ? $r->informacion : null;
        $envio->save();
        return redirect()->route('driver.deliveries', $envio->reparto_id);
    }
}
