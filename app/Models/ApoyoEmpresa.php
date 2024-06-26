<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApoyoEmpresa extends Model
{
    use HasFactory;

    protected $table = 'apoyo_empresa';
    protected $primaryKey = 'documento';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'nombre',
        'apellido',
        'documento',
        'cargo',
        'telefono',
        'celular',
        'email',
        'id_tipo_documento',
        'id_empresa'
    ];

    public function tipoDocumento(){
        return $this->belongsTo(TipoDocumento::class, 'id_tipo_documento');
    }
   
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'id_empresa', 'documento'); // Añadir la referencia a la columna 'documento'
    }

    public $timestamps = false;
}
