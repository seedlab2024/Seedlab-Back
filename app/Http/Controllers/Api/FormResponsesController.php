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
    
    public function storeSection(Request $request, $sectionId, $id_empresa)
    {
        // Buscar o crear el registro con verform_pr = 1
        $registro = Respuesta::firstOrNew([
            'id_empresa' => $id_empresa,
            'verform_pr' => 1
        ]);

        // En caso de que no exista, firstOrNew te dará un modelo nuevo en memoria
        // Asegúrate de setear verform_pr = 1 explícitamente
        $registro->verform_pr = 1;

        // Decodificar, fusionar, etc.
        $sections = json_decode($registro->respuestas_json, true) ?? [];
        $sections["section_{$sectionId}"] = $request->input('respuestas');
        $registro->respuestas_json = json_encode($sections);

        $registro->save();

        return response()->json(['message' => "Sección $sectionId guardada correctamente"], 200);
    }



    public function getAllRespuestasFromDB($id_empresa)
    {
        $respuesta = Respuesta::where('id_empresa', $id_empresa)
            ->where('verform_pr', 1)
            ->first();

        if (!$respuesta) {
            return response()->json(['message' => 'No hay respuestas guardadas aún.'], 404);
        }

        $sections = json_decode($respuesta->respuestas_json, true);

        // Transformar claves de "section_1" a "seccion1", etc.
        $transformed = [];
        foreach ($sections as $key => $value) {
            $newKey = str_replace('section_', 'seccion', $key);
            $transformed[$newKey] = $value;
        }

        return response()->json($transformed, 200);
    }
}
