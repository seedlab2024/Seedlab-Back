<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Respuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class FormResponsesController extends Controller
{

    // public function storeSection(Request $request, $sectionId, $id_empresa)
    // {
    //     // Buscar o crear el registro con verform_pr = 1
    //     $registro = Respuesta::firstOrNew([
    //         'id_empresa' => $id_empresa,
    //         'verform_pr' => 1
    //     ]);

    //     // En caso de que no exista, firstOrNew te dará un modelo nuevo en memoria
    //     // Asegúrate de setear verform_pr = 1 explícitamente
    //     $registro->verform_pr = 1;

    //     // Decodificar, fusionar, etc.
    //     $sections = json_decode($registro->respuestas_json, true) ?? [];
    //     $sections["section_{$sectionId}"] = $request->input('respuestas');
    //     $registro->respuestas_json = json_encode($sections);

    //     $registro->save();

    //     return response()->json(['message' => "Sección $sectionId guardada correctamente"], 200);
    // }

    public function storeSection(Request $request, $id_empresa, $sectionId, $vez)
    {
        // Si se intenta guardar en la segunda vez, validar que la primera vez esté completa
        if ($vez == 2) {
            $primeraRespuesta = Respuesta::where('id_empresa', $id_empresa)
                ->where('verform_pr', 1)
                ->first();
            if ($primeraRespuesta) {
                $sections = json_decode($primeraRespuesta->respuestas_json, true) ?? [];
                // Suponiendo que se deben tener 5 secciones: section_1 hasta section_5
                if (count($sections) < 5) {
                    return response()->json([
                        'message' => 'Debe completar todas las secciones de la primera vez antes de iniciar la segunda.'
                    ], 400);
                }
            } else {
                // Si no existe la primera vez, no se permite iniciar la segunda
                return response()->json([
                    'message' => 'No se encontró el registro de la primera vez.'
                ], 400);
            }
        }

        // Determinar el campo de validación: verform_pr para vez 1, verform_se para vez 2
        $campo = $vez == 1 ? 'verform_pr' : 'verform_se';

        // Buscar o crear el registro según la "vez"
        $registro = Respuesta::firstOrNew([
            'id_empresa' => $id_empresa,
            $campo => 1
        ]);

        // Aseguramos que se fije el valor correcto en el registro
        $registro->$campo = 1;

        // Decodificar lo que ya tenga (si hay) para fusionar las secciones
        $sections = json_decode($registro->respuestas_json, true) ?? [];

        // Actualizar la sección actual
        $newAnswers = $request->input('respuestas');
        $sections["section_{$sectionId}"] = $newAnswers;

        // Guardar de nuevo el JSON consolidado
        $registro->respuestas_json = json_encode($sections);
        $registro->save();

        return response()->json([
            'message' => "Sección {$sectionId} guardada en la vez {$vez}."
        ], 200);
    }





    // public function getAllRespuestasFromDB($id_empresa)
    // {
    //     $respuesta = Respuesta::where('id_empresa', $id_empresa)
    //         ->where('verform_pr', 1)
    //         ->first();

    //     if (!$respuesta) {
    //         return response()->json(['message' => 'No hay respuestas guardadas aún.'], 404);
    //     }

    //     $sections = json_decode($respuesta->respuestas_json, true);

    //     // Transformar claves de "section_1" a "seccion1", etc.
    //     $transformed = [];
    //     foreach ($sections as $key => $value) {
    //         $newKey = str_replace('section_', 'seccion', $key);
    //         $transformed[$newKey] = $value;
    //     }

    //     return response()->json($transformed, 200);
    // }

    public function getAllRespuestasFromDB($id_empresa, $vez)
    {
        // Decidir si buscamos verform_pr o verform_se
        if ($vez == 1) {
            $respuesta = Respuesta::where('id_empresa', $id_empresa)
                ->where('verform_pr', 1)
                ->first();
        } else {
            $respuesta = Respuesta::where('id_empresa', $id_empresa)
                ->where('verform_se', 1)
                ->first();
        }

        if (!$respuesta) {
            return response()->json(['message' => 'No hay respuestas guardadas aún.'], 404);
        }

        $sections = json_decode($respuesta->respuestas_json, true);

        // Transformar claves de "section_1" a "seccion1", etc., si así lo requiere tu front
        $transformed = [];
        foreach ($sections as $key => $value) {
            $newKey = str_replace('section_', 'seccion', $key);
            $transformed[$newKey] = $value;
        }

        return response()->json($transformed, 200);
    }
}
