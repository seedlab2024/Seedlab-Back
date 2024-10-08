<?php

namespace Database\Seeders;

use App\Models\Emprendedor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
class EmprendedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

     
    public function run(): void
    
    {

        $fotoPerfilPath = storage_path('app/public/fotoPerfil');
        if (!File::exists($fotoPerfilPath)) {
            File::makeDirectory($fotoPerfilPath, 0755, true);
        }

        Emprendedor::create([
            "documento"=> "0000000001",
            "nombre"=> "Emprendedor",
            "apellido"=> "Prueba",
            "imagen_perfil"=>"",
            "celular"=> "3122231313",
            "genero"=> "Femenino",
            "fecha_nac"=> "1998-06-03",
            "direccion"=>"Dirección por defecto",
            "email_verified_at"=>"2024/05/17",
            "cod_ver"=> "153567",
            "id_autentication"=> 5,
            "id_tipo_documento"=> 1,
            "id_departamento"=> 27,
            "id_municipio"=> 904
        ]);
        Emprendedor::create([
            "documento"=> "0000000002",
            "nombre"=> "Emprendedor",
            "apellido"=> "Prueba",
            "imagen_perfil"=>"",
            "celular"=> "312444444",
            "genero"=> "Otro",
            "fecha_nac"=> "1998-06-03",
            "direccion"=>"Dirección por defecto",
            "email_verified_at"=>"2024/05/17",
            "cod_ver"=> "183567",
            "id_autentication"=> 16,
            "id_tipo_documento"=> 1,
            "id_departamento"=> 27,
            "id_municipio"=> 904
        ]);
        Emprendedor::create([
            "documento"=> "0000000003",
            "nombre"=> "Emprendedor",
            "apellido"=> "Prueba",
            "imagen_perfil"=>"",
            "celular"=> "3122231313",
            "genero"=> "Masculino",
            "fecha_nac"=> "1998-06-03",
            "direccion"=>"Dirección por defecto",
            "email_verified_at"=>"2024/05/17",
            "cod_ver"=> "113562",
            "id_autentication"=> 15,
            "id_tipo_documento"=> 1,
            "id_departamento"=> 27,
            "id_municipio"=> 904
        ]);
        
    }
}