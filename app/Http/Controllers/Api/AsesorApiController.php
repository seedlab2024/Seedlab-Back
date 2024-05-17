<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Asesor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AsesorApiController extends Controller
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
    public function store(Request $data)
    {
        
        $response = null;
        $statusCode = 200;
        
        if(strlen($data['password']) <8) {
            $statusCode = 400;
            $response = 'La contraseña debe tener al menos 8 caracteres';
            return response()->json(['message' => $response], $statusCode);
        }
        
        DB::transaction(function () use ($data, &$response, &$statusCode) {
        $results = DB::select('CALL sp_registrar_asesor(?, ?, ?, ?, ?, ?,?)', [
                $data['nombre'],
                $data['apellido'],
                $data['celular'],
                $data['aliado'],
                $data['email'],
                Hash::make($data['password']),
                $data['estado'],
            ]);


            if (!empty($results)) {
                $response = $results[0]->mensaje;
                if ($response === 'El nombre del asesor ya se encuentra registrado' || $response === 'El correo electrónico ya ha sido registrado anteriormente') {
                    $statusCode = 400;
                }
            } 
        });

            return response()->json(['message' => $response], $statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $asesor = Asesor::find($id);
        if(Auth::user->id_rol != 3 ){
            return response()->json([
               'message' => 'No tienes permisos para realizar esta acción'], 403);
        }

        $asesor->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'celular' => $request->celular,
            'email' => $request->email,
            'estado' => $request->estado,
        ]);
        return response()->json(['message' => 'Asesor actualizado', $asesor, 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}