<?php

namespace App\Http\Controllers;

use App\Models\Motivo;
use Illuminate\Http\Request;

class MotivoController extends Controller
{
    /**
     * Muestra una lista de todos los motivos con paginación y búsqueda.
     */
    public function index(Request $request)
    {
        $query = Motivo::query();

        // Lógica de búsqueda
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('nombre', 'like', '%' . $searchTerm . '%');
        }

        // Paginación
        $motivos = $query->paginate(15);

        // Si la solicitud es AJAX, devuelve una respuesta JSON
        if ($request->ajax()) {
            return response()->json([
                'table_rows' => view('motivos.partials.motivos_table_rows', compact('motivos'))->render(),
                'pagination_links' => $motivos->links()->toHtml(),
            ]);
        }

        return view('motivos.index', compact('motivos'));
    }

    /**
     * Muestra el formulario para crear un nuevo motivo.
     */
    public function create()
    {
        return view('motivos.create');
    }

    /**
     * Almacena un nuevo motivo en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Motivo::create($request->all());

        return redirect()->route('motivos.index')->with('success', 'Motivo creado exitosamente.');
    }

    /**
     * Muestra los detalles de un motivo específico.
     */
    public function show(Motivo $motivo)
    {
        return view('motivos.show', compact('motivo'));
    }

    /**
     * Muestra el formulario para editar un motivo existente.
     */
    public function edit(Motivo $motivo)
    {
        return view('motivos.edit', compact('motivo'));
    }

    /**
     * Actualiza un motivo en la base de datos.
     */
    public function update(Request $request, Motivo $motivo)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $motivo->update($request->all());

        return redirect()->route('motivos.index')->with('success', 'Motivo actualizado exitosamente.');
    }

    /**
     * Elimina un motivo de la base de datos.
     */
    public function destroy(Motivo $motivo)
    {
        $motivo->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Motivo eliminado exitosamente.']);
        }

        return redirect()->route('motivos.index')->with('success', 'Motivo eliminado exitosamente.');
    }
}