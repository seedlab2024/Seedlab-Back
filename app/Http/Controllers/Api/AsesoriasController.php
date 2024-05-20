<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AsesoriaxAsesor;
use App\Models\Aliado;
use App\Models\Emprendedor;
use App\Models\Asesoria;
use App\Models\HorarioAsesoria;
use App\Models\Asesor;
use Illuminate\Support\Facades\DB;




class AsesoriasController extends Controller
{

    public function Guardarasesoria(Request $request)
    {
        $aliado = Aliado::where('nombre', $request->input('nom_aliado'))->first();
        $emprendedor = Emprendedor::find($request->input('doc_emprendedor'))->first();
        if (!$emprendedor) {
            return response(['message' => 'Emprendedor no encontrado',], 404);
        }
        if (!$aliado) {
            return response()->json(['error' => 'No se encontró ningún aliado con el nombre proporcionado.'], 404);
        }

        $asesoria = Asesoria::create([
            'Nombre_sol' => $request->input('nombre'),
            'notas' => $request->input('notas'),
            'isorientador' => $request->input('isorientador'),
            'asignacion' => $request->input('asignacion'),
            'fecha' => $request->input('fecha'),
            'id_aliado' => $aliado->id,
            'doc_emprendedor' => $request->input('doc_emprendedor'),
        ]);

        return response()->json(['message' => 'La asesoria se ha solicitado con exito'], 201);
    }

    public function asignarasesoria(Request $request){

        $asesoriaexiste = Asesoriaxasesor::where('id_asesoria',$request->input('id_asesoria'))->first();

        $asesorexiste = Asesor::where('id',$request->input('id_asesor'))->first();

        if(!$asesorexiste){
            return response()->json(['message' => 'Este asesor no existe en el sistema'], 201);
        }
        if($asesoriaexiste){
            return response()->json(['message' => 'Esta asesoria ya se ha asignado, edita la asignación'], 201);
        }
        $newasesoria = Asesoriaxasesor::create([
            'id_asesoria' => $request->input('id_asesoria'),
            'id_asesor' => $request->input('id_asesor'),
        ]);

        return response()->json(['message' => 'se ha asignado el asesor para esta asesoria'], 201);
    }


    public function definirhorarioasesoria(Request $request){

        $idAsesoria = $request->input('id_asesoria');
        $fecha = $request->input('fecha');

        $asesoria = Asesoria::find($idAsesoria);
        if (!$asesoria) {
            return response()->json(['message' => 'La asesoría no existe'], 404);
        }

        $existingHorario = HorarioAsesoria::where('id_asesoria', $idAsesoria)->first();
        if ($existingHorario) {
            return response()->json(['message' => 'La asesoría ya tiene una fecha asignada'], 400);
        }

            $horarioAsesoria = HorarioAsesoria::create([
                'observacion' => $request -> input('observacion'),
                'fecha' => $request -> input('fecha'),
                'estado' => $request -> input('estado'),
                'id_asesoria' => $request -> input('id_asesoria'),
            ]);
            return response()->json(['mesage'=>'Se le a asignado un horario a su Asesoria'], 201);
    }

    public function editarasignacionasesoria(Request $request){
      
        $asignacion = Asesoriaxasesor::where('id_asesoria', $request->input('id_asesoria'))->first();
        if (!$asignacion) {
            return response()->json(['message' => 'La asignación no existe en el sistema'], 404);
        }
    
        $asesor = Asesor::find($request->input('id_asesor'));
        if (!$asesor) {
            return response()->json(['message' => 'El asesor no existe en el sistema'], 404);
        }
    
        $asignacion->id_asesor = $request->input('id_asesor');
        $asignacion->save();
    
        return response()->json(['message' => 'Se ha actualizado el asesor para esta asignación'], 200);
    }


    public function traerAsesoriasPorEmprendedor(Request $request)
    {
        $documento = $request->input('documento');
        $asignacion = $request->input('asignacion');

        $query = DB::table('asesoria as o')
            ->leftJoin('asesoriaxasesor as a', 'o.id', '=', 'a.id_asesoria')
            ->leftJoin('asesor as e', 'a.id_asesor', '=', 'e.id')
            ->leftJoin('aliado as ali', 'ali.id', '=', 'o.id_aliado')
            ->leftJoin('emprendedor as em', 'o.doc_emprendedor', '=', 'em.documento')
            ->leftJoin('horarioasesoria as hr', 'o.id', '=', 'hr.id_asesoria')
            ->where('em.documento', '=', $documento)
            ->where('o.asignacion', '=', $asignacion)
            ->orderBy('o.fecha', 'desc');

        if ($asignacion) {
            $query->select(
                'o.id as id_asesoria',
                'o.Nombre_sol',
                'o.notas',
                'o.fecha as fecha_solicitud',
                'ali.nombre',
                'a.id_asesor',
                DB::raw('CONCAT(e.nombre, " ", e.apellido) as Asesor'),
                'hr.fecha',
                'hr.estado',
                'hr.observaciones as observaciones_asesor'
            );
        } else {
            $query->select(
                'o.id as id_asesoria',
                'o.Nombre_sol',
                'o.notas',
                'o.fecha as fecha_solicitud',
                DB::raw('IFNULL(ali.nombre, "Orientador - En espera de redireccionamiento") as nombre')
            );
        }

        $asesorias = $query->get();

        return response()->json($asesorias);
    }


    public function traerAsesoriasOrientador(Request $request){

    }   


}
