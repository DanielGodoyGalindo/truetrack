<?php

namespace App\Http\Controllers;

use App\Models\Envio;
use App\Models\Reparto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EnvioController extends Controller
{

    private $numPag = 5;
    private $estados = ['pendiente', 'en reparto', 'entregado', 'no entregado', 'anulado'];

    /**
     * Muestra todos los envíos.
     */
    public function index()
    {
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
        // Validación backend
        $validator = Validator::make($r->all(), [
            'nombre' => ['required', 'string', 'regex:/^[\pL\s]{3,}$/'],
            'direccion' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:150'],
            'codigo_postal' => ['required', 'string', 'regex:/^\d{5}$/'],
            'poblacion' => ['required', 'string', 'regex:/^[\pL\s]{3,}$/u'],
            'bultos' => ['required', 'integer'],
            'kilos' => ['required', 'numeric'],
        ]);
        if ($validator->fails()) {
            return back()
                ->with('message', 'formInvalid')
                ->withInput();
        }
        $envio = new Envio();
        $envio->cliente_id = Auth::user()->id;
        $envio->destinatario = trim($r->nombre) . " - " . trim($r->direccion) . ", " . $r->codigo_postal . " " . trim($r->poblacion);
        $envio->email = $r->email;
        $envio->bultos = $r->bultos;
        $envio->kilos = $r->kilos;
        $envio->estado = "pendiente";
        $envio->save();
        return redirect()->route('envios.index')->with('message', 'recordCreated');
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
        // Obtener nombre, direccion, codigo postal y población a partir de
        // la cadena "destinatario" que se guarda de cada envío -> [Nombre completo] - [Dirección], [Código postal] [Población]
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
        // Validación backend
        $validator = Validator::make($r->all(), [
            'nombre' => ['required', 'string', 'regex:/^[\pL\s]{3,}$/u'],
            'direccion' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:150'],
            'codigo_postal' => ['required', 'string', 'regex:/^\d{5}$/'],
            'poblacion' => ['required', 'string', 'regex:/^[\pL\s]{3,}$/u'],
            'bultos' => ['required', 'integer'],
            'kilos' => ['required', 'numeric'],
        ]);
        if ($validator->fails()) {
            return back()
                ->with('message', 'formInvalid')
                ->withInput();
        }
        // Actualización
        $envio = Envio::findOrFail($id);
        $envio->destinatario = $r->nombre . " - " . $r->direccion . ", " . $r->codigo_postal . " " . $r->poblacion;
        $envio->email = $r->email;
        $envio->bultos = $r->bultos;
        $envio->kilos = $r->kilos;
        $envio->save();
        return redirect()->route('envios.index')->with('message', 'recordUpdated');
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
        return redirect()->route('envios.index')->with('message', 'recordDeleted');
    }

    /* Método para mostrar la vista de envío de mail */
    public function email(string $id)
    {
        $envio = Envio::with('cliente')->findOrFail($id);
        // Generar cabecera del mensaje para incluyir en el mail
        if ($envio->estado == 'no entregado')
            $envioInfo = $envio->estado . " --> " . $envio->updated_at->format('d-m-Y H:i:s') . "h";
        else
            $envioInfo = $envio->estado;
        $cabecera = <<<STR
        Información de tu envío
        -----------------------------------------
        Cliente: {$envio->cliente->name}
        Tu dirección: {$envio->destinatario}
        Bultos:  {$envio->bultos}
        Kilos: {$envio->kilos}
        Estado: {$envioInfo}
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
        return redirect()->route('envios.index')->with('message', 'emailSent');
    }

    /* Método para cambiar estado de un envio a 'anulado' */
    public function setNull($id)
    {
        $envio = Envio::find($id);
        $envio->estado = 'anulado';
        $envio->save();
        return redirect()->back()->with('message', 'shipmentCancelled');
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
        // Datos para componente Donut chart
        if (Auth::check() && Auth::user()->rol == 'cliente') {
            $pendientes = Envio::where('estado', 'pendiente')->where('cliente_id', Auth::id())->count();
            $enReparto = Envio::where('estado', 'en reparto')->where('cliente_id', Auth::id())->count();
            $noEntregados = Envio::where('estado', 'no entregado')->where('cliente_id', Auth::id())->count();
        } else {
            $pendientes = Envio::where('estado', 'pendiente')->count();
            $enReparto = Envio::where('estado', 'en reparto')->count();
            $noEntregados = Envio::where('estado', 'no entregado')->count();
        }
        $datosChart = [$pendientes, $enReparto, $noEntregados];
        return view('index', [
            'numEnviosCliente' => $numEnviosCliente,
            'numEnviosTotales' => $numEnviosTotales,
            'numRepartosGestor' => $numRepartosGestor,
            'numRepartosTotales' => $numRepartosTotales,
            'datosChart' => $datosChart
        ]);
    }

    // Mostrar los envíos que ya han sido entregados y los envíos que han sido anulados
    // Se ejecuta cuando se solicita ver envios finalizados
    public function showCompleted(Request $r)
    {
        // Se construye una consulta con las relaciones del model Envio
        // Si vienen como request las fechas de busqueda, se busca en la tabla Envios
        // los envíos que tengan la fecha de creacion entre las dos fechas que vienen en el request $r
        $enviosCompletadosCli = null;
        $enviosCompletadosNoCli = null;
        /* Si el usuario es cliente: obtener sus envios y si se reciben fechas, filtrarlos por ellas 
        appends() --> preserva las fechas entre las paginaciones
        startOfDay() y  endOfDay() permiten obtener las fechas desde el inicio del dia 00:00h hasta el final 23:59h*/
        if (Auth::check() && Auth::user()->rol == 'cliente') {
            $query  = Envio::where('cliente_id', Auth::id())->whereIn('estado', ['entregado', 'anulado']);
            if ($r->filled(['fecha1', 'fecha2'])) {
                $query->whereBetween('created_at', [Carbon::parse($r->fecha1)->startOfDay(), Carbon::parse($r->fecha2)->endOfDay()]);
            }
            $enviosCompletadosCli = $query->paginate($this->numPag)->appends($r->only(['fecha1', 'fecha2']));
            /* Si el usuario es gestor o administrador */
        } else if ((in_array(Auth::user()->rol, ['gestor_trafico', 'administrador']))) {
            $query = Envio::whereIn('estado', ['entregado', 'anulado']);
            if ($r->filled(['fecha1', 'fecha2'])) {
                $query->whereBetween('created_at', [Carbon::parse($r->fecha1)->startOfDay(), Carbon::parse($r->fecha2)->endOfDay()]);
            }
            $enviosCompletadosNoCli = $query->paginate($this->numPag)->appends($r->only(['fecha1', 'fecha2']));
        }
        return view('envios.completed', compact('enviosCompletadosCli', 'enviosCompletadosNoCli'));
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
