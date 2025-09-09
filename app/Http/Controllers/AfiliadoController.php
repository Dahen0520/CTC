<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AfiliadoController extends Controller
{
    /**
     * Verifica la existencia de un afiliado a través de una API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verificarDni(Request $request)
    {
        $request->validate(['dni' => 'required|string|max:255']);
        $dni = $request->input('dni');

        try {
            $response = Http::withBasicAuth(
                env('CORE_USERNAME'),
                env('CORE_PASSWORD')
            )->withHeaders([
                'APP_ID' => env('CORE_APP_ID'),
            ])->get(env('CORE_URL_BASE') . "/UDEC_ES/GET_AFILIADO/{$dni}");

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['status_code']) && $data['status_code'] == 2) {
                    return response()->json(['success' => false, 'message' => 'Afiliado no encontrado. Verifique el número de identificación.']);
                }

                // En el caso de que la respuesta sea exitosa
                return response()->json(['success' => true, 'afiliado' => $data]);
            } else {
                return response()->json(['success' => false, 'message' => 'Error en la llamada a la API.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Ocurrió una excepción al procesar la solicitud.']);
        }
    }
}