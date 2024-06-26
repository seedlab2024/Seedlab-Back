<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{

    use HasFactory;

    
    protected $fillable = ['name'];

  
    public $timestamps = false;

    public function users(){
        return $this->hasMany(User::class);
    }

    public function municipios(){
        return $this->hasMany(Municipio::class);
    }
}
