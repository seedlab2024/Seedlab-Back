<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subpreguntas extends Model
{
    use HasFactory;

    protected $table = 'subpregunta';

    protected $fillable = [
        'texto',
        'puntaje',
        'id_pregunta',
    ];

    public function preguntas(){
        return $this->belongsTo(Preguntas::class, 'id_pregunta');
    }

    public $timestamps = false;
}