<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperAdmin extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 
        'apellidos',
        'id_autentication'
    ];

    public $timestamps = false;

    public function auth(){
        return $this->belongsTo(Autentication::class, 'id_autentication');
    }
}
