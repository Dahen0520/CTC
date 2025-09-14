<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BusquedaController extends Controller
{

    public function index()
    {
        return view('busqueda');
    }

    public function buscar(Request $request)
    {
        // Obtiene el número de identificación (DNI) del formulario.
        $dni = $request->input('dni');

        // Valida que el DNI no esté vacío.
        if (empty($dni)) {
            return view('busqueda', ['error' => 'Por favor, ingrese un número de identificación.']);
        }

        try {
            $response = Http::withBasicAuth(
                env('CORE_USERNAME'),
                env('CORE_PASSWORD')
            )->withHeaders([
                'APP_ID' => env('CORE_APP_ID'),
            ])->get(env('CORE_URL_BASE') . "/UDEC_ES/GET_AFILIADO/{$dni}");

            // Verifica si la llamada a la API fue exitosa 
            if ($response->successful()) {
                $data = $response->json();
                
                // Si la respuesta de la API indica que el afiliado no se encontró.
                if (isset($data['status_code']) && $data['status_code'] == 2) {
                    return view('busqueda', [
                        'error' => 'Afiliado no encontrado. Verifique el número de identificación.'
                    ]);
                }

                return view('busqueda', ['afiliado' => $data]);
            } else {
                $status = $response->status();
                return view('busqueda', [
                    'error' => 'Error en la llamada a la API. Código de estado: ' . $status
                ]);
            }
        } catch (\Exception $e) {
            return view('busqueda', [
                'error' => 'Ocurrió una excepción al procesar la solicitud: ' . $e->getMessage()
            ]);
        }
    }
}
