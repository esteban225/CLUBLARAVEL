<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividades extends Model
{
    use HasFactory;
    protected $table = 'actividades';
    protected $fillable = [
        'nombre_actividad',
        'fecha_actividad',
        'total_recaudado'
    ];

    public function participaciones()
    {
        return $this->hasMany(Participaciones::class, 'actividades_id');
    }


    
}
