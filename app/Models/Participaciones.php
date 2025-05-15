<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participaciones extends Model
{
    use HasFactory;
    protected $table = 'participaciones';
    protected $fillable = [
        'asociados_id',
        'actividades_id',
        'fecha_participacion',
        'monto',
        'interes',
        'estado'
    ];
    
    public function asociado()
    {
        return $this->belongsTo(Asociados::class, 'asociados_id');
    }

    public function actividades()
    {
        return $this->belongsTo(Actividades::class, 'actividades_id');
    }

}
