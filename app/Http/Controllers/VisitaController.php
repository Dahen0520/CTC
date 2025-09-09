<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use App\Models\TipoVisita;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class VisitaController extends Controller
{
    /**
     * Muestra una lista de todas las visitas con paginación y búsqueda.
     */
    public function index(Request $request)
    {
        $query = Visita::with('tipoVisita');

        // Filtro de búsqueda general
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('fecha', 'like', '%' . $searchTerm . '%')
                  ->orWhere('numero_identidad', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('tipoVisita', function($q) use ($searchTerm) {
                      $q->where('nombre', 'like', '%' . $searchTerm . '%');
                  });
        }

        // Filtro por tipo de visita
        if ($request->filled('tipo_visita_id')) {
            $query->where('tipo_visita_id', $request->tipo_visita_id);
        }

        // Lógica de filtro de fecha mejorada
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        if ($fechaInicio && $fechaFin) {
            // Si ambas fechas están presentes, busca en el rango
            $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        } elseif ($fechaInicio) {
            // Si solo se da la fecha de inicio, busca ese día específico
            $query->whereDate('fecha', $fechaInicio);
        } elseif ($fechaFin) {
            // Si solo se da la fecha de fin, busca ese día específico
            $query->whereDate('fecha', $fechaFin);
        }


        $visitas = $query->latest()->paginate(15)->appends($request->query());
        $tiposVisita = TipoVisita::where('estado', 'activo')->get(); // Para el dropdown de filtros

        if ($request->ajax()) {
            return response()->json([
                'table_rows' => view('visitas.partials.visitas_table_rows', compact('visitas'))->render(),
                'pagination_links' => $visitas->links()->toHtml(),
            ]);
        }
        return view('visitas.index', compact('visitas', 'tiposVisita'));
    }

    /**
     * Muestra el formulario para crear una visita, con un formulario sencillo.
     */
    public function create()
    {
        $tiposVisita = TipoVisita::where('estado', 'activo')->get();
        return view('visitas.create', compact('tiposVisita'));
    }

    /**
     * Muestra el formulario para registrar una nueva visita, con la lógica del modal.
     */
    public function registrar()
    {
        $tiposVisita = TipoVisita::where('estado', 'activo')->get();
        return view('visitas.registrar', compact('tiposVisita'));
    }

    /**
     * Almacena una nueva visita en la base de datos.
     */
public function store(Request $request)
    {
        $rules = [
            'visitas' => 'required|array',
            'visitas.*' => 'integer|min:0',
            'afiliado_dni' => 'array',
            'afiliado_dni.*' => 'nullable|string|max:255',
        ];

        $request->validate($rules);

        $visitasSeleccionadas = $request->input('visitas');
        $afiliadosDNI = $request->input('afiliado_dni', []);
        $afiliadoDniIndex = 0;

        foreach ($visitasSeleccionadas as $tipoVisitaId => $cantidad) {
            if ($cantidad > 0) {
                for ($i = 0; $i < $cantidad; $i++) {
                    $numeroIdentidad = null;
                    $tipoVisita = TipoVisita::find($tipoVisitaId);
                    
                    if ($tipoVisita && $tipoVisita->nombre === 'Afiliado') {
                        if (isset($afiliadosDNI[$afiliadoDniIndex])) {
                            $numeroIdentidad = $afiliadosDNI[$afiliadoDniIndex];
                            $afiliadoDniIndex++;
                        }
                    }

                    if ($tipoVisita) { // Asegurarse que el tipo de visita existe
                        Visita::create([
                            'tipo_visita_id' => $tipoVisitaId,
                            'fecha' => Carbon::now(),
                            'numero_identidad' => $numeroIdentidad,
                            'precio' => $tipoVisita->precio,
                        ]);
                    }
                }
            }
        }
        
        // Si la solicitud es AJAX, devuelve una respuesta JSON de éxito.
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Visita(s) registrada(s) exitosamente.']);
        }
        
        // Si no es AJAX, redirige como antes.
        return redirect()->route('visitas.registrar')->with('success', 'Visita(s) registrada(s) exitosamente.');
    }

    /**
     * Muestra los detalles de una visita específica.
     */
    public function show(Visita $visita)
    {
        return view('visitas.show', compact('visita'));
    }

    /**
     * Muestra el formulario para editar una visita existente.
     */
    public function edit(Visita $visita)
    {
        $tiposVisita = TipoVisita::all();
        return view('visitas.edit', compact('visita', 'tiposVisita'));
    }

    /**
     * Actualiza una visita en la base de datos.
     */
    public function update(Request $request, Visita $visita)
    {
        $request->validate([
            'tipo_visita_id' => 'required|exists:tipo_visitas,id',
            'fecha' => 'required|date',
            'numero_identidad' => 'nullable|string|max:255',
        ]);

        $visita->update($request->all());
        return redirect()->route('visitas.index')->with('success', 'Visita actualizada exitosamente.');
    }

    /**
     * Elimina una visita de la base de datos.
     */
    public function destroy(Visita $visita)
    {
        $visita->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Visita eliminada exitosamente.']);
        }
        return redirect()->route('visitas.index')->with('success', 'Visita eliminada exitosamente.');
    }
}



