<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use App\Models\Municipio;
use Illuminate\Http\Request;

class UbicacionController extends Controller
{
    public function listar_dep()
    {
        $departamentos = Departamento::select('id', 'name')->get();
        return response()->json($departamentos, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function listar_munxdep(Request $request)        
{
    // Obtener el ID del departamento del request
    $idDepartamento = $request->input('dep_id');

    // Buscar el departamento por su ID
    $departamento = Departamento::where("id", $idDepartamento)->first();

    if (!$departamento) {
        return response()->json(['error' => 'Departamento no encontrado'], 404);
    }

    // Obtener los municipios asociados con el ID del departamento
    $municipios = Municipio::where('id_departamento', $departamento->id)
        ->select('id', 'nombre')
        ->get();

    return response()->json($municipios);
}   

}

// ejemplo de usar el listar municipios por departamento
// http://127.0.0.1:8000/api/mun/?dep_name=Nariño
// en postamn llegas y le pones donde dice key: dep:name y en value el nombre del departamento
