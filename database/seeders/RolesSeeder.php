<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rol::create(['nombre'=>'superadmin']);
        Rol::create(['nombre'=>'orientador']);
        Rol::create(['nombre'=>'aliado']);
        Rol::create(['nombre'=>'asesor']);
        Rol::create(['nombre'=>'emprendedor']);
    }
}
