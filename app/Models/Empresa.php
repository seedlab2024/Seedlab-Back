<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'documento',
        'cargo',
        'razonSocial',
        'urlPagina',
        'telefono',
        'celular',
        'direccion',
        'profesion',
        'experiencia',
        'funciones',
        'id_municipio',
        'id_tipo_documento',
        'id_empresa',
    ];


    public $timestamps = false;

    public function emprendedor(){
        return $this->belongsTo(Emprendedor::class, 'id_emprendedor');
    }

    public function tipoDocumento(){
        return $this->belongsTo(TipoDocumento::class, 'id_tipo_documento');
    }

    public function municipio(){
        return $this->belongsTo(Municipio::class, 'id_municipio');
    }

    public function apoyoxempresa(){
        return $this->hasMany(ApoyoEmpresa::class, 'id_empresa');
    }

    public function respuestas(){
        return $this->hasMany(Respuesta::class, 'id_empresa');
    }
}
