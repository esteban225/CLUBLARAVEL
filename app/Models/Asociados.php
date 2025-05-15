<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asociados extends Model
{
    use  HasFactory;
    protected $table = 'asociados';
    protected $fillable = [
        'documento',
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'direccion_recidencia',
        'telefono',
        'email'
    ];
    
    public function participaciones()
    {
        return $this->hasMany(Participaciones::class, 'asociados_id');
    }

    public function prestamos()
    {
        return $this->hasMany(Prestamos::class, 'asociados_id');
    }

}
