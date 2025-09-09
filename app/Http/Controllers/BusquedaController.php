<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BusquedaController extends Controller
{
    /**
     * Muestra la vista con el formulario de búsqueda de afiliados.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('busqueda');
    }

    /**
     * Procesa la búsqueda, llama a la API y muestra los datos del afiliado o un error.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function buscar(Request $request)
    {
        // Obtiene el número de identificación (DNI) del formulario.
        $dni = $request->input('dni');

        // Valida que el DNI no esté vacío.
        if (empty($dni)) {
            return view('busqueda', ['error' => 'Por favor, ingrese un número de identificación.']);
        }

        try {
            // Usa las credenciales del archivo .env para autenticación.
            $response = Http::withBasicAuth(
                env('CORE_USERNAME'),
                env('CORE_PASSWORD')
            )->withHeaders([
                'APP_ID' => env('CORE_APP_ID'),
            ])->get(env('CORE_URL_BASE') . "/UDEC_ES/GET_AFILIADO/{$dni}");

            // Verifica si la llamada a la API fue exitosa (código de estado 200).
            if ($response->successful()) {
                $data = $response->json();
                
                // Si la respuesta de la API indica que el afiliado no se encontró.
                if (isset($data['status_code']) && $data['status_code'] == 2) {
                    return view('busqueda', [
                        'error' => 'Afiliado no encontrado. Verifique el número de identificación.'
                    ]);
                }

                // Pasa los datos del afiliado a la vista.
                return view('busqueda', ['afiliado' => $data]);
            } else {
                // Maneja los errores de la petición HTTP.
                $status = $response->status();
                return view('busqueda', [
                    'error' => 'Error en la llamada a la API. Código de estado: ' . $status
                ]);
            }
        } catch (\Exception $e) {
            // Captura y muestra cualquier excepción que ocurra.
            return view('busqueda', [
                'error' => 'Ocurrió una excepción al procesar la solicitud: ' . $e->getMessage()
            ]);
        }
    }
}
