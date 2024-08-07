<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    use HasFactory;

    protected $table = 'ruta';

    protected $fillable = [
        'nombre',
        'fecha_creacion',
        'estado',
        'imagen_ruta'
    ];

    public $timestamps = false;

    public function actividades(){
        return $this->hasMany(Actividad::class, 'id_ruta');
    }
}
