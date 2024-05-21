<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesor extends Model
{
    use HasFactory;

    protected $table = 'asesor';

    protected $fillable = [
        'nombre',
        'apellido',
        'celular',
        'id_autentication',
        'id_aliado'
    ];

    public $timestamps = false;

    public function auth(){
        return $this->belongsTo(User::class, 'id_autentication');
    }
    
    public function aliado(){
        return $this->belongsTo(Aliado::class, 'id_aliado');
    }

    public function actividades(){
        return $this->hasMany(Actividad::class, 'id_asesor');
    }

    public function getNombresAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }
}
