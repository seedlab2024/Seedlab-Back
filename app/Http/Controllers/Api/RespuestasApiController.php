<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Respuesta;
use App\Models\Seccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis; // Agregar esta línea


class RespuestasApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
        // Carga la sección junto con sus preguntas, subpreguntas y respuestas relacionadas.
        $seccion = Seccion::with(['preguntas.subpreguntas.respuestas', 'preguntas.respuestas'])
            ->where('id', $id)
            ->first();

        // Verifica si la sección existe; si no, retorna un mensaje de error.
        if (!$seccion) {
            return response()->json(['message' => 'Seccion no encontrada'], 404);
        }

        // Retorna la sección en formato JSON con un código de estado 200.
        return response()->json($seccion, 200);
    }

    public function guardarRespuestas(Request $request)
    {
        $idEmpresa = $request->input('id_empresa');

        // Verificar si ya existe un registro de respuestas para la primera vez
        $primeraRespuesta = Respuesta::where('id_empresa', $idEmpresa)
            ->where('verform_pr', 1)
            ->first();

        if (!$primeraRespuesta) {
            // Si no hay respuestas previas, se está llenando por primera vez
            $respuestas = new Respuesta();
            $respuestas->verform_pr = 1;  // Indicar que es la primera vez
            $respuestas->verform_se = 0;  // Aún no se llena la segunda vez
            $contador = 1;
        } else {
            // Si ya existe un registro para la primera vez, se crea uno nuevo para la segunda vez
            $segundaRespuesta = Respuesta::where('id_empresa', $idEmpresa)
                ->where('verform_se', 1)
                ->first();

            if ($segundaRespuesta) {
                return response()->json(['message' => 'El formulario ya fue llenado dos veces'], 400);
            }

            // Crear un nuevo registro para la segunda vez
            $respuestas = new Respuesta();
            $respuestas->verform_pr = 0;  // No es la primera vez
            $respuestas->verform_se = 1;  // Indicar que es la segunda vez
            $contador = 2;
        }

        // Guardar las nuevas respuestas
        $jsonRespuestas = json_encode($request->input('respuestas'));
        $respuestas->respuestas_json = $jsonRespuestas;
        $respuestas->id_empresa = $idEmpresa;
        $respuestas->save();

        // Borrar las secciones almacenadas en Redis después de guardar en la BD
        $keys = [
            "form:{$idEmpresa}:section:1",
            "form:{$idEmpresa}:section:2",
            "form:{$idEmpresa}:section:3",
            "form:{$idEmpresa}:section:4",
            "form:{$idEmpresa}:section:5",
        ];

        // Eliminar todas las claves de Redis para esta empresa y sus secciones
        Redis::del($keys);

        return response()->json(['message' => 'Respuestas guardadas correctamente', 'contador' => $contador], 200);
    }


    public function verificarEstadoFormulario($id_empresa)
    {
        // Verificar si ya existe un registro de respuestas para la primera vez
        $primeraRespuesta = Respuesta::where('id_empresa', $id_empresa)
            ->where('verform_pr', 1)
            ->first();

        if (!$primeraRespuesta) {
            // Si no hay respuestas previas, es la primera vez
            return response()->json(['contador' => 1], 200);
        }

        // Verificar si ya fue llenado por segunda vez
        $segundaRespuesta = Respuesta::where('id_empresa', $id_empresa)
            ->where('verform_se', 1)
            ->first();

        if ($segundaRespuesta) {
            // Ya se ha llenado dos veces
            return response()->json(['contador' => 3, 'message' => 'Formulario completado dos veces'], 403);
        }

        // Si ya se llenó la primera vez pero no la segunda
        return response()->json(['contador' => 2], 200);
    }






    public function getAnswers($id_empresa)
    {
        // Busca las respuestas en la tabla "Respuesta" donde el campo "id_empresa" coincide con el ID proporcionado
        $respuestas = Respuesta::where('id_empresa', $id_empresa)->first();

        // Si no se encuentran respuestas para esa empresa, devolver un mensaje de error en formato JSON con un código de estado 404 (no encontrado)
        if (!$respuestas) {
            return response()->json([
                'message' => 'No se encontraron respuestas para esta empresa' // Mensaje de que no se encontraron respuestas
            ], 404);
        }

        // Si se encuentran respuestas, decodificar el campo 'respuestas_json' que contiene las respuestas en formato JSON
        // y devolverlo en la respuesta con un código de estado 200 (éxito)
        return response()->json([
            'respuestas' => json_decode($respuestas->respuestas_json) // Decodificar el JSON de las respuestas
        ], 200);
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
        //
    }
}
