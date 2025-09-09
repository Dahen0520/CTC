<?php

namespace App\Http\Controllers;

use App\Models\TipoVisita;
use Illuminate\Http\Request;

class TipoVisitaController extends Controller
{
    public function index(Request $request)
    {
        $query = TipoVisita::query();
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('nombre', 'like', '%' . $searchTerm . '%');
        }

        $tipoVisitas = $query->paginate(15);
        if ($request->ajax()) {
            return response()->json([
                'table_rows' => view('tipo_visitas.partials.tipo_visitas_table_rows', compact('tipoVisitas'))->render(),
                'pagination_links' => $tipoVisitas->links()->toHtml(),
            ]);
        }
        return view('tipo_visitas.index', compact('tipoVisitas'));
    }

    public function create()
    {
        return view('tipo_visitas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'estado' => 'required|in:activo,inactivo', // Regla de validación para el estado
        ]);

        TipoVisita::create($request->all());
        return redirect()->route('tipo-visitas.index')->with('success', 'Tipo de visita creado exitosamente.');
    }

    public function show(TipoVisita $tipoVisita)
    {
        return view('tipo_visitas.show', compact('tipoVisita'));
    }

    public function edit(TipoVisita $tipoVisita)
    {
        return view('tipo_visitas.edit', compact('tipoVisita'));
    }

    public function update(Request $request, TipoVisita $tipoVisita)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'estado' => 'required|in:activo,inactivo', // Regla de validación para el estado
        ]);
        $tipoVisita->update($request->all());
        return redirect()->route('tipo-visitas.index')->with('success', 'Tipo de visita actualizado exitosamente.');
    }

    public function destroy(TipoVisita $tipoVisita)
    {
        $tipoVisita->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Tipo de visita eliminado exitosamente.']);
        }
        return redirect()->route('tipo-visitas.index')->with('success', 'Tipo de visita eliminado exitosamente.');
    }
}
