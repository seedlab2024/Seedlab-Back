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
        // Se espera que 'respuestas' sea un array asociativo, por ejemplo:
        // [ 'seccion1' => [...], 'seccion2' => [...], ... ]
        $nuevasRespuestas = $request->input('respuestas');

        // Si no es un array, se inicializa como uno vacío
        if (!is_array($nuevasRespuestas)) {
            $nuevasRespuestas = [];
        }

        // Intentar obtener el registro de la primera vez
        $respuesta = Respuesta::where('id_empresa', $idEmpresa)
            ->where('verform_pr', 1)
            ->first();

        if ($respuesta) {
            // Si ya existe, se decodifica el JSON guardado para fusionar la nueva sección
            $existentes = json_decode($respuesta->respuestas_json, true);
            if (!is_array($existentes)) {
                $existentes = [];
            }
            // Fusionar: se sobreescriben las claves que vienen en las nuevas respuestas
            $fusionadas = array_replace($existentes, $nuevasRespuestas);
            $respuesta->respuestas_json = json_encode($fusionadas);
            $respuesta->save();
            $contador = 1;
        } else {
            // Si no existe, se crea el registro con las respuestas recibidas
            $respuesta = new Respuesta();
            $respuesta->verform_pr = 1;
            $respuesta->verform_se = 0;
            $respuesta->id_empresa = $idEmpresa;
            $respuesta->respuestas_json = json_encode($nuevasRespuestas);
            $respuesta->save();
            $contador = 1;
        }

        return response()->json([
            'message' => 'Respuestas guardadas correctamente',
            'contador' => $contador
        ], 200);
    }




    public function verificarEstadoFormulario($id_empresa)
    {
        // Buscar la primera respuesta
        $primeraRespuesta = Respuesta::where('id_empresa', $id_empresa)
            ->where('verform_pr', 1)
            ->first();

        if (!$primeraRespuesta) {
            // No hay registro: se trata de la primera vez
            return response()->json(['contador' => 1, 'message' => 'Primera vez no iniciada'], 200);
        }

        // Decodificar las respuestas guardadas
        $sections = json_decode($primeraRespuesta->respuestas_json, true) ?? [];

        // Verificar que estén las 5 secciones
        $requiredSections = ['section_1', 'section_2', 'section_3', 'section_4', 'section_5'];
        $incompletas = [];
        foreach ($requiredSections as $section) {
            if (!array_key_exists($section, $sections) || empty($sections[$section])) {
                $incompletas[] = $section;
            }
        }

        if (!empty($incompletas)) {
            // La primera vez está incompleta
            return response()->json([
                'contador' => 1,
                'message' => 'La primera vez está incompleta. Faltan: ' . implode(', ', $incompletas)
            ], 200);
        }

        // La primera vez está completa, ahora verificamos la segunda vez
        $segundaRespuesta = Respuesta::where('id_empresa', $id_empresa)
            ->where('verform_se', 1)
            ->first();

        if (!$segundaRespuesta) {
            // No existe registro de la segunda vez, así que contador = 2 (puede iniciarse)
            return response()->json([
                'contador' => 2,
                'message' => 'Primera vez completa. Puedes iniciar la segunda vez'
            ], 200);
        } else {
            // Sí existe un registro para la segunda vez. Revisamos si ya está completa
            $sections2 = json_decode($segundaRespuesta->respuestas_json, true) ?? [];
            $requiredSections = ['section_1', 'section_2', 'section_3', 'section_4', 'section_5'];
            $incompletas2 = [];
            foreach ($requiredSections as $section) {
                if (!array_key_exists($section, $sections2) || empty($sections2[$section])) {
                    $incompletas2[] = $section;
                }
            }

            if (!empty($incompletas2)) {
                // La segunda vez está iniciada pero incompleta
                return response()->json([
                    'contador' => 2,
                    'message'  => 'La segunda vez está incompleta. Faltan: ' . implode(', ', $incompletas2)
                ], 200);
            } else {
                // La segunda vez ya tiene las 5 secciones completas
                return response()->json([
                    'contador' => 3,
                    'message'  => 'Formulario completado dos veces'
                ], 403);
            }
        }
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
