<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalizacionSistema extends Model
{
    use HasFactory;

    protected $table = 'personalizacion_sistema';

    protected $fillable = [
        'imagen_logo',
        'nombre_sistema',
        'color_principal',
        'color_secundario',
        'color_terciario',
        'logo_footer',
        'descripcion_footer',
        'paginaWeb',
        'email',
        'telefono',
        'direccion',
        'ubicacion',
        'id_superadmin'
    ];

    public function superadmins(){
        return $this->belongsTo(Superadmin::class, 'id_superadmin');
    }

    public $timestamps = false;
}
