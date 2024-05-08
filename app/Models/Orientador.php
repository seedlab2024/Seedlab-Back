<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orientador extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 
        'apellido', 
        'celular', 
        'id_autentication'
    ];

    public $timestaps = false;

    public function auth(){
        return $this->belongsTo(Autentication::class, 'id_autentication');
    }
}
