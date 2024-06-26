<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;

    protected $table = 'respuesta';

    protected $fillable = [
        'opcion',
        'texto_res',
        'valor',
        'id_pregunta',
        'id_empresa',
        'id_subpregunta',
    ];

    public function preguntas(){
        return $this->belongsTo(Preguntas::class, 'id_pregunta');
    }

    public function subpreguntas(){
        return $this->belongsTo(Subpreguntas::class, 'id_subpregunta');
    }
    
    public function empresas(){
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public $timestamps = false;


}
