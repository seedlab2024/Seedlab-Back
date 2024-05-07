<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    
    public function login(Request $request) {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $user = Auth::user();
        $tokenResult = $user->createToken('Personal Access Token');
    
    
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
        ]);
    }

    public function userProfile(Request $request){}

    public function logout(Request $request){
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    //Revisar si se esta utilizando
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:2', 'confirmed'],
        ]);
    }

    //Revisar si es necesario
    protected function existeusuario(string $numdocumento, string $correo)
    {
        $valuser = User::where('numdocumento', $numdocumento)->first();
        $valcorreo = User::where('email', $correo)->first();

        if ($valuser) {
            return 'Tu documento ya existe en el sistema';
        } else if ($valcorreo) {
            return 'Tu correo ya existe en el sistema';
        } else {
            return null;
        }
    }

    protected function register(Request $data)
    {
        $Response = $this->existeusuario($data['numdocumento'], $data['email']);

        if ($Response != null) {
            return response()->json(['message' => $Response], 400);
        } else {
            $verificationCode = mt_rand(10000, 99999);

            $user = User::create([
                'numdocumento' => $data['numdocumento'],
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'celular' => $data['celular'],
                'genero' => $data['genero'],
                'email' => $data['email'],
                'fecha_nacimiento' => $data['fecha_nacimiento'],
                'id_departamento' => $data['id_departamento'],
                'id_municipio' => $data['id_municipio'],
                'password' => Hash::make($data['password']),
                'id_estado' => $data['id_estado'],
                'id_tipo_documento' => $data['id_tipo_documento'],
                'id_roles' => $data['id_roles'],
                'verification_code' => $verificationCode,
            ]);

            Mail::to($user->email)->send(new VerificationCodeEmail($verificationCode));

            return response()->json(['message' => 'Tu usuario ha sido creado con exito'], 201);

        }
    }



    protected function validate_email(Request $request)
    {
        $verificationCode = $request->input('codigo');

        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            if($user->email_verified_at != null){
                return response()->json(['message' => 'Tu correo electrónico ya ha sido validado'], 400);
            }
            else{
                if ($user->verification_code === $verificationCode) {
                    $user->email_verified_at = now();
                    $user->save();
    
                    return response()->json(['message' => 'Correo electrónico validado correctamente'], 200);
                }
                else{
                    return response()->json(['message' => 'Tu codigo de verificación es incorrecto'], 400);
    
                }
            }
        } else {
            return response()->json(['message' => 'Tu correo no esta registrado en el sistema'], 400);
        }

    }



    public function allUsers()
    {
    }

}


// JSON DE EJEMPLO PARA LOS ENDPOINT


// register:
// {
//     "numdocumento": "123",
//     "nombre": "Brayan Esneider",
//     "apellido": "Figueroa Jerez",
//     "celular": "3146599453",
//     "genero": "Masculino",
//     "email": "brayanfigueroajerez@gmail.com",
//     "fecha_nacimiento": "2005-04-07",
//     "id_departamento": 1,
//     "id_municipio": 1,
//     "password": "1234",
//     "id_estado": 1,
//     "id_tipo_documento": 1,
//     "id_roles": 1 
// }

// validate_email:
// {
//     "email": "brayanfigueroajerez@gmail.com",
//     "codigo": "69838"
// }

